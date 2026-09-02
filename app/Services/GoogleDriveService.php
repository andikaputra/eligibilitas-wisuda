<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleDriveService
{
    protected ?Client $client = null;
    protected ?Drive $service = null;
    protected ?string $masterFolderId = null;

    public function __construct()
    {
        $this->masterFolderId = config('services.google_drive.folder_id') ?? env('GOOGLE_DRIVE_FOLDER_ID');
        $clientId = config('services.google_drive.client_id') ?? env('GOOGLE_DRIVE_CLIENT_ID');
        $clientSecret = config('services.google_drive.client_secret') ?? env('GOOGLE_DRIVE_CLIENT_SECRET');
        $refreshToken = config('services.google_drive.refresh_token') ?? env('GOOGLE_DRIVE_REFRESH_TOKEN');
        $credentialsPath = base_path(config('services.google_drive.credentials_path', 'storage/app/google/service-account.json'));

        try {
            $this->client = new Client();
            $this->client->addScope(Drive::DRIVE);

            // Opsi 1: Menggunakan OAuth 2.0 (User Account - Kuota 1 TB Drive Saya)
            if (!empty($clientId) && !empty($clientSecret) && !empty($refreshToken)) {
                $this->client->setClientId($clientId);
                $this->client->setClientSecret($clientSecret);
                $this->client->refreshToken($refreshToken);
                $this->service = new Drive($this->client);
                return;
            }

            // Opsi 2: Menggunakan Service Account JSON
            if (file_exists($credentialsPath)) {
                $this->client->setAuthConfig($credentialsPath);
                $this->service = new Drive($this->client);
                return;
            }

            Log::warning("Google Drive credentials not configured (neither OAuth nor Service Account).");
        } catch (Exception $e) {
            Log::error("Failed to initialize Google Drive Client: " . $e->getMessage());
        }
    }

    /**
     * Memeriksa apakah koneksi Google Drive sudah siap
     */
    public function isConfigured(): bool
    {
        return $this->service !== null && !empty($this->masterFolderId);
    }

    /**
     * Mengambil ID master folder
     */
    public function getMasterFolderId(): ?string
    {
        return $this->masterFolderId;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function getDriveService(): ?Drive
    {
        return $this->service;
    }

    /**
     * Mencari atau membuat folder berdasarkan nama dan parent ID
     */
    public function findOrCreateFolder(string $folderName, ?string $parentId = null): string
    {
        if (!$this->isConfigured()) {
            throw new Exception("Google Drive Service belum terkonfigurasi dengan benar.");
        }

        $parentId = $parentId ?: $this->masterFolderId;

        // Escape single quote dalam nama folder
        $escapedName = str_replace("'", "\\'", $folderName);
        $query = "name = '{$escapedName}' and mimeType = 'application/vnd.google-apps.folder' and trashed = false";

        if ($parentId) {
            $query .= " and '{$parentId}' in parents";
        }

        try {
            $response = $this->service->files->listFiles([
                'q' => $query,
                'spaces' => 'drive',
                'fields' => 'files(id, name, webViewLink)',
                'pageSize' => 1,
                'supportsAllDrives' => true,
                'includeItemsFromAllDrives' => true,
            ]);

            $files = $response->getFiles();

            if (!empty($files)) {
                return $files[0]->getId();
            }

            // Jika folder belum ada, buat folder baru
            $folderMetadata = new DriveFile([
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => $parentId ? [$parentId] : [],
            ]);

            $folder = $this->service->files->create($folderMetadata, [
                'fields' => 'id, name, webViewLink',
                'supportsAllDrives' => true,
            ]);

            // Set permission agar folder bisa dibuka oleh siapa saja yang memiliki link
            $this->setPublicPermission($folder->getId());

            return $folder->getId();
        } catch (Exception $e) {
            Log::error("Error in findOrCreateFolder ('{$folderName}'): " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mengatur hak akses file/folder agar dapat dilihat oleh siapa saja yang memiliki link
     */
    public function setPublicPermission(string $fileOrFolderId): void
    {
        try {
            $permission = new Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);

            $this->service->permissions->create($fileOrFolderId, $permission, [
                'supportsAllDrives' => true,
            ]);
        } catch (Exception $e) {
            // Abaikan jika permission sudah ada atau domain policy mengatur sebaliknya
            Log::warning("Notice on setPublicPermission for ID {$fileOrFolderId}: " . $e->getMessage());
        }
    }

    /**
     * Upload sebuah file ke folder tertentu di Google Drive
     */
    public function uploadFile(UploadedFile $file, string $targetFolderId, ?string $customFileName = null): DriveFile
    {
        if (!$this->isConfigured()) {
            throw new Exception("Google Drive Service belum terkonfigurasi dengan benar.");
        }

        $fileName = $customFileName ?: $file->getClientOriginalName();
        $mimeType = $file->getClientMimeType() ?: 'application/octet-stream';

        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$targetFolderId],
        ]);

        $content = file_get_contents($file->getRealPath());

        $createdFile = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id, name, webViewLink, webContentLink',
            'supportsAllDrives' => true,
        ]);

        // Set permission view
        $this->setPublicPermission($createdFile->getId());

        return $createdFile;
    }

    /**
     * Mengunggah beberapa foto mahasiswa ke Google Drive
     * Struktur: Master Folder -> Angkatan [Tahun] -> [NIM] - [Nama Mahasiswa] -> Foto
     *
     * @param \App\Models\User $user
     * @param array<UploadedFile> $files
     * @param string|null $angkatan
     * @return string URL webViewLink folder mahasiswa di Google Drive
     */
    public function uploadStudentPhotos($user, array $files, ?string $angkatan = null): string
    {
        if (!$this->isConfigured()) {
            throw new Exception("Layanan Google Drive belum siap. Pastikan file service-account.json dan GOOGLE_DRIVE_FOLDER_ID sudah terpasang.");
        }

        // 1. Tentukan nama folder angkatan
        $tahunAngkatan = $angkatan ?: ($user->angkatan ?: $this->extractAngkatanFromNim($user->username));
        $cohortFolderName = $tahunAngkatan ? "Angkatan {$tahunAngkatan}" : "Angkatan Sebelumnya";

        // 2. Dapatkan atau buat folder Angkatan di Master Folder
        $cohortFolderId = $this->findOrCreateFolder($cohortFolderName, $this->masterFolderId);

        // 3. Dapatkan atau buat folder Mahasiswa: [NIM] - [Nama Mahasiswa]
        $cleanName = preg_replace('/[^\p{L}\p{N}\s\-\.]/u', '', $user->name);
        $studentFolderName = "{$user->username} - {$cleanName}";
        $studentFolderId = $this->findOrCreateFolder($studentFolderName, $cohortFolderId);

        // 4. Upload file-file foto ke dalam folder mahasiswa
        $counter = 1;
        $totalFiles = count($files);

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            
            // Beri label deskriptif jika ada 2 file: 1 = Pas Foto, 2 = Foto Keluarga
            if ($totalFiles === 2 && $counter === 1) {
                $label = "Pas_Foto";
            } elseif ($totalFiles === 2 && $counter === 2) {
                $label = "Foto_Keluarga";
            } else {
                $label = "Foto_" . $counter;
            }

            $customFileName = "{$user->username}_{$cleanName}_{$label}.{$extension}";
            $this->uploadFile($file, $studentFolderId, $customFileName);
            $counter++;
        }

        // 5. Kembalikan link folder mahasiswa di Google Drive
        return "https://drive.google.com/drive/folders/{$studentFolderId}";
    }

    /**
     * Bantuan mengekstrak tahun angkatan dari awalan NIM jika memungkinkan (contoh: 2101001 -> 2021)
     */
    protected function extractAngkatanFromNim(string $nim): ?string
    {
        $nim = trim($nim);
        if (preg_match('/^20([0-9]{2})/', $nim, $matches)) {
            return '20' . $matches[1];
        }
        if (preg_match('/^([0-9]{2})[0-9]{3,}/', $nim, $matches)) {
            $prefix = (int)$matches[1];
            if ($prefix >= 10 && $prefix <= 35) {
                return '20' . $matches[1];
            }
        }
        return null;
    }
}

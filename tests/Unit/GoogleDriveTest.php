<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GoogleDriveService;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class GoogleDriveTest extends TestCase
{
    public function test_google_drive_service_configuration(): void
    {
        $service = new GoogleDriveService();
        $this->assertTrue($service->isConfigured(), "Google Drive service should be configured");
        $this->assertEquals(env('GOOGLE_DRIVE_FOLDER_ID'), $service->getMasterFolderId());
    }

    public function test_google_drive_api_connection_and_folder_lookup(): void
    {
        $service = new GoogleDriveService();
        $folderId = $service->findOrCreateFolder('Testing System Drive');
        $this->assertNotEmpty($folderId, "Should return a valid Google Drive folder ID");
    }

    public function test_student_photo_upload_flow(): void
    {
        $service = new GoogleDriveService();

        // Buat mock user
        $user = new User([
            'username' => '2401001',
            'name' => 'Budi Santoso',
            'prodi' => 'Sistem Informasi',
            'angkatan' => '2024',
        ]);

        // Buat dummy image
        $file1 = UploadedFile::fake()->image('pas_foto_budi.jpg', 400, 600);
        $file2 = UploadedFile::fake()->image('foto_keluarga_budi.jpg', 800, 600);

        $folderLink = $service->uploadStudentPhotos($user, [$file1, $file2], '2024');

        $this->assertStringStartsWith('https://drive.google.com/drive/folders/', $folderLink);
    }
}

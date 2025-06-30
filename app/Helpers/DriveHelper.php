<?php

namespace App\Helpers;

class DriveHelper
{
    public static function getDriveFileId($url)
    {
        // Pola 1: /d/FILE_ID/
        if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Pola 2: id=FILE_ID
        if (preg_match('/id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public static function getDriveThumbnailUrl($url)
    {
        $fileId = self::getDriveFileId($url);
        return $fileId ? "https://drive.google.com/uc?export=view&id=" . $fileId : null;
    }

    public static function getDrivePreviewUrl($url)
    {
        $fileId = self::getDriveFileId($url);
        return $fileId ? "https://drive.google.com/file/d/" . $fileId . "/preview" : null;
    }
}

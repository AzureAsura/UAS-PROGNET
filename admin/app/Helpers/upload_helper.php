<?php
// admin/app/Helpers/upload_helper.php

class UploadHelper {
    private $uploadPath = "../uploads/";
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function upload($file, $oldFile = null) {
        if (empty($file['name'])) {
            return $oldFile;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $this->allowedExtensions)) {
            throw new Exception("Invalid file type. Allowed: " . implode(', ', $this->allowedExtensions));
        }

        $filename = time() . '.' . $extension;
        $destination = $this->uploadPath . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Failed to upload file");
        }

        if ($oldFile && file_exists($this->uploadPath . $oldFile)) {
            unlink($this->uploadPath . $oldFile);
        }

        return $filename;
    }

    public function delete($filename) {
        $filePath = $this->uploadPath . $filename;
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    public function setUploadPath($path) {
        $this->uploadPath = $path;
        return $this;
    }
}
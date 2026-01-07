<?php

require_once __DIR__ . '/../../config/db-config.php';  

class Category extends Database
{
    private $table = 'tb_kategori';
    private $uploadPath = '../../uploads/';  

    public function __construct()
    {
        parent::__construct();
    }

public function create(array $data, array $file): array
{
    $response = ['status' => false, 'message' => ''];

    $name             = trim($data['nama_kategori'] ?? '');
    $slug             = trim($data['slug'] ?? '');
    $description      = trim($data['deskripsi'] ?? '');
    $meta_title       = trim($data['meta_title'] ?? '');
    $meta_description = trim($data['meta_description'] ?? '');
    $meta_keywords    = trim($data['meta_keywords'] ?? '');

    $status  = isset($data['status']) ? 1 : 0;
    $popular = isset($data['popularitas']) ? 1 : 0;

    $filename = $this->handleImageUpload($file, 'gambar');
    if ($filename === false && !empty($file['gambar']['name'])) {
        $response['message'] = 'Gagal mengupload gambar. Pastikan format jpg, jpeg, png, atau webp.';
        return $response;
    }

    $filename = $filename ?: '';  

    $query = "INSERT INTO {$this->table} 
              (nama_kategori, slug, deskripsi, meta_title, meta_description, meta_keywords, status, popularitas, gambar)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        $response['message'] = 'Prepare statement gagal: ' . $this->conn->error;
        return $response;
    }

    $stmt->bind_param(
        "ssssssiis", 
        $name,
        $slug,
        $description,
        $meta_title,
        $meta_description,
        $meta_keywords,
        $status,
        $popular,
        $filename
    );

    if ($stmt->execute()) {
        $response['status']  = true;
        $response['message'] = 'Kategori berhasil ditambahkan!';
    } else {
        $response['message'] = 'Gagal menambahkan kategori: ' . $stmt->error;
    }

    $stmt->close();
    return $response;
}


private function handleImageUpload(array $file, string $fieldName): string|false
{
    if (empty($file[$fieldName]['name']) || $file[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return '';  
    }

    $originalName = $file[$fieldName]['name'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    if (!in_array($ext, $allowed)) {
        return false;  
    }

    $filename = time() . '.' . $ext;

    $destination = $this->uploadPath . $filename;

    if (move_uploaded_file($file[$fieldName]['tmp_name'], $destination)) {
        return $filename;
    }

    return false;  
}

    public function update(int $id, array $data, array $file): array
    {
        $response = ['status' => false, 'message' => ''];

        if ($id <= 0) {
            $response['message'] = 'ID kategori tidak valid';
            return $response;
        }

        $name             = trim($data['nama_kategori'] ?? '');
        $slug             = trim($data['slug'] ?? '');
        $description      = trim($data['deskripsi'] ?? '');
        $meta_title       = trim($data['meta_title'] ?? '');
        $meta_description = trim($data['meta_description'] ?? '');
        $meta_keywords    = trim($data['meta_keywords'] ?? '');

        $status  = isset($data['status']) ? 1 : 0;
        $popular = isset($data['popularitas']) ? 1 : 0;

        $old_image = trim($data['old_image'] ?? '');

        if (!empty($file['gambar']['name']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $new_filename = $this->handleImageUpload($file, 'gambar');
            if ($new_filename === false) {
                $response['message'] = 'Gagal mengupload gambar baru';
                return $response;
            }

            if ($old_image && file_exists($this->uploadPath . $old_image)) {
                @unlink($this->uploadPath . $old_image);
            }

            $filename = $new_filename;
        } else {
            $filename = $old_image; 
        }

        $query = "UPDATE {$this->table} SET 
                nama_kategori = ?, slug = ?, deskripsi = ?,
                meta_title = ?, meta_description = ?, meta_keywords = ?,
                status = ?, popularitas = ?, gambar = ?
                WHERE id_kategori = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            $response['message'] = 'Prepare statement gagal: ' . $this->conn->error;
            return $response;
        }

        $stmt->bind_param(
            "ssssssiisi",
            $name,
            $slug,
            $description,
            $meta_title,
            $meta_description,
            $meta_keywords,
            $status,
            $popular,
            $filename,
            $id
        );

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Kategori berhasil diperbarui!';
        } else {
            $response['message'] = 'Gagal update kategori: ' . $stmt->error;
        }

        $stmt->close();
        return $response;
    }


public function delete(int $id): array
{
    $response = ['status' => false, 'message' => ''];

    if ($id <= 0) {
        $response['message'] = 'ID kategori tidak valid';
        return $response;
    }


    $categoryData = $this->getById($id);
    if (!$categoryData) {
        $response['message'] = 'Kategori tidak ditemukan';
        return $response;
    }

    $query = "DELETE FROM {$this->table} WHERE id_kategori = ?";
    $stmt = $this->conn->prepare($query);
    
    if (!$stmt) {
        $response['message'] = 'Prepare statement gagal: ' . $this->conn->error;
        return $response;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        if (!empty($categoryData['gambar'])) {
            $imagePath = $this->uploadPath . $categoryData['gambar'];
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $response['status'] = true;
        $response['message'] = 'Kategori berhasil dihapus!';
    } else {
        $response['message'] = 'Gagal menghapus kategori: ' . $stmt->error;
    }

    $stmt->close();
    return $response;
}


public function getById(int $id): ?array
{
    $query = "SELECT * FROM {$this->table} WHERE id_kategori = ?";
    $stmt = $this->conn->prepare($query);
    
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->num_rows > 0 ? $result->fetch_assoc() : null;
    
    $stmt->close();
    return $data;
}

}
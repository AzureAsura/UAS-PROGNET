<?php

require_once __DIR__ . '/class-category.php'; 

class Product extends Database
{
    private $table = 'tb_produk';
    private $uploadPath = '../../uploads/'; 
    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $data, array $file): array
    {
        $response = ['status' => false, 'message' => ''];

        $category_id      = (int)($data['id_kategori'] ?? 0);
        $name             = trim($data['nama_produk'] ?? '');
        $slug             = trim($data['slug'] ?? '');
        $headline         = trim($data['headline'] ?? '');
        $description      = trim($data['deskripsi'] ?? '');
        $original_price   = str_replace(['.', ','], '', $data['harga_asli'] ?? '0');
        $selling_price    = str_replace(['.', ','], '', $data['harga_jual'] ?? '0');
        $qty              = (int)($data['qty'] ?? 0);
        $meta_title       = trim($data['meta_title'] ?? '');
        $meta_description = trim($data['meta_description'] ?? '');
        $meta_keywords    = trim($data['meta_keywords'] ?? '');
        $status           = isset($data['status']) ? 1 : 0;
        $popular          = isset($data['popularitas']) ? 1 : 0;

        if ($category_id <= 0 || empty($name) || $qty < 0) {
            $response['message'] = 'Data tidak lengkap atau tidak valid';
            return $response;
        }

        $filename = $this->handleImageUpload($file, 'gambar');

        if ($filename === false && !empty($file['gambar']['name'])) {
            $response['message'] = 'Gagal upload gambar';
            return $response;
        }

        $filename = $filename ?: ''; 

        $query = "INSERT INTO {$this->table} 
                 (id_kategori, nama_produk, slug, headline, deskripsi, harga_asli, harga_jual, qty,
                  meta_title, meta_description, meta_keywords, status, popularitas, gambar)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            $response['message'] = 'Prepare gagal: ' . $this->conn->error;
            return $response;
        }

        $stmt->bind_param(
            "issssiissssiis",
            $category_id,
            $name,
            $slug,
            $headline,
            $description,
            $original_price,
            $selling_price,
            $qty,
            $meta_title,
            $meta_description,
            $meta_keywords,
            $status,
            $popular,
            $filename
        );

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Produk berhasil ditambahkan';
        } else {
            $response['message'] = 'Gagal menambah produk: ' . $stmt->error;
        }

        $stmt->close();
        return $response;
    }

    public function update(int $id, array $data, array $file): array
    {
        $response = ['status' => false, 'message' => ''];

        $id               = (int)$id;
        $category_id      = (int)($data['id_kategori'] ?? 0);
        $name             = trim($data['nama_produk'] ?? '');
        $slug             = trim($data['slug'] ?? '');
        $headline         = trim($data['headline'] ?? '');
        $description      = trim($data['deskripsi'] ?? '');
        $original_price   = str_replace(['.', ','], '', $data['harga_asli'] ?? '0');
        $selling_price    = str_replace(['.', ','], '', $data['harga_jual'] ?? '0');
        $qty              = (int)($data['qty'] ?? 0);
        $meta_title       = trim($data['meta_title'] ?? '');
        $meta_description = trim($data['meta_description'] ?? '');
        $meta_keywords    = trim($data['meta_keywords'] ?? '');
        $status           = isset($data['status']) ? 1 : 0;
        $popular          = isset($data['popularitas']) ? 1 : 0;

        $old_image = trim($data['old_image'] ?? '');

        if ($id <= 0 || $category_id <= 0 || empty($name)) {
            $response['message'] = 'Data tidak lengkap';
            return $response;
        }

        if (!empty($file['gambar']['name']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $new_filename = $this->handleImageUpload($file, 'gambar');
            if ($new_filename === false) {
                $response['message'] = 'Gagal upload gambar baru';
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
                  id_kategori = ?, nama_produk = ?, slug = ?, headline = ?, deskripsi = ?,
                  harga_asli = ?, harga_jual = ?, qty = ?,
                  meta_title = ?, meta_description = ?, meta_keywords = ?,
                  status = ?, popularitas = ?, gambar = ?
                  WHERE id_produk = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            $response['message'] = 'Prepare gagal: ' . $this->conn->error;
            return $response;
        }

        $stmt->bind_param(
            "issssiissssiisi",
            $category_id,
            $name,
            $slug,
            $headline,
            $description,
            $original_price,
            $selling_price,
            $qty,
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
            $response['message'] = 'Produk berhasil diperbarui';
        } else {
            $response['message'] = 'Gagal update produk: ' . $stmt->error;
        }

        $stmt->close();
        return $response;
    }


    public function delete(int $id): array
    {
        $response = ['status' => false, 'message' => ''];

        $id = (int)$id;
        if ($id <= 0) {
            $response['message'] = 'ID tidak valid';
            return $response;
        }

        $product = $this->getById($id);
        if (!$product) {
            $response['message'] = 'Produk tidak ditemukan';
            return $response;
        }

        $query = "DELETE FROM {$this->table} WHERE id_produk = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if (!empty($product['gambar'])) {
                $imagePath = $this->uploadPath . $product['gambar'];
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }
            $response['status'] = true;
            $response['message'] = 'Produk berhasil dihapus';
        } else {
            $response['message'] = 'Gagal menghapus produk: ' . $stmt->error;
        }

        $stmt->close();
        return $response;
    }


    public function getById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id_produk = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $data;
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
}
<?php
// admin/app/Models/category_model.php - FIXED VERSION

class CategoryModel
{
    private $con;
    private $table = 'tb_kategori';

    public function __construct($db)
    {
        $this->con = $db;
    }

    /**
     * Get all categories
     */
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY nama_kategori ASC";
        return mysqli_query($this->con, $query);
    }

    /**
     * Get category by ID
     */
    public function getById($id)
    {
        $id = mysqli_real_escape_string($this->con, $id);
        $query = "SELECT * FROM {$this->table} WHERE id_kategori='$id' LIMIT 1";
        return mysqli_query($this->con, $query);
    }

    /**
     * Insert new category
     */
    public function insert($data, $filename)
    {
        $nama = mysqli_real_escape_string($this->con, $data['nama_kategori']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        $metaTitle = mysqli_real_escape_string($this->con, $data['meta_title']);
        $metaDesc = mysqli_real_escape_string($this->con, $data['meta_description']);
        $metaKeywords = mysqli_real_escape_string($this->con, $data['meta_keywords']);
        $status = (int)$data['status'];
        $popular = (int)$data['popularitas'];
        $gambar = mysqli_real_escape_string($this->con, $filename ?? '');

        $query = "INSERT INTO {$this->table}
            (nama_kategori, slug, deskripsi, meta_title, meta_description, 
             meta_keywords, status, popularitas, gambar)
            VALUES ('$nama', '$slug', '$deskripsi', '$metaTitle', '$metaDesc', 
                    '$metaKeywords', $status, $popular, '$gambar')";

        return mysqli_query($this->con, $query);
    }

    /**
     * Update category - METHOD YANG BENAR
     */
    public function updateCategory($data)
    {
        $id = mysqli_real_escape_string($this->con, $data['category_id']);
        $nama = mysqli_real_escape_string($this->con, $data['nama_kategori']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        $metaTitle = mysqli_real_escape_string($this->con, $data['meta_title']);
        $metaDesc = mysqli_real_escape_string($this->con, $data['meta_description']);
        $metaKeywords = mysqli_real_escape_string($this->con, $data['meta_keywords']);
        $status = (int)$data['status'];
        $popular = (int)$data['popularitas'];
        $gambar = mysqli_real_escape_string($this->con, $data['gambar']);

        $query = "UPDATE {$this->table} SET
            nama_kategori='$nama',
            slug='$slug',
            deskripsi='$deskripsi',
            meta_title='$metaTitle',
            meta_description='$metaDesc',
            meta_keywords='$metaKeywords',
            status=$status,
            popularitas=$popular,
            gambar='$gambar'
            WHERE id_kategori='$id'";

        return mysqli_query($this->con, $query);
    }

    /**
     * Update category - METHOD LAMA (untuk backward compatibility)
     * DEPRECATED - gunakan updateCategory() sebagai gantinya
     */
    public function update($data, $file)
    {
        $id = mysqli_real_escape_string($this->con, $data['category_id']);
        $nama = mysqli_real_escape_string($this->con, $data['nama_kategori']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        
        // Handle filename
        $filename = !empty($file['gambar']['name'])
            ? time() . '.' . pathinfo($file['gambar']['name'], PATHINFO_EXTENSION)
            : ($data['old_image'] ?? '');

        $query = "UPDATE {$this->table} SET
            nama_kategori='$nama',
            slug='$slug',
            deskripsi='$deskripsi',
            gambar='$filename'
            WHERE id_kategori='$id'";

        $result = mysqli_query($this->con, $query);

        // Handle file upload jika ada
        if (!empty($file['gambar']['name'])) {
            $uploadPath = __DIR__ . "/../../../uploads/$filename";
            move_uploaded_file($file['gambar']['tmp_name'], $uploadPath);
            
            // Hapus gambar lama
            if (!empty($data['old_image'])) {
                $oldPath = __DIR__ . "/../../../uploads/" . $data['old_image'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        return $filename;
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        $id = mysqli_real_escape_string($this->con, $id);
        
        // Get image filename first
        $result = mysqli_query($this->con, 
            "SELECT gambar FROM {$this->table} WHERE id_kategori='$id'"
        );
        $data = mysqli_fetch_assoc($result);

        // Delete from database
        $query = "DELETE FROM {$this->table} WHERE id_kategori='$id'";
        $deleted = mysqli_query($this->con, $query);

        // Delete image file if exists
        if ($deleted && !empty($data['gambar'])) {
            $imagePath = __DIR__ . "/../../../uploads/" . $data['gambar'];
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        return $deleted;
    }
}
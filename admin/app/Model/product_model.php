<?php
// admin/app/Models/product_model.php - COMPLETE VERSION

class ProductModel
{
    private $con;
    private $table = 'tb_produk';

    public function __construct($db)
    {
        $this->con = $db;
    }

    /**
     * Get all products
     */
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY nama_produk ASC";
        return mysqli_query($this->con, $query);
    }

    /**
     * Get product by ID
     */
    public function getById($id)
    {
        $id = mysqli_real_escape_string($this->con, $id);
        $query = "SELECT * FROM {$this->table} WHERE id_produk='$id' LIMIT 1";
        return mysqli_query($this->con, $query);
    }

    /**
     * Insert new product
     */
    public function insert($data, $filename)
    {
        $categoryId = (int)$data['id_kategori'];
        $nama = mysqli_real_escape_string($this->con, $data['nama_produk']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $headline = mysqli_real_escape_string($this->con, $data['headline']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        $hargaAsli = (int)str_replace(['.', ','], '', $data['harga_asli']);
        $hargaJual = (int)str_replace(['.', ','], '', $data['harga_jual']);
        $qty = (int)$data['qty'];
        $metaTitle = mysqli_real_escape_string($this->con, $data['meta_title']);
        $metaDesc = mysqli_real_escape_string($this->con, $data['meta_description']);
        $metaKeywords = mysqli_real_escape_string($this->con, $data['meta_keywords']);
        $status = (int)($data['status'] ?? 0);
        $popular = (int)($data['popularitas'] ?? 0);
        $gambar = mysqli_real_escape_string($this->con, $filename ?? '');

        $query = "INSERT INTO {$this->table}
            (id_kategori, nama_produk, slug, headline, deskripsi, harga_asli, 
             harga_jual, qty, meta_title, meta_description, meta_keywords, 
             status, popularitas, gambar)
            VALUES ($categoryId, '$nama', '$slug', '$headline', '$deskripsi', 
                    $hargaAsli, $hargaJual, $qty, '$metaTitle', '$metaDesc', 
                    '$metaKeywords', $status, $popular, '$gambar')";

        return mysqli_query($this->con, $query);
    }

    /**
     * Update product - NEW METHOD
     */
    public function updateProduct($data)
    {
        $id = mysqli_real_escape_string($this->con, $data['id_produk']);
        $categoryId = (int)$data['id_kategori'];
        $nama = mysqli_real_escape_string($this->con, $data['nama_produk']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $headline = mysqli_real_escape_string($this->con, $data['headline']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        $hargaAsli = (int)str_replace(['.', ','], '', $data['harga_asli']);
        $hargaJual = (int)str_replace(['.', ','], '', $data['harga_jual']);
        $qty = (int)$data['qty'];
        $metaTitle = mysqli_real_escape_string($this->con, $data['meta_title']);
        $metaDesc = mysqli_real_escape_string($this->con, $data['meta_description']);
        $metaKeywords = mysqli_real_escape_string($this->con, $data['meta_keywords']);
        $status = (int)($data['status'] ?? 0);
        $popular = (int)($data['popularitas'] ?? 0);
        $gambar = mysqli_real_escape_string($this->con, $data['gambar']);

        $query = "UPDATE {$this->table} SET
            id_kategori=$categoryId,
            nama_produk='$nama',
            slug='$slug',
            headline='$headline',
            deskripsi='$deskripsi',
            harga_asli=$hargaAsli,
            harga_jual=$hargaJual,
            qty=$qty,
            meta_title='$metaTitle',
            meta_description='$metaDesc',
            meta_keywords='$metaKeywords',
            status=$status,
            popularitas=$popular,
            gambar='$gambar'
            WHERE id_produk='$id'";

        return mysqli_query($this->con, $query);
    }

    /**
     * Update product - OLD METHOD (untuk backward compatibility)
     * DEPRECATED - gunakan updateProduct() sebagai gantinya
     */
    public function update($data, $file)
    {
        $id = mysqli_real_escape_string($this->con, $data['id_produk']);
        
        // Handle filename
        $filename = !empty($file['gambar']['name'])
            ? time() . '.' . pathinfo($file['gambar']['name'], PATHINFO_EXTENSION)
            : ($data['old_image'] ?? '');

        $categoryId = (int)$data['id_kategori'];
        $nama = mysqli_real_escape_string($this->con, $data['nama_produk']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $headline = mysqli_real_escape_string($this->con, $data['headline']);
        $deskripsi = mysqli_real_escape_string($this->con, $data['deskripsi']);
        $hargaAsli = (int)str_replace(['.', ','], '', $data['harga_asli']);
        $hargaJual = (int)str_replace(['.', ','], '', $data['harga_jual']);
        $qty = (int)$data['qty'];
        $metaTitle = mysqli_real_escape_string($this->con, $data['meta_title']);
        $metaDesc = mysqli_real_escape_string($this->con, $data['meta_description']);
        $metaKeywords = mysqli_real_escape_string($this->con, $data['meta_keywords']);
        $status = (int)($data['status'] ?? 0);
        $popular = (int)($data['popularitas'] ?? 0);

        $query = "UPDATE {$this->table} SET
            id_kategori=$categoryId,
            nama_produk='$nama',
            slug='$slug',
            headline='$headline',
            deskripsi='$deskripsi',
            harga_asli=$hargaAsli,
            harga_jual=$hargaJual,
            qty=$qty,
            meta_title='$metaTitle',
            meta_description='$metaDesc',
            meta_keywords='$metaKeywords',
            status=$status,
            popularitas=$popular,
            gambar='$filename'
            WHERE id_produk='$id'";

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
     * Delete product
     */
    public function delete($id)
    {
        $id = mysqli_real_escape_string($this->con, $id);
        
        // Get image filename first
        $result = mysqli_query($this->con, 
            "SELECT gambar FROM {$this->table} WHERE id_produk='$id'"
        );
        $data = mysqli_fetch_assoc($result);

        // Delete from database
        $query = "DELETE FROM {$this->table} WHERE id_produk='$id'";
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
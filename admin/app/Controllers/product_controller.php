<?php
// admin/app/Controllers/product_controller.php - FIXED VERSION

require_once dirname(__DIR__) . '/Helpers/redirect_helper.php';
require_once dirname(__DIR__) . '/Helpers/upload_helper.php';
require_once dirname(__DIR__) . '/Model/product_model.php';

class ProductController
{
    private $model;
    private $uploadHelper;

    public function __construct($db)
    {
        $this->model = new ProductModel($db);
        $this->uploadHelper = new UploadHelper();
    }

    /**
     * Store new product
     */
    public function store($data, $file)
    {
        try {
            // Validasi input
            if (empty($data['nama_produk']) || empty($data['slug'])) {
                throw new Exception("Product name and slug are required.");
            }

            if (empty($data['id_kategori'])) {
                throw new Exception("Category is required.");
            }

            // Upload gambar
            $filename = $this->uploadHelper->upload($file['gambar']);

            if (!$filename) {
                throw new Exception("Failed to upload image.");
            }

            // Insert ke database
            if ($this->model->insert($data, $filename)) {
                RedirectHelper::redirect("products.php", "Product added successfully!");
            } else {
                // Jika gagal insert, hapus gambar yang sudah diupload
                $this->uploadHelper->delete($filename);
                throw new Exception("Failed to insert product to database.");
            }
            
        } catch (Exception $e) {
            RedirectHelper::redirect("add-product.php", "Error: " . $e->getMessage());
        }
    }

    /**
     * Update product
     */
    public function update($data, $file)
    {
        try {
            $id = $data['id_produk'] ?? null;

            if (!$id) {
                throw new Exception("No product ID provided.");
            }

            // Validasi input
            if (empty($data['nama_produk']) || empty($data['slug'])) {
                throw new Exception("Product name and slug are required.");
            }

            // Cek apakah ada file gambar baru
            $filename = $data['old_image'] ?? '';

            if (!empty($file['gambar']['name']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
                // Validasi tipe file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($file['gambar']['type'], $allowedTypes)) {
                    throw new Exception("Invalid file type. Only JPG, PNG, GIF, WEBP allowed.");
                }

                // Validasi ukuran file (max 5MB)
                if ($file['gambar']['size'] > 5242880) {
                    throw new Exception("File too large. Max 5MB.");
                }

                $ext = pathinfo($file['gambar']['name'], PATHINFO_EXTENSION);
                $filename = time() . '.' . strtolower($ext);

                // Upload file
                $uploadPath = __DIR__ . "/../../../uploads/" . $filename;
                
                if (!move_uploaded_file($file['gambar']['tmp_name'], $uploadPath)) {
                    throw new Exception("Failed to upload image.");
                }

                // Hapus gambar lama
                if (!empty($data['old_image']) && $data['old_image'] !== $filename) {
                    $oldImagePath = __DIR__ . "/../../../uploads/" . $data['old_image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            // Data untuk update
            $updateData = [
                'id_produk' => $id,
                'id_kategori' => $data['id_kategori'],
                'nama_produk' => $data['nama_produk'],
                'slug' => $data['slug'],
                'headline' => $data['headline'] ?? '',
                'deskripsi' => $data['deskripsi'] ?? '',
                'harga_asli' => $data['harga_asli'],
                'harga_jual' => $data['harga_jual'],
                'qty' => $data['qty'],
                'meta_title' => $data['meta_title'] ?? '',
                'meta_description' => $data['meta_description'] ?? '',
                'meta_keywords' => $data['meta_keywords'] ?? '',
                'status' => isset($data['status']) ? 1 : 0,
                'popularitas' => isset($data['popularitas']) ? 1 : 0,
                'gambar' => $filename
            ];

            // Update di database
            if ($this->model->updateProduct($updateData)) {
                RedirectHelper::redirect("products.php", "Product updated successfully!");
            } else {
                throw new Exception("Failed to update product in database.");
            }
            
        } catch (Exception $e) {
            RedirectHelper::redirect("edit-product.php?id=" . ($data['id_produk'] ?? ''), 
                "Error: " . $e->getMessage());
        }
    }

    /**
     * Delete product
     */
    public function delete($id)
    {
        try {
            $product = $this->model->getById($id);

            if (!$product || mysqli_num_rows($product) === 0) {
                throw new Exception("Product not found.");
            }

            $data = mysqli_fetch_assoc($product);

            // Hapus file gambar
            if (!empty($data['gambar'])) {
                $imagePath = __DIR__ . "/../../../uploads/" . $data['gambar'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Hapus dari database
            if ($this->model->delete($id)) {
                RedirectHelper::redirect("products.php", "Product deleted successfully!");
            } else {
                throw new Exception("Failed to delete product.");
            }
            
        } catch (Exception $e) {
            RedirectHelper::redirect("products.php", "Error: " . $e->getMessage());
        }
    }

    /**
     * Get all products
     */
    public function getAll()
    {
        return $this->model->getAll();
    }

    /**
     * Get product by ID
     */
    public function getById($id)
    {
        return $this->model->getById($id);
    }
}
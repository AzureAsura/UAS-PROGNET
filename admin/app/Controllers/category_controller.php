<?php
// admin/app/Controllers/category_controller.php

require_once __DIR__ . '/../Helpers/redirect_helper.php';
require_once __DIR__ . '/../Helpers/upload_helper.php';
require_once __DIR__ . '/../Model/category_model.php';

class CategoryController {
    private $model;
    private $uploadHelper;

    public function __construct($db) {
        $this->model = new CategoryModel($db);
        $this->uploadHelper = new UploadHelper();
    }

    public function store($data, $file) {
        try {
            $filename = $this->uploadHelper->upload($file['gambar']);
            
            if ($this->model->insert($data, $filename)) {
                RedirectHelper::redirect("category.php", "Category Added Successfully");
            } else {
                throw new Exception("Failed to insert category");
            }
        } catch (Exception $e) {
            RedirectHelper::redirect("add-category.php", "Error: " . $e->getMessage());
        }
    }

    public function update($data, $file) {
        try {
            $filename = $this->model->update($data, $file);
            RedirectHelper::redirect("category.php", "Category Updated Successfully");
        } catch (Exception $e) {
            RedirectHelper::redirect("edit-category.php?id=" . $data['category_id'], 
                "Error: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $this->model->delete($id);
            RedirectHelper::redirect("category.php", "Category Deleted Successfully");
        } catch (Exception $e) {
            RedirectHelper::redirect("category.php", "Error: " . $e->getMessage());
        }
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getById($id) {
        return $this->model->getById($id);
    }
}
<?php
    // session_start();

    include('config/db-config.php');

    // Function fetch all data that active (client side)
    function getAllActive($table){
        global $con;
        $query = "SELECT * FROM $table WHERE status='0'";
        return $query_run = mysqli_query($con, $query);
    }

    function getSlugActive($table, $slug){
        global $con;
        $query = "SELECT * FROM $table WHERE slug='$slug' AND status='0' LIMIT 1";
        return $query_run = mysqli_query($con, $query);
    }

    function getProductByCategory($categoryId){
        global $con;
        $query = "SELECT * FROM tb_produk WHERE id_kategori='$categoryId' AND status='0'";
        return $query_run = mysqli_query($con, $query);
    }
        

    // Message Return Function
    function redirect($path, $message){

        $_SESSION['message'] = $message;
        header('Location: '.$path);
        exit();
    }

?>
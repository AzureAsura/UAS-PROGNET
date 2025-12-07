<?php

    include('../config/db-config.php');

    // Function fetch all data
    function getAll($table){
        global $con;
        $query = "SELECT * FROM $table";
        return $query_run = mysqli_query($con, $query);
    }

    // Function fetch data by id
    function getById($table, $id, $column){
        global $con;
        $query = "SELECT * FROM $table WHERE $column = '$id'";
        return $query_run = mysqli_query($con, $query);
    }

    // Function fetch all data that active (client side)
    function getAllActive($table){
        global $con;
        $query = "SELECT * FROM $table WHERE status='0'";
        return $query_run = mysqli_query($con, $query);
    }

    // Message Return Function
    function redirect($path, $message){

        $_SESSION['message'] = $message;
        header('Location: '.$path);
        exit();
    }

?>
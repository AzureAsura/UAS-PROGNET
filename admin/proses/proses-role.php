<?php
session_start();
require_once '../config/class-useradmin.php';

$adminObj = new UserAdmin();

if (isset($_POST['update_role'])) {
    $id_user = (int)($_POST['id_user'] ?? 0);
    $new_role = (int)($_POST['new_role'] ?? -1);

    if ($id_user <= 0 || $new_role < 0) {
        $_SESSION['message'] = "Data tidak valid";
    } else {
        $result = $adminObj->updateUserRole($id_user, $new_role);
        $_SESSION['message'] = $result['message'];
    }

    header("Location: ../role.php");
    exit();
}


header("Location: ../role.php");
exit();
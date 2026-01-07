<?php

require_once __DIR__ . '/../../config/db-config.php';  


class UserAdmin extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getAllUsersWithRole()
    {
        $query = "
            SELECT 
                u.id_user,
                u.nama_user,
                u.email,
                u.no_telp,
                u.role,
                r.nama_role
            FROM tb_user u
            LEFT JOIN tb_role r ON u.role = r.id_role
            ORDER BY FIELD(u.role, 1, 2, 0), u.nama_user
        ";
        return $this->conn->query($query);
    }


    public function getStaffUsers()
    {
        $query = "
            SELECT 
                u.id_user,
                u.nama_user,
                u.email,
                u.no_telp,
                u.role,
                r.nama_role
            FROM tb_user u
            LEFT JOIN tb_role r ON u.role = r.id_role
            WHERE u.role IN (1, 2)
            ORDER BY u.role, u.nama_user
        ";
        return $this->conn->query($query);
    }



    public function getAllRoles()
    {
        $query = "SELECT id_role, nama_role FROM tb_role ORDER BY id_role";
        return $this->conn->query($query);
    }



    public function updateUserRole($userId, $newRole)
    {
        $response = ['success' => false, 'message' => ''];

        $stmt = $this->conn->prepare("UPDATE tb_user SET role = ? WHERE id_user = ?");
        $stmt->bind_param("ii", $newRole, $userId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = "Role berhasil diperbarui";
            } else {
                $response['message'] = "User tidak ditemukan atau role sama";
            }
        } else {
            $response['message'] = "Gagal update role: " . $stmt->error;
        }

        $stmt->close();
        return $response;
    }
}
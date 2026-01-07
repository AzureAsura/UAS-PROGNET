<?php
include('../middleware/adminMiddleware.php');
require_once 'config/class-useradmin.php';
include('template/header.php');
include('template/sidebar.php');

$adminObj = new UserAdmin();


$staffUsers = $adminObj->getStaffUsers();    
$allUsers = $adminObj->getAllUsersWithRole();  
$roles = $adminObj->getAllRoles();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<main class="flex-1 p-8 md:pt-8 pt-24 bg-gray-50 min-h-screen">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Role User</h1>
        <p class="text-gray-500 mt-1">Kelola hak akses pengguna</p>
    </div>

    <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-8">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-10">
        <div class="p-6 border-b bg-gray-50">
            <h2 class="font-bold text-xl text-gray-800">Staff (Admin & Pekerja)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">No. Telp</th>
                        <th class="p-4 text-left">Role Saat Ini</th>
                        <th class="p-4 text-left">Ubah Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if (mysqli_num_rows($staffUsers) > 0): ?>
                        <?php while ($user = mysqli_fetch_assoc($staffUsers)): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-medium"><?= htmlspecialchars($user['nama_user']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['no_telp'] ?: '-') ?></td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-sm <?= $user['role'] == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= htmlspecialchars($user['nama_role']) ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <form action="proses/proses-role.php" method="POST" class="flex items-center gap-3">
                                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                        <select name="new_role" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-slate-400 outline-none">
                                            <?php
                                            mysqli_data_seek($roles, 0);
                                            while ($role = mysqli_fetch_assoc($roles)):
                                            ?>
                                                <option value="<?= $role['id_role'] ?>" <?= $user['role'] == $role['id_role'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($role['nama_role']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <button type="submit" name="update_role" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm transition">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada staff (admin/pekerja)
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Semua User -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gray-50">
            <h2 class="font-bold text-xl text-gray-800">Semua Pengguna</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">No. Telp</th>
                        <th class="p-4 text-left">Role Saat Ini</th>
                        <th class="p-4 text-left">Ubah Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if (mysqli_num_rows($allUsers) > 0): ?>
                        <?php while ($user = mysqli_fetch_assoc($allUsers)): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-medium"><?= htmlspecialchars($user['nama_user']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['no_telp'] ?: '-') ?></td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-sm <?= $user['role'] == 0 ? 'bg-yellow-100 text-yellow-800' : ($user['role'] == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') ?>">
                                        <?= htmlspecialchars($user['nama_role'] ?? 'Tidak ada role') ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <form action="proses/proses-role.php" method="POST" class="flex items-center gap-3">
                                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                        <select name="new_role" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-slate-400 outline-none">
                                            <?php
                                            mysqli_data_seek($roles, 0);
                                            while ($role = mysqli_fetch_assoc($roles)):
                                            ?>
                                                <option value="<?= $role['id_role'] ?>" <?= $user['role'] == $role['id_role'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($role['nama_role']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <button type="submit" name="update_role" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm transition">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Belum ada pengguna
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php include('template/footer.php'); ?>
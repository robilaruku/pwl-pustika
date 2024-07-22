<?php
// Get error and success messages from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Admin Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('header'); ?>
<header class="header">
    <h1>List Data Genre</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Semua Data Genre
        <a href="/admin-genre/create" class="btn btn-sm btn-primary create-btn">Tambah Data</a>
    </div>
    <div class="card-body">
        <?php if ($error): ?>
        <div class="message error">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
        <?php endif; ?>
        <?php if ($success): ?>
        <div class="message success">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p><?php echo htmlspecialchars($success); ?></p>
        </div>
        <?php endif; ?>
        <br>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($genres as $row => $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row + 1); ?></td>
                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin-genre/edit/<?php echo $item['id']; ?>"
                                class="btn btn-sm btn-primary">Edit</a>
                            <a href="/admin-genre/delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-primary"
                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php \Core\View::endSection(); ?>
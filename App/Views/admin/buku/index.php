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
    <h1>List Data Buku</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Semua Data Buku
        <a href="/admin-buku/create" class="btn btn-sm btn-primary create-btn">Tambah Data</a>
    </div>
    <div class="card-body">
        <?php if (isset($error) && $error): ?>
            <div class="message error">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($success) && $success): ?>
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
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th>Penerbit</th>
                    <th>Genre</th>
                    <th>Gambar</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $index => $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($index + 1); ?></td>
                        <td><?php echo htmlspecialchars($book['judul']); ?></td>
                        <td><?php echo htmlspecialchars(
                            $book['tahun_terbit']
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $book['penerbit_nama']
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $book['genre_nama']
                        ); ?></td>
                        <td>
                            <?php if (!empty($book['gambar'])): ?>
                                <?php echo $fileDisplay->getImageTag(
                                    $book['gambar'],
                                    'Book Image'
                                ); ?>
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/admin-buku/edit/<?php echo htmlspecialchars(
                                    $book['id']
                                ); ?>"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a href="/admin-buku/delete/<?php echo htmlspecialchars(
                                    $book['id']
                                ); ?>"
                                    class="btn btn-sm btn-primary"
                                    onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php \Core\View::endSection(); ?>

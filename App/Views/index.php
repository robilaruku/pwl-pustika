<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Pustika Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('jumbotron'); ?>
<div class="jumbotron">
    <h2>Selamat Datang di Web Pustika</h2>
    <p>Gerbang Anda untuk mengelola dan menemukan buku dengan efisien.</p>
</div>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<?php foreach ($books as $book): ?>
    <div class="card">
        <?php if (!empty($book['gambar'])): ?>
            <?php echo $fileDisplay->getImageTag(
                $book['gambar'],
                'Book Image',
                '100%'
            ); ?>
        <?php else: ?>
            <p>No Image</p>
        <?php endif; ?>

        <div class="card-body">
            <h3><?php echo htmlspecialchars($book['judul']); ?></h3>
            <p>Author: <?php echo htmlspecialchars($book['penerbit_nama']); ?></p>
        </div>

        <div class="card-footer">
            <a href="/detail-buku/index/<?php echo htmlspecialchars($book['id']); ?>" class="btn-detail">Show Details</a>
        </div>
    </div>
<?php endforeach; ?>
<?php \Core\View::endSection(); ?>

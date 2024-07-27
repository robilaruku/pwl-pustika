<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Pustika Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('jumbotron'); ?>
<div class="jumbotron">
    <h2>Detail Buku</h2>
</div>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<div class="card col-md-12">
    <?php if (!empty($book['gambar'])): ?>
        <?php echo $fileDisplay->getImageTag(
            $book['gambar'],
            'Buku',
            '500px'
        ); ?>
    <?php else: ?>
        No Image
    <?php endif; ?>

    <div class="card-body">
        <h3><?php echo htmlspecialchars($book['judul']); ?></h3>
        <p>Penerbit : <?php echo htmlspecialchars(
            $book['penerbit_nama']
        ); ?></p>
        <p>Genre :<?php echo htmlspecialchars(
            $book['genre_nama']
        ); ?></p>
        <p>Tahun Terbit :<?php echo htmlspecialchars(
            $book['tahun_terbit']
        ); ?></p>
        <p><?php echo htmlspecialchars(
            $book['content']
        ); ?></p>
    </div>
</div>
<?php \Core\View::endSection(); ?>
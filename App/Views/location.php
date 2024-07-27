<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Pustika Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('jumbotron'); ?>
<div class="jumbotron">
    <h2>Lokasi Pustika</h2>
</div>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<?php foreach ($ourLocations as $index => $ourLocation): ?>
    <div class="card col-md-12">
        <?php if (!empty($ourLocation['gambar'])): ?>
            <?php echo $fileDisplay->getImageTag(
                $ourLocation['gambar'],
                'Location',
                '100%'
            ); ?>
        <?php else: ?>
            No Image
        <?php endif; ?>

        <div class="card-body">
            <h3><?php echo htmlspecialchars($ourLocation['title']); ?></h3>
            <p><?php echo htmlspecialchars(
                $ourLocation['description']
            ); ?></p>
        </div>
    </div>
<?php endforeach; ?>
<?php \Core\View::endSection(); ?>
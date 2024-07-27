<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Pustika Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('jumbotron'); ?>
<div class="jumbotron">
    <h2>List Agenda</h2>
</div>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<?php foreach ($agendaLists as $index => $agenda): ?>
    <div class="card">
        <?php if (!empty($agenda['gambar'])): ?>
            <?php echo $fileDisplay->getImageTag(
                $agenda['gambar'],
                'Agenda Image',
                '100%'
            ); ?>
        <?php else: ?>
            No Image
        <?php endif; ?>

        <div class="card-body">
            <h3><?php echo htmlspecialchars($agenda['title']); ?></h3>
            <p><?php echo htmlspecialchars(
                $agenda['description']
            ); ?></p>
        </div>
    </div>
<?php endforeach; ?>
<?php \Core\View::endSection(); ?>
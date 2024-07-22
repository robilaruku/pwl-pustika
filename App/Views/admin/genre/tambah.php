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
    <h1>Tambah Data Genre</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Form Tambah Data Genre
    </div>
    <div class="card-body">
        <?php if ($error): ?>
        <div class="message error">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
        <?php endif; ?>
        <!-- Styled Form -->
        <form action="/admin-genre/store" method="POST">
            <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" placeholder="Nama Genre" required>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            <a href="/admin-genre/index" class="btn btn-sm btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php \Core\View::endSection(); ?>
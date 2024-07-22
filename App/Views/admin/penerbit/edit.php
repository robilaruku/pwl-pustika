<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Admin Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('header'); ?>
<header class="header">
    <h1>Edit Data Penerbit</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Form Edit Data Penerbit
    </div>
    <div class="card-body">
        <?php if ($error): ?>
        <div class="message error">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
        <?php endif; ?>
        <!-- Styled Form -->
        <form action="/admin-penerbit/update/<?php echo $penerbit['id']; ?>" method="POST">
            <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <label for="namenama">Nama:</label>
            <input type="text" id="nama" name="nama" placeholder="Nama Penerbit"
                value="<?php echo htmlspecialchars($penerbit['nama']); ?>" required>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat"
                placeholder="Alamat Penerbit"><?php echo htmlspecialchars($penerbit['alamat']); ?></textarea>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            <a href="/admin-penerbit/index" class="btn btn-sm btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php \Core\View::endSection(); ?>
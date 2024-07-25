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
    <h1>Tambah Data Buku</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Form Tambah Data Buku
    </div>
    <div class="card-body">
        <?php if ($error): ?>
        <div class="message error">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
        <?php endif; ?>
        <!-- Styled Form -->
        <form action="/admin-buku/store" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" placeholder="Judul Buku" required>
            
            <label for="penerbit_id">Penerbit:</label>
            <select id="penerbit_id" name="penerbit_id">
                <!-- Populate with data from your penerbit table -->
                <option value="">Select Penerbit</option>
                <?php foreach ($penerbits as $penerbit): ?>
                    <option value="<?php echo htmlspecialchars($penerbit['id']); ?>">
                        <?php echo htmlspecialchars($penerbit['nama']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="genre_id">Genre:</label>
            <select id="genre_id" name="genre_id">
                <!-- Populate with data from your genre table -->
                <option value="">Select Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre['id']); ?>">
                        <?php echo htmlspecialchars($genre['nama']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" placeholder="Tahun Terbit" min="1900" max="2099" step="1" value="<?php echo date('Y'); ?>" required>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content" placeholder="Deskripsi Buku"></textarea>
            
            <label for="gambar">Gambar:</label>
            <input type="file" id="gambar" name="gambar">
            
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            <a href="/admin-buku/index" class="btn btn-sm btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php \Core\View::endSection(); ?>

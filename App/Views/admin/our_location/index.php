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
    <h1>List Data Our Location</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Semua Data Our Location
        <?php if (!count($ourLocations) > 0) : ?>
        <a href="/admin-our-location/create" class="btn btn-sm btn-primary create-btn">Tambah Data</a>
        <?php endif; ?>
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
                    <th>Content</th>
                    <th>Gambar</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ourLocations as $index => $ourLocation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($index + 1); ?></td>
                        <td><?php echo htmlspecialchars($ourLocation['title']); ?></td>
                        <td><?php echo htmlspecialchars(
                            $ourLocation['description']
                        ); ?></td>
                        <td>
                            <?php if (!empty($ourLocation['gambar'])): ?>
                                <?php echo $fileDisplay->getImageTag(
                                    $ourLocation['gambar'],
                                    'Our Location Image'
                                ); ?>
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/admin-our-location/edit/<?php echo htmlspecialchars(
                                    $ourLocation['id']
                                ); ?>"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a href="/admin-our-location/delete/<?php echo htmlspecialchars(
                                    $ourLocation['id']
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

<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Pustika Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('jumbotron'); ?>
<div class="jumbotron">
    <h2>Welcome to the Library</h2>
    <p>Your gateway to managing and discovering books efficiently.</p>
</div>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<div class="card">
    <img src="book1.jpg" alt="Book 1">
    <div class="card-body">
        <h3>Book Title 1</h3>
        <p>Author: Author Name</p>
    </div>
</div>
<div class="card">
    <img src="book2.jpg" alt="Book 2">
    <div class="card-body">
        <h3>Book Title 2</h3>
        <p>Author: Author Name</p>
    </div>
</div>
<div class="card">
    <img src="book3.jpg" alt="Book 3">
    <div class="card-body">
        <h3>Book Title 3</h3>
        <p>Author: Author Name</p>
    </div>
</div>
<?php \Core\View::endSection(); ?>
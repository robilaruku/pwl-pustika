<?php \Core\View::startSection('title'); ?>
Admin Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('header'); ?>
<header class="header">
    <h1>Welcome, Admin</h1>
    <div class="header-right">
        <a href="#profile" class="header-link">Profile</a>
        <a href="#logout" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<h2>Dashboard</h2>
<p>Here you can manage your application.</p>
<?php \Core\View::endSection(); ?>
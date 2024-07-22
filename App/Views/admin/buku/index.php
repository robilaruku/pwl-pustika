<?php \Core\View::startSection('title'); ?>
Admin Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('header'); ?>
<header class="header">
    <h1>List Data Buku</h1>
    <div class="header-right">
        <a href="/auth/logout" onclick="return confirm('Apakah anda ingin logout?')" class="header-link">Logout</a>
    </div>
</header>
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<!-- Content Card -->
<div class="card">
    <div class="card-header">
        Semua Data Buku
    </div>
    <div class="card-body">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Book Title 1</td>
                    <td>Author 1</td>
                    <td>2024</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Book Title 2</td>
                    <td>Author 2</td>
                    <td>2023</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Book Title 3</td>
                    <td>Author 3</td>
                    <td>2022</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php \Core\View::endSection(); ?>
<?php
// File: views/layouts/auth.php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \Core\View::yieldSection('title'); ?></title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>

<body>
    <header>
        <?php echo \Core\View::yieldSection('header'); ?>
    </header>
    <main>
        <?php echo \Core\View::yieldSection('content'); ?>
    </main>
    <footer>
        <?php echo \Core\View::yieldSection('footer'); ?>
    </footer>
</body>

</html>
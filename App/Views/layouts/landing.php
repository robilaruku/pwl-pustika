<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \Core\View::yieldSection('title'); ?></title>
    <link rel="stylesheet" href="/assets/css/landing.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <h1>Pustika</h1>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Books</a></li>
                <li><a href="#">Members</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>
    </header>

    <?php echo \Core\View::yieldSection('jumbotron'); ?>

    <div class="container">
        <?php echo \Core\View::yieldSection('content'); ?>
    </div>

    <footer>
        <p>&copy; 2024 Library Management System</p>
    </footer>
</body>

</html>
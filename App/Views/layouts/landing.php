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
                <li><a href="/">Beranda</a></li>
                <li><a href="/location">Location</a></li>
                <li><a href="/agenda">Agenda</a></li>
                <li><a href="/auth/index">Login</a></li>
            </ul>
        </nav>
    </header>

    <?php echo \Core\View::yieldSection('jumbotron'); ?>

    <div class="container">
        <?php echo \Core\View::yieldSection('content'); ?>
    </div>

    <footer>
        <p>&copy; 2024 Pustika CMS</p>
    </footer>
</body>

</html>
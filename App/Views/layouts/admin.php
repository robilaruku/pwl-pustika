<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \Core\View::yieldSection('title'); ?></title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Pustika CMS</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="/dashboard/index">Dashboard</a></li>
                    <li><a href="/admin-penerbit/index">Penerbit</a></li>
                    <li><a href="/admin-genre/index">Genre</a></li>
                    <li><a href="/admin-buku/index">List Buku</a></li>
                    <li><a href="#reports">Our Location</a></li>
                    <li><a href="#reports">Agenda</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header>
                <?php echo \Core\View::yieldSection('header'); ?>
            </header>

            <div class="content">
                <?php echo \Core\View::yieldSection('content'); ?>
            </div>
        </main>
    </div>
</body>

</html>
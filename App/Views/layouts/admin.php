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
                <h2>Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li><a href="#users">Users</a></li>
                    <li><a href="#settings">Settings</a></li>
                    <li><a href="#reports">Reports</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header>
                <?php echo \Core\View::yieldSection('header'); ?>
            </header>

            <div class="content">
                <main>
                    <?php echo \Core\View::yieldSection('content'); ?>
                </main>
            </div>
        </main>
    </div>
</body>

</html>
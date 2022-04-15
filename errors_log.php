<html>
<head>
    <?php include('template/head.html') ?>
</head>
<body>
<div class="container">
    <?php include('template/nav.html') ?>
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once 'service/Database.php';
    $db_info = Database::InfoForConnection();
    class_alias('\RedBeanPHP\R', '\R');
    R::setup($db_info['dsn'], $db_info['username'], $db_info['password']);

    $all = R::findAll('errorsico',
        'ORDER BY date_time_search');
    foreach ($all as $item)
    {
        echo '<p><b>IČO: </b>'.$item->ico.' <br><b>Date: </b>'.$item->date_time_search.'</p>';
    }
    ?>
</div>
</body>
</html>
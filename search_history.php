<html>
<head>
    <title>History of searching</title>
    <?php include('template/head.html') ?>
</head>
<body>
<div class="container">
    <?php include('template/nav.html') ?>
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once 'service/Database.php';


    $sort_classes_dict = [
        'date-asc' => 'date_time_search ASC',
        'date-desc' => 'date_time_search DESC',
        'firma-asc' => 'obchodni_firma ASC',
        'firma-desc' => 'obchodni_firma DESC'
    ];

    $page = 1;
    if (isset($_GET['page']))
    {
        $page = $_GET['page'];
    }


    $db_info = Database::InfoForConnection();
    class_alias('\RedBeanPHP\R', '\R');
    R::setup($db_info['dsn'], $db_info['username'], $db_info['password']);

    $total_pages = ceil(R::count('infofirma') / 3);
    $limit = 3;
    $all = R::findAll('infofirma',
        'ORDER BY ' . $_COOKIE['sort'] . ' LIMIT ' . $limit . ' OFFSET ' . ($page - 1) * $limit);

    function IsCurrentSorting($sort_classes_dict, $string_name_sort)
    {
        if ($sort_classes_dict[$string_name_sort] == $_COOKIE['sort'])
        {
            return "active";
        } else
        {
            return "";
        }
    }

    // TODO: Create 2 buttons for sorting, instead of 4
    echo '
    <button 
    type="button" 
    class="btn btn-outline-primary ' . IsCurrentSorting($sort_classes_dict, "date-asc") . '" 
    onclick="document.cookie=\'sort=' . $sort_classes_dict["date-asc"] . '\';window.location.reload(true);">
    Sort by Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
  <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
</svg>
    </button>';
    echo '
    <button 
    type="button" 
    class="btn btn-outline-primary ' . IsCurrentSorting($sort_classes_dict, "date-desc") . '" 
    onclick="document.cookie=\'sort=' . $sort_classes_dict["date-desc"] . '\';window.location.reload(true);">
    Sort by Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
  <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
</svg>
    </button>';
    echo '
    <button 
    type="button" 
    class="btn btn-outline-primary ' . IsCurrentSorting($sort_classes_dict, "firma-asc") . '" 
    onclick="document.cookie=\'sort=' . $sort_classes_dict["firma-asc"] . '\';window.location.reload(true);">
    Sort by Company Name <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
  <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
</svg>
    </button>';
    echo '
    <button 
    type="button" 
    class="btn btn-outline-primary ' . IsCurrentSorting($sort_classes_dict, "firma-desc") . '" 
    onclick="document.cookie=\'sort=' . $sort_classes_dict["firma-desc"] . '\';window.location.reload(true);">
    Sort by Company Name <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
  <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
</svg>
    </button>';

    foreach ($all as $item)
    {
        echo '
        <div class="card text-center" style="margin-bottom: 20px">
  <div class="card-header">
    ' . $item->obchodni_firma . '
  </div>
  <div class="card-body">
    <p class="card-text"><b>Datum vzniku: </b>' . $item->datum_vzniku . '</p>
    <p class="card-text"><b>Název okresu: </b>' . $item->name_of_okres . '</p>
    <p class="card-text"><b>Datum platnosti: </b>' . $item->datum_platnosti . '</p>
    <p class="card-text"><b>IČO: </b>' . $item->ico . '</p>
  </div>
  <div class="card-footer text-muted">
    ' . $item->date_time_search . '
  </div>
</div>
        ';
    }
    R::close();

    function is_first_page($page)
    {
        if ($page == 1)
        {
            return "disabled";
        } else
        {
            return "";
        }
    }

    function is_last_page($page, $total_pages)
    {
        if ($page == $total_pages)
        {
            return "disabled";
        } else
        {
            return "";
        }
    }

    function is_current_page($i, $page)
    {
        if ($i == $page)
        {
            return "active";
        } else
        {
            return "";
        }
    }

    echo '
<nav aria-label="Page navigation">
        <ul class="pagination" style="justify-content: center;">
            <li class="page-item ' . is_first_page($page) . '"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>
 ';
    for ($i = 1; $i <= $total_pages; $i++)
    {
        echo '<li class="page-item ' . is_current_page($i, $page) . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    echo '
            <li class="page-item ' . is_last_page($page, $total_pages) . '"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>
        </ul>
    </nav>
';
    ?>
</div>
</body>
</html>
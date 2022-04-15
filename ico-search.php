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
    require_once 'service/error_handler.php';

    if (is_numeric($_POST['ico']) and (strlen($_POST['ico']) < 9))
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi?ico=" . $_POST['ico'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $dom = new DomDocument;
        $dom->loadXML($response);
        $xpath = new DomXPath($dom);

// echo $xpath->query("//are:Adresa_ARES/dtt:Nazev_okresu/text()")->item(0)->wholeText;
        $pocet_zaznamu = $xpath->query("//are:Pocet_zaznamu/text()")->item(0)->wholeText;
        if ($pocet_zaznamu != 0)
        {
            $name_of_okres = $xpath->query("//dtt:Nazev_okresu/text()")->item(0)->wholeText;
            $datum_vzniku = $xpath->query("//are:Datum_vzniku/text()")->item(0)->wholeText;
            $datum_platnosti = $xpath->query("//are:Datum_platnosti/text()")->item(0)->wholeText;
            $obchodni_firma = $xpath->query("//are:Obchodni_firma/text()")->item(0)->wholeText;
            $ico = $_POST['ico'];
            $date_time_search = date("d-m-Y H:i:s");

            echo "<div style='margin-top: 20px'>
<p><b>Obchodní firma: </b>$obchodni_firma</p>
<p><b>Datum vzniku: </b>$datum_vzniku</p>
<p><b>Název okresu: </b>$name_of_okres</p>
<p><b>Datum platnosti: </b>$datum_platnosti</p>
<p><b>IČO: </b>$ico</p>
</div>
<form action='ico-search.php' method='post'>
    <p style='margin-top: 20px; margin-bottom: 20px'><b>Můžete najít další firmu.</b></p>
    <div class='form-group'>
        <input type='text' class='form-control' placeholder='ICO' name='ico'><br>
        <button type='submit' class='btn btn-primary'>Submit</button>
    </div>

</form>
";

            $db_info = Database::InfoForConnection();
            class_alias('\RedBeanPHP\R', '\R');
            R::setup($db_info['dsn'], $db_info['username'], $db_info['password']);

            $firma = R::dispense('infofirma');
            $firma->name_of_okres = $name_of_okres;
            $firma->datum_vzniku = $datum_vzniku;
            $firma->datum_platnosti = $datum_platnosti;
            $firma->ico = $ico;
            $firma->date_time_search = $date_time_search;
            $firma->obchodni_firma = $obchodni_firma;
            $id = R::store($firma);
            $firma = R::load('infofirma', 1);

            R::close();
        } else
        {

        }
        Send_Error_ICO_LOG($_POST['ico']);
        echo "
<form action='ico-search.php' method='post'>
    <p style='margin-top: 20px; margin-bottom: 20px'>Zkontrolujte, prosím, IČO! A zkuste znovu.</p>
    <div class='form-group'>
        <input type='text' value=" . $_POST['ico'] . " class='form-control' placeholder='ICO' name='ico'><br>
        <button type='submit' class='btn btn-primary'>Submit</button>
    </div>

</form>
    ";
    } else
    {
        Send_Error_ICO_LOG($_POST['ico']);
        if (is_numeric($_POST['ico']) and (strlen($_POST['ico']) >= 9))
        {
            echo "
<form action='ico-search.php' method='post'>

    <p style='margin-top: 20px; margin-bottom: 20px'>Zkontrolujte, prosím, IČO! A zkuste znovu.<br>IČO nemůže mít více, než 8 symbolů.</p>
    <div class='form-group'>
        <input type='text' value=" . $_POST['ico'] . " class='form-control' placeholder='ICO' name='ico'><br>
        <button type='submit' class='btn btn-primary'>Submit</button>
    </div>

</form>
";
        } else
        {
            echo "
<form action='ico-search.php' method='post'>

    <p style='margin-top: 20px; margin-bottom: 20px'>Prosím, používejte jen čísla! A zkuste znovu.</p>
    <div class='form-group'>
        <input type='text' class='form-control' placeholder='ICO' name='ico'><br>
        <button type='submit' class='btn btn-primary'>Submit</button>
    </div>

</form>
";
        }
    }


    ?>
</div>
</body>
</html>
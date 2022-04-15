<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php include('template/head.html') ?>
</head>
<body>
<div class="container">
    <?php include('template/nav.html') ?>
    <!--  TODO: ještě můžeme udělat validace IČO přes JS  -->
    <h6 style="margin-top: 20px; margin-bottom: 20px">Tady můžete najít základní informace o firmě při pomoci jen IČO.</h6>
    <form action="ico-search.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="ICO" name="ico"><br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
</div>
</body>
</html>
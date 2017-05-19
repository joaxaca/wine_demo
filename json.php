<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>KLF Challenge</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Wine Demo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="wines.php">Wine list</a></li>
            <li><a href="suppliers.php">Suppliers</a></li>
            <li><a href="regions.php">Regions</a></li>
            <li class="active"><a href="json.php">JSON</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <?php
      require 'classes/Database.php';

      $database = new Database;
      $database->query("select p.prodID, p.prodName, p.prodSellPrice, c.colProdDesc, r.regionName from Products p join colorProd c on c.colProdID = p.prodColorID join Regions r on r.regionID = p.prodRegionID WHERE prodID = 1");
      $rows = $database->resultset();

    ?>

    <h1>&nbsp;</h1>
    <div class="container theme-showcase" role="main">
      <div class="jumbotron">
        <h1>Array output</h1>
        <p><?php echo print_r($rows[0]); ?></p>
        <h1>JSON output</h1>
        <!--
        ***** Doesn't work on XAMPP or MAMP **********
        <p><?php //echo json_encode($rows[0]); ?></p>
        -->
      </div>
    </div>


  </body>
</html>

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
            <li class="active"><a href="wines.php">Wine list</a></li>
            <li><a href="suppliers.php">Suppliers</a></li>
            <li><a href="regions.php">Regions</a></li>
            <li><a href="json.php">JSON</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <?php
      require 'classes/Database.php';

      $database = new Database;
      $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

      if( isset($_GET{'id'})) {
        $id = $_GET{'id'};
      }
      else {
        $id = 0;
      }

      if( isset($_GET{'page'})) {
        $page = $_GET{'page'};
      }
      else {
        $page = 0;
      }

      $database->query("select p.prodID, p.prodName, p.prodSellPrice, c.colProdDesc, r.regionName from Products p left join colorProd c on c.colProdID = p.prodColorID left join Regions r on r.regionID = p.prodRegionID where p.prodID = $id");
      $rows = $database->resultset();
      //echo '<pre>', print_r($rows), '</pre>';

      $currency_symbol = '$';
    ?>

    <h1>&nbsp;</h1>
    <h1>Wine Details</h1>

    <!-- ToDo: Validate that there was a result -->
    <table class="table table-striped">
      <tr>
        <th>Name</th>
        <td><?php echo $rows[0]['prodName']; ?></td>
      </tr>
      <tr>
        <th>Color</th>
        <td><?php echo $rows[0]['colProdDesc']; ?></td>
      </tr>
      <tr>
        <th>Region</th>
        <td><?php echo $rows[0]['regionName']; ?></td>
      </tr>
      <tr>
        <th>Price</th>
        <!-- ToDo: Format the currency -->
        <td><?php echo $currency_symbol.$rows[0]['prodSellPrice']; ?></td>
      </tr>
    </table>
    <a class="btn btn-primary" role="button" href="wines.php?page=<?php echo $page; ?>">Back</a>

  </body>
</html>

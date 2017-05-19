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
      $rec_limit = 10;

      $database->query('select count(prodID) as total from Products');
      $rows = $database->resultset();
      $rec_count = $rows[0]['total'];

      if( isset($_GET{'page'})) {
        $page = $_GET{'page'} + 1;
        $offset = $rec_limit * $page;
      }
      else {
        $page = 0;
        $offset = 0;
      }

      $last_page = floor($rec_count / $rec_limit) - 1;
      $left_rec = $rec_count - ($page * $rec_limit);

      $database->query("select prodID, prodName, prodSellPrice from Products LIMIT $offset,$rec_limit");
      $rows = $database->resultset();
      //echo '<pre>', print_r($rows), '</pre>';

      $currency_symbol = '$';
    ?>

    <h1>&nbsp;</h1>

    <table class="table">
      <tr>
        <td><h1>Wine list</h1><td>
        <td align="right"><a class="btn btn-primary btn-lg" href="add_wine.php" role="button">Add a Wine</a></td>
        <td><h1>&nbsp;</h1></td>
      </tr>
    </table>

    <table class="table table-striped">
      <tr>
        <th>Name</th>
        <th>Price</th>
      </tr>
      <?php foreach($rows as $row): ?>
        <tr>
          <td><a href="wine_details.php?id=<?php echo $row['prodID']; ?>&page=<?php echo $page-1; ?>"><?php echo $row['prodName']; ?></a></td>
          <!-- ToDo: Format the currency -->
          <td><?php echo $currency_symbol.$row['prodSellPrice']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <?php
      if ($left_rec < $rec_limit) {
        $last = $page - 2;
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=-1\">Go to first page</a> ";
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$last\">Previous 10 Records</a> ";
      }
      elseif($page > 0) {
        $last = $page - 2;
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=-1\">Go to first page</a> ";
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$last\">Previous 10 Records </a> ";
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$page\">Next 10 Records</a> ";
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$last_page\">Go to last page</a> ";
      }
      elseif ($page == 0) {
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$page\">Next 10 Records</a> ";
        echo "<a class=\"btn btn-primary\" role=\"button\" href=\"".$_SERVER['PHP_SELF']."?page=$last_page\">Go to last page</a> ";
      }

    ?>
    <p/>
  </body>
</html>

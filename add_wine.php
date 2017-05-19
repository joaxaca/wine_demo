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

    <script>
      function validateForm() {
        var name = document.forms["wine"]["prod_name"].value;
        var price = document.forms["wine"]["prod_price"].value;
        if (name == "") {
          alert("Name must be filled out");
          return false;
        }
        if (price == "") {
          alert("Price must be filled out");
          return false;
        }
        if (isNaN(price)) {
          alert("Price must be numeric");
          return false;
        }

      }
    </script>
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

      if(isset($get['submit'])) {
        $prod_name = $get['prod_name'];
        $sold_out = $get['sold_out'];
        $prod_price = $get['prod_price'];

        // Add wine
        $database->query('insert into Products(prodName, prodSoldOut, prodSellPrice, prodColorID) values(:name, :sold_out, :price, :color)');
        $database->bind(':name', $prod_name);
        $database->bind(':sold_out', $sold_out);
        $database->bind(':price', $prod_price);
        // ********** All wines are red for this test. ********************
        // ****************************************************************
        $database->bind(':color', 1);

        $database->execute();
      }

    ?>

    <h1>&nbsp;</h1>
    <h1>Add Wine</h1>

    <form name="wine" action="add_wine.php" onsubmit="return validateForm()" method="get">
      <table class="table table-striped">
        <tr>
          <th>Name</th>
          <td><input type="text" size="60" name="prod_name"></td>
        </tr>
        <tr>
          <th>Sold out?</th>
          <td>
            <table>
              <tr><td><input type="radio" name="sold_out" value="0" checked="true"> No</td></tr>
              <tr><td><input type="radio" name="sold_out" value="1"> Yes</td></tr>
          </table>
          </td>
        </tr>
        <tr>
          <th>Price</th>
          <td><input type="text" name="prod_price"></td>
        </tr>
        <tr>
          <th></th>
          <td><input type="submit" name="submit" value="Submit"></td>
        </tr>
      </table>
    </form>

    <a class="btn btn-primary" role="button" href="wines.php">Back</a>

  </body>
</html>

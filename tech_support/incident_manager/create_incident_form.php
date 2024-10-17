<?php
session_start();

if (!isset($_SESSION['customer_email'])) {
  header('Location: index.php');
  exit();
}

require_once('../model/database.php');

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);


$queryProducts = 'SELECT * FROM products';
$statement = $db->prepare($queryProducts);
$statement->execute();
$products = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../main.css" />
  <title>Create Incident</title>
</head>
<body>
  <?php include("../view/header.php"); ?>
    <main>
      <h2>Create Incident</h2>
      <p>Customer: <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?> </p> </br>

      <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
      <?php endif; ?>
      
      <form action="create_incident.php" method="post">
            <label for="product">Select Product: </label>
              
                <select name="productID" id="product" required>
                    <option value="">Select a Product</option>
                    <?php foreach ($products as $product) : ?>
                      <option value="<?php echo $product['productCode']; ?>">
                        <?php echo $product['name']?>
                      </option>
                    <?php endforeach; ?>
                </select> <br><br>

            <label for="title">Incident Title: </label>
            <input type="text" name="title" id="title" required> <br><br>

            <label for="description">Incident Description: </label>
            <textarea name="description" id="description" rows="4" cols="50" required></textarea> <br><br>


            <input type="submit" value="Create Incident"/>
      </form>
      
      <form action="process_logout.php" method="post">
                <button type="submit">Logout</button>
      </form>

      <p><a href="../product_manager/index.php">View Product List</a></p>
    </main>
  <?php include("../view/footer.php"); ?>
</body>
</html>
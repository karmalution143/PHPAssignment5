<?php
  session_start();
    if (isset($_SESSION['customer_email'])) {
      header("Location: process_logout.php");
      exit();
    }

  require_once('../model/database.php');

  $query = 'SELECT email FROM customers';
  $statement = $db->prepare($query);
  $statement->execute();
  $customers = $statement->fetchAll();
  $statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../main.css" />
  <title>Customer Login</title>
</head>
<body>
  <?php include("../view/header.php"); ?>
    <main>
      
      <h2>Customer Login</h2>
      <p>You must login before you can register a product.</p><br>

      <form action="process_login.php" method="post">
          <label for="email">Email Address:</label>
          <select id="email" name="email" required>
            <option value="">Select Email</option>
            <?php foreach ($customers as $customer): ?>
              <option value="<?php echo htmlspecialchars($customer['email'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($customer['email'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <input type="submit" value="Get Customer">
      </form>

    </main>
  <?php include("../view/footer.php"); ?>
</body>
</html>
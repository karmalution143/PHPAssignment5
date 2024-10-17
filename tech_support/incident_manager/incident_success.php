<?php
session_start();
require_once('../model/database.php');

$customerID = $_SESSION['customer_id'];

$query = 'SELECT * FROM incidents WHERE customerID = :customerID';
$statement = $db->prepare($query);
$statement->bindValue(':customerID', $customerID);
$statement->execute();
$incidents = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php include("../view/header.php"); ?>
  <h2>The incident has been created</h2>
  <table>
        <tr>
            <th>CustomerID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date Opened</th>
        </tr>
        <?php foreach ($incidents as $incident): ?>
        <tr>
            <td><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></td>
            <td><?php echo $incident['title']; ?></td>
            <td><?php echo $incident['description']; ?></td>
            <td><?php echo $incident['dateOpened']; ?></td>
        </tr>
        <?php endforeach; ?>
  </table>
  <?php include("../view/footer.php"); ?>
</body>
</html>
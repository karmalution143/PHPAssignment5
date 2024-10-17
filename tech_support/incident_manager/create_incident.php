<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$customerID=$_SESSION['customer_id'];
$email=$_SESSION['customer_email'];

//Get input
$productCodeInput = filter_input(INPUT_POST, 'productID');
$titleInput = filter_input(INPUT_POST, 'title');
$descriptionInput = filter_input(INPUT_POST, 'description');

//Sanitize inputs using htmlspecialchars
$productCode = htmlspecialchars($productCodeInput, ENT_QUOTES, 'UTF-8');
$title = htmlspecialchars($titleInput, ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($descriptionInput, ENT_QUOTES, 'UTF-8');

$techID = null;
$dateOpened = date('Y-m-d');
$dateClosed = null;


if (!$productCode || !$customerID || !$title || !$description) {
    $_SESSION['error_message'] = "All fields are required.";
    header('Location: create_incident_form.php');
    exit();
}

require_once('../model/database.php');

$queryInsert = 'INSERT INTO incidents (customerID, productCode, techID, dateOpened, dateClosed, title, description)
                VALUES (:customerID, :productCode, :techID, :dateOpened, :dateClosed, :title, :description)';
$insertIncidentStmt = $db->prepare($queryInsert);
$insertIncidentStmt->bindValue(':customerID', $customerID);
$insertIncidentStmt->bindValue(':productCode', $productCode);
$insertIncidentStmt->bindValue(':techID', $techID);
$insertIncidentStmt->bindValue(':dateOpened', $dateOpened);
$insertIncidentStmt->bindValue(':dateClosed', $dateClosed);
$insertIncidentStmt->bindValue(':title', $title);
$insertIncidentStmt->bindValue(':description', $description);
$insertIncidentStmt->execute();
$insertIncidentStmt->closeCursor();

header('Location: incident_success.php');
exit();
?>
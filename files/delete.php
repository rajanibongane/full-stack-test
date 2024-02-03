<?php
if( isset($_GET["id"])){
    $id = $_GET["id"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

$errorMessage = "";
$successMessage = "";

$sql = "DELETE FROM users WHERE id = $id";
    $result = $connection->query($sql);

    if (!$result) {
        $errorMessage = "Error deleting user: " . $connection->error;
    } else {
        $successMessage = "User deleted successfully.";
    }
}

header("location: allUsers.php");
exit;
?>
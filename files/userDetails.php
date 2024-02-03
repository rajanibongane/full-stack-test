<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET["name"])) {
    $name = $_GET["name"];

    // Fetch user details from the database based on the clicked name
    $query = "SELECT * FROM users WHERE name = '$name'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();

        // Return user details as JSON
        echo json_encode($userDetails);
    } else {
        echo "User not found";
    }
} else {
    echo "Invalid request";
}

$connection->close();
?>

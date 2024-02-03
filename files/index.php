<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$email = "";
$phone = "";
$address = "";
$actions = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $actions = $_POST["actions"];

    list($actions, $imagePath) = explode(" - ", $actions);


    do {
        if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($actions)){
            $errorMessage = "All the fields are required";
            break;
        }

        //add new user to database
        $sql = "INSERT INTO users(name, email, phone, address, actions, image_path)".
        "VALUES ('$name', '$email', '$phone', '$address', '$actions', '$imagePath')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:".$connection->error;
            break;
        }

        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        $actions = "";

        $successMessage = "User added succesully.";
        header("location: index.php");
        exit;

    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <style>
    h2 {
        color: Black;
        margin-bottom: 20px;
        border-bottom: 2px solid Black;
        padding-bottom: 10px;
        background-color: LightGray;
        width: 100%;
        box-sizing: border-box;
    }

    .fixed-h2 {
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: light gray;
    }

    .user-list-column {
        text-align: center;
        border: 2px solid Black;
        background-color: light gray;
        overflow-y: auto;
        max-height: 300px;
    }

    .user-details-column,
    .actions-column {
        text-align: center;
        border: 2px solid Black;
        background-color: light gray;
    }

    .user-list-column table {
        width: 100%;
    }

    .user-list-column td {
        padding: 10px;
    }

    .user-list-column td:hover {
        background-color: LightGray;
        cursor: pointer;
    }

    .user-details-column,
    .actions-column {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .action-images img {
        max-width: 100%;
        height: auto;
        width: 100%;
        object-fit: cover;
        border: 1px solid Black;
        border-radius: 8px;
    }

    .user-name {
        font-size: 20px;
    }

    #userDetails {
        font-size: 20px;
    }

    .selected-user {
        background-color: LightGray;
        font-weight: bold;
    }
    </style>

</head>

<body>
    <div class="container my-5">
        <a class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</a>
        <a class="btn btn-primary" href="allUsers.php" role="button">All Users</a>

        <?php
        if(!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn btn-close' data-bs-dismiss='alert' aria=label='close'></button>
            </div>
            ";
        }
        ?>

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="email" value="<?php echo $email;?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="phone" value="<?php echo $phone;?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="address"
                                        value="<?php echo $address;?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Actions</label>
                                <div class="col-sm-6">
                                    <select id="dropdown" name="actions" onchange="updateImagePath()">
                                        <option value="DL-communication - images/DL-communication.svg"
                                            data-image-path="images/DL-communication.svg">DL-communication</option>
                                        <option value="DL-learning - images/DL-learning.svg"
                                            data-image-path="images/DL-learning.svg">
                                            DL-learning</option>
                                        <option value="DL-technology - images/DL-technology.svg"
                                            data-image-path="images/DL-technology.svg">DL-technology</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="image_path" id="imagePathInput" value="">

                            <script>
                            function updateImagePath() {
                                console.log("Updating image path");
                                var dropdown = document.getElementById("dropdown");
                                var selectedOption = dropdown.options[dropdown.selectedIndex];
                                var imagePathInput = document.getElementById("imagePathInput");

                                if (selectedOption) {
                                    var imagePath = selectedOption.getAttribute("data-image-path");
                                    console.log("Selected Image Path:", imagePath);
                                    imagePathInput.value = imagePath;
                                }
                            }
                            </script>

                            <?php
                            if (!empty($successMessage)) {
                                echo "
                                <div class='row mb-3'>
                                    <div class='offset-sm-3 col-sm-6'>
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$successMessage</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                                    </div>
                                    </div>
                                </div>
                                ";
                            }
                            ?>

                            <div class="row mb-3">
                                <div class="offset-sm-3 col-sm-3 d-grid">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-3 d-grid">
                                    <button type="button" class="btn btn-outline-primary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Display user details columns (In Web View) -->

        <div class="container my-5">
            <div class="row">
                <div class="col-md-4 user-list-column">
                    <h2 class="fixed-h2">User List</h2>
                    <table class="table">
                        <tbody>
                            <?php
                        // Fetch and display user names in the first column
                        $query = "SELECT name FROM users";
                        $result = $connection->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $userName = $row["name"];
                                echo "<tr data-username='$userName'><td class='user-name'>$userName</td></tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!-- Display user details in the second column -->
                <div class="col-md-4 user-details-column">
                    <h2>User Details</h2>
                    <div id="userDetails" class="mt-5"></div>
                </div>

                <!-- Display actions images in the third column -->
                <div class="col-md-4 actions-column">
                    <h2>Actions</h2>
                    <div id="actionImages" class="action-images mt-5"></div>
                    <div id="actionName" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const userNames = document.querySelectorAll(".user-name");
        const userDetailsDiv = document.getElementById("userDetails");
        const actionImagesDiv = document.getElementById("actionImages");
        const actionNameDiv = document.getElementById("actionName");

        // Function to fetch user details
        function fetchUserDetails(name) {
            fetch(`userDetails.php?name=${name}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data !== "User not found") {
                        userDetailsDiv.innerHTML = `
                            <strong>Name:</strong> ${data.name}<br>
                            <strong>Email:</strong> ${data.email}<br>
                            <strong>Phone:</strong> ${data.phone}<br>
                            <strong>Address:</strong> ${data.address}<br>
                        `;

                        // Display the action image
                        const actionImagesDiv = document.getElementById("actionImages");
                        actionImagesDiv.innerHTML =
                            `<img src='${data.image_path}' alt='${data.actions}' class='action-image' />`;
                        actionNameDiv.textContent = `${data.actions}`;
                    } else {
                        userDetailsDiv.innerHTML = "User not found";
                        actionImagesDiv.innerHTML = "Not Found";
                        actionNameDiv.textContent = "Not Found";
                    }
                })
                .catch((error) => console.error("Error fetching user details:", error));
        }

        // Click event for the first user by default
        if (userNames.length > 0) {
            const defaultUser = userNames[0].textContent;
            fetchUserDetails(defaultUser);
            userNames[0].parentNode.classList.add('selected-user');
        }

        // Click event for other users
        userNames.forEach((userName) => {
            userName.addEventListener("click", function() {
                const name = userName.textContent;
                fetchUserDetails(name);
                userNames.forEach(row => row.parentNode.classList.remove('selected-user'));

                userName.parentNode.classList.add('selected-user');
            });
        });
    });
    </script>
    </div>
</body>

</html>
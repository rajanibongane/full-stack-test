 <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";
$actions = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    //Shows the data of user

    if(!isset($_GET["id"])){
        header("location: allUsers.php");
        exit;
    }
    $id = $_GET["id"];

    //read the row of the selected client rom database table
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row) {
        header("loaction: allUsers.php");
        exit;
    }

    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
    $actions = $row["actions"];
}
else{
    //update the data of the users
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $actions = $_POST["actions"];


    do {
        if(empty($id) || empty($name) || empty($email) || empty($phone) || empty($address) || empty($address)){
            $errorMessage = "All the fields are required";
            break;
        }

        $sql= "UPDATE users " .
      "SET name = '$name', email = '$email', phone = '$phone', address = '$address', actions = '$actions' " .
      "WHERE id = $id";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:".$connection->error;
            break;
        }
        $successMessage = "User added succesully.";
        header("location: allUsers.php");
        exit;

    }while(false);
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

 </head>

 <body>
     <div class="container my-5">
         <h2>Edit User</h2>

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

         <form method="post">
             <input type="hidden" name="id" value="<?php echo $id;?>">
             <div class="row mb-3">
                 <label class="col-sm-3 col-form-label">Name</label>
                 <div class="col-sm-6">
                     <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                 </div>
             </div>
             <div class="row mb-3">
                 <label class="col-sm-3 col-form-label">Email</label>
                 <div class="col-sm-6">
                     <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
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
                     <input type="text" class="form-control" name="address" value="<?php echo $address;?>">
                 </div>
             </div>
             <div class="row mb-3">
                 <label class="col-sm-3 col-form-label">Actions</label>
                 <div class="col-sm-6">
                     <select class="form-select" name="actions">
                         <option value="DL-communication"
                             <?php echo ($actions == 'DL-communication') ? 'selected' : ''; ?>>DL-communication</option>
                         <option value="DL-learning" <?php echo ($actions == 'DL-learning') ? 'selected' : ''; ?>>
                         DL-learning</option>
                         <option value="DL-technology" <?php echo ($actions == 'DL-technology') ? 'selected' : ''; ?>>
                         DL-technology</option>
                     </select>
                 </div>
             </div>


             <?php
            if(!empty($successMessage)){
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn btn-close' data-bs-dismiss='alert' aria=label='close'></button>
                </div>
                ";
            }
            
            ?>

             <div class="row mb-3">
                 <div class="offset-sm-3 col-sm-3 d-grid">
                     <button type="submit" class="btn btn-primary">Submit</button>
                 </div>
                 <div class="col-sm-3 d-grid">
                     <a class="btn btn-outline-primary" href="allUsers.php" role="button">Cancel</a>
                 </div>
             </div>
         </form>
     </div>

 </body>

 </html>
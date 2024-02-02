<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2>All Users</h2>
        <a class="btn btn-primary" href="create.php" role="button">Add User</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "test";
            
                // Create a connection
                $connection = new mysqli($servername, $username, $password, $database);
                  
                // Check connection
                if ($connection->connect_error) {
                    die("Connection Failed: ". $connection->connect_error);
                }

                // read all row from database table
                $sql = "SELECT * FROM users";
                $result = $connection->query($sql);
                
                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                //read data of each row
                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address]</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='edit.php?id=$row[id]'>EDIT</a>
                        <a class='btn btn-danger btn-sm' href='delete.php?id=$row[id]'>DELETE</a>
                    </td>
                </tr>
                ";
                }
                ?>
                
            </tbody>
        </table>
    </div>
</body>

</html>
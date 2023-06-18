<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch all clients data
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);

// delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    $deleteSql = "DELETE FROM clients WHERE id='$id'";
    
    if ($conn->query($deleteSql) === TRUE) {
        echo "Record deleted successfully.";
        header("Location: clientsdata.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Client Page</title>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css"
    />
</head>
<style>
    .bg-custom {
      background-image: url("background/clientsdata.jpg");
    }
  </style>
<body class="bg-custom bg-cover h-screen">
<div
        class="container mx-auto flex justify-between items-center mt-4 bg-gray-900 p-3"
>
<a href="main.html">
    <img src="logo.png" alt="Logo" class="w-25 h-10"/>
    </a>
    <h1 class="text-2xl text-white justify-center font-bold">
        Client Information
    </h1>
    <a href="clients.php" class="text-white hover:text-gray-200">Back</a>
</div>

<div class="container py-10">
    <div class=" mx-10 ">
        <table class="table-auto w-full">
            <thead>
            <tr>
                <th class="px-4 py-2 text-white">ID</th>
                <th class="px-4 py-2 text-white">Name</th>
                <th class="px-4 py-2 text-white">Email</th>
                <th class="px-4 py-2 text-white">Phone</th>
                <th class="px-4 py-2 text-white">Invoice Date</th>
                <th class="px-4 py-2 text-white">Package Name</th>
                <th class="px-4 py-2 text-white">Quantity</th>
                <th class="px-4 py-2 text-white">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["id"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["email"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["phone"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["invoice_date"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["package_name"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>" . $row["quantity"] . "</td>";
                    echo "<td class='border px-4 py-2 text-white'>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<div class='flex justify-center items-center'>" ;
                    echo "<input type='submit' name='update' value='Update' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2'>";
                    echo "<input type='submit' name='delete' value='Delete' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>";
                    echo "</div>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='border px-4 py-2'>No clients found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

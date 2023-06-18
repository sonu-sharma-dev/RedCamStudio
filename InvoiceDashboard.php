<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Fetch all invoices from the database
$query = "SELECT * FROM invoices";
$result = mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<style>
    .bg-custom {
      background-image: url("background/invoiceD.jpg");
      opacity: 90%;
    }
    .container{
       background: #4d2912;
    }
  </style>
<body class=" bg-custom bg-cover h-screen ">
    <div class="container mx-auto p-8 ">
        <div class="flex justify-between ">
        <h1 class="text-2xl font-bold mb-4 text-white">Invoice Dashboard</h1>
        <a href="main.html" class="text-2xl text-white">Back</a>
        </div>
        
        <table class="table-auto w-full">
            <thead>
            <tr class="bg-gray-900 text-white">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Invoice Date</th>
                    <th class="px-4 py-2">Package Description</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Total Amount</th>
                    <th class="px-4 py-2">Generate Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the invoices and display them in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['id'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['name'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['email'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['phone'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['invoice_date'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['package_description'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['quantity'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['price'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'>" . $row['total_amount'] . "</td>";
                    echo "<td class='px-4 py-2 text-whit'><a href='invoice.php?id=" . $row['id'] . "' class='text-white'>Generate</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
//connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";
$conn = mysqli_connect($servername, $username, $password, $database);
//checks connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
if (isset($_GET['id'])) {
    $invoiceId = $_GET['id'];

    // Fetch data of  invoice from the database
    $query = "SELECT * FROM invoices WHERE id = $invoiceId";
    $result = mysqli_query($conn, $query);

    // Check if the invoice exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the invoice details
        $invoice = mysqli_fetch_assoc($result);

        // Fetch the invoice items from the database
        $queryItems = "SELECT * FROM invoices WHERE id = $invoiceId";
        $resultItems = mysqli_query($conn, $queryItems);

        // Store the invoice items in an array
        $items = [];
        while ($row = mysqli_fetch_assoc($resultItems)) {
            $items[] = $row;
        }
    } else {
       // display an error message 
        header("Location: index.html");
        exit();
    }
} else {
    // display an error message
    header("Location: index.html");
    exit();
}
// Close connection 
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <title>Invoice</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto flex justify-between items-center mt-8 bg-gray-900 p-3">
        <img src="logo.png" alt="Logo" class="h-10  " />
        <h1 class="text-2xl text-white justify-center font-bold">Invoice</h1>
        <a href="InvoiceDashboard.php" class="text-white hover:text-gray-200">Back</a>
    </div>
    <div class="container mx-auto p-8">
        <div class="bg-white shadow-md rounded-lg p-8">
            <div class="flex justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold">Invoice</h1>
                    <p class="text-gray-500">Date: <span id="date"><?php echo $invoice['invoice_date']; ?></span></p>
                </div>
            </div>

            <div class="flex justify-between mb-8">
                <div>
                    <h2 class="text-xl">Bill To:</h2>
                    <h2 class="text-xl font-bold" id="customerName"><?php echo $invoice['name']; ?></h2>
                    <p id="customerAddress"><?php echo $invoice['email']; ?></p>
                </div>
            </div>

            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-900 text-white">
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>

                <tbody id="invoices">
                    <?php
                    // Loop through the invoice items and display them in the table
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td class='px-4 py-2'>" . $item['quantity'] . "</td>";
                        echo "<td class='px-4 py-2'>" . $item['package_description'] . "</td>";
                        echo "<td class='px-4 py-2'>" . $item['price'] . "</td>";
                        echo "<td class='px-4 py-2'>" . ($item['quantity'] * $item['price']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>

                <tfoot>
                    <tr class="bg-gray-900 text-white">
                        <td colspan="4" class="text-right pr-4 py-2 font-bold">Total Amount:</td>
                        <td id="totalAmount" class="text-right pr-4 py-2 font-bold">
                            <?php echo $invoice['total_amount']; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="bg-yellow-500 h-1 w-full"></div>

            <div class="flex justify-end mt-8">
                <div>
                    <p class="font-bold">Owner's Name:</p>
                    <p class="text-right">Satish Malani</p>
                </div>
                <div class="ml-8">
                    <p class="font-bold">Owner's Signature:</p>
                    <div class="border border-gray-500 h-20 w-48"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

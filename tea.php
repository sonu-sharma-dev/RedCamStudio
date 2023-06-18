<?php
// Connect to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define variables for data insertion and update
$date = "";
$quantity = "";
$errorMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $date = $_POST['date'];
    $quantity = $_POST['quantity'];

    if (empty($date) || empty($quantity)) {
        $errorMsg = "Please fill in all fields.";
    } else {
        // Check if there is an existing record for the given date
        $existingRecordQuery = "SELECT * FROM tea_expenses WHERE date = '$date'";
        $existingRecordResult = mysqli_query($conn, $existingRecordQuery);

        if (mysqli_num_rows($existingRecordResult) > 0) {
            // Update the existing record
            $existingRecord = mysqli_fetch_assoc($existingRecordResult);
            $existingQuantity = $existingRecord['quantity'];
            $existingTotalPrice = $existingRecord['total_price'];

            $newQuantity = $existingQuantity + $quantity;
            $newTotalPrice = $existingTotalPrice + ($quantity * 50);

            $updateQuery = "UPDATE tea_expenses SET quantity = '$newQuantity', total_price = '$newTotalPrice' WHERE date = '$date'";

            // Execute the query
            if (mysqli_query($conn, $updateQuery)) {
                // Success message or redirect to desired page
            } else {
                $errorMsg = "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
            }
        } else {
            // Insert a new record
            $total_price = $quantity * 50;

            $insertQuery = "INSERT INTO tea_expenses (date, quantity, total_price) VALUES ('$date', '$quantity', '$total_price')";

            // Execute the query
            if (mysqli_query($conn, $insertQuery)) {
                // Success message or redirect to desired page
            } else {
                $errorMsg = "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        }
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];

    // Delete the tea expense record
    $sql = "DELETE FROM tea_expenses WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: tea.php");
    } else {
        $errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Retrieve merged tea expenses data for each date

// Filter
$selectedMonth = $_GET['month'] ?? date('m');
$selectedYear = $_GET['year'] ?? date('Y');
$sql = "SELECT id, date, SUM(quantity) AS quantity, SUM(total_price) AS total_price FROM tea_expenses WHERE MONTH(date) = '$selectedMonth' AND YEAR(date) = '$selectedYear' GROUP BY date, id ORDER BY date DESC";
$result = mysqli_query($conn, $sql);

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Calculate the total expenses for the current month
$sqlTotal = "SELECT SUM(total_price) AS total FROM tea_expenses WHERE MONTH(date) = '$selectedMonth' AND YEAR(date) = '$selectedYear'";
$resultTotal = mysqli_query($conn, $sqlTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalExpenses = $rowTotal['total'];

// Close the connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tea Expense Tracker</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div
      class="container mx-auto flex justify-between items-center mt-8 bg-gray-900 p-3"
    >
      <img src="logo.png" alt="Logo" class="w-20 h-10" />
      <h1 class="text-2xl text-white justify-center font-bold">
        Tea Expense Tracker
      </h1>
      <a href="expenses.php" class="text-white hover:text-gray-200">Back</a>
    </div>
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
      <div class="container flex justify-center mx-auto p-8">
        <img
          src="tea.jpg"
          alt="Tea"
          class="w-64 mx-auto mb-8 rounded-full shadow-lg"
        />
        <div>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-4">
              <label for="date" class="block text-lg text-gray-900">Date</label>
              <input
                type="date"
                id="date"
                name="date"
                class="border border-gray-300 rounded px-4 py-2"
                value="<?php echo $date; ?>"
                required
              />
            </div>
            <div class="mb-4">
              <label for="quantity" class="block text-lg text-gray-900"
                >Quantity</label
              >
              <input
                type="number"
                id="quantity"
                name="quantity"
                class="border border-gray-300 rounded px-4 py-2"
                value="<?php echo $quantity; ?>"
                required
              />
            </div>
            <button
              type="submit"
              id="saveBtn"
              class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-6 py-3 rounded-full shadow-lg transition-colors duration-300"
            >
              Save
            </button>
            <p id="errorMsg" class="text-red-600 mt-4"><?php echo $errorMsg; ?></p>
          </form>
        </div>
      </div>
      <div class="container mx-auto mt-8">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4">
          <label for="monthSelect" class="mr-2">Select Month:</label>
          <select id="monthSelect" name="month" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 rounded">
            <?php
            for ($month = 1; $month <= 12; $month++) {
                $selected = ($selectedMonth == $month) ? 'selected' : '';
                echo "<option value='$month' $selected>" . date('F', mktime(0, 0, 0, $month, 1)) . "</option>";
            }
            ?>
          </select>

          <label for="yearSelect" class="mr-2 ml-4">Select Year:</label>
          <select id="yearSelect" name="year" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 rounded">
            <?php
            $currentYear = date('Y');
            for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                $selected = ($selectedYear == $year) ? 'selected' : '';
                echo "<option value='$year' $selected>$year</option>";
            }
            ?>
          </select>
        </form>
        <table class="table-auto border-collapse border border-gray-300">
          <thead>
            <tr>
              <th class="py-3 px-4 bg-gray-200 border border-gray-300">Date</th>
              <th class="py-3 px-4 bg-gray-200 border border-gray-300">Quantity</th>
              <th class="py-3 px-4 bg-gray-200 border border-gray-300">Total Price</th>
              <th class="py-3 px-4 bg-gray-200 border border-gray-300">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td class="py-1 px-1"><?php echo $row['date']; ?></td>
              <td class="py-1 px-1"><?php echo $row['quantity']; ?></td>
              <td class="py-1 px-1"><?php echo $row['total_price']; ?></td>
              <td class="py-1 px-1">
                <a href="<?php echo 'tea.php?action=edit&id=' . $row['id']; ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                <a href="<?php echo 'tea.php?action=delete&id=' . $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <p class="text-gray-900 text-lg mt-4">
          Total expenses for the current month: <?php echo $totalExpenses; ?>
        </p>
      </div>
    </div>
  </body>
</html>

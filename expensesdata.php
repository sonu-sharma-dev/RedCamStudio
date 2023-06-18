<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch monthly expenses
$selectedMonth = $_GET['month'] ?? date('m');
$selectedYear = $_GET['year'] ?? date('Y');
$monthlyExpensesSql = "SELECT * FROM monthly_expenses WHERE MONTH(expense_date) = '$selectedMonth' AND YEAR(expense_date) = '$selectedYear'";
$monthlyExpensesResult = $conn->query($monthlyExpensesSql);

// Calculate the total expenses for the selected month and year
$totalExpensesQuery = "SELECT SUM(expense_amount) AS total_expenses FROM monthly_expenses WHERE MONTH(expense_date) = '$selectedMonth' AND YEAR(expense_date) = '$selectedYear'";
$totalExpensesResult = $conn->query($totalExpensesQuery);
$totalExpensesRow = $totalExpensesResult->fetch_assoc();
$totalExpense = $totalExpensesRow['total_expenses'];

// Delete data
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $deleteSql = "DELETE FROM monthly_expenses WHERE id = '$deleteId'";
    $conn->query($deleteSql);
    header("Location: expensesdata.php?month=$selectedMonth&year=$selectedYear");
    exit();
}

// Update data
if (isset($_POST['update'])) {
    $updateId = $_POST['updateId'];
    $newExpenseName = $_POST['expense_name'];
    $newExpenseAmount = $_POST['expense_amount'];

    $updateSql = "UPDATE monthly_expenses SET expense_name = '$newExpenseName', expense_amount = '$newExpenseAmount' WHERE id = '$updateId'";
    $conn->query($updateSql);
    header("Location: expenses.php?month=$selectedMonth&year=$selectedYear");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Data</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-custom {
            background-image: url("background/expensesD.jpg");
        }
    </style>
</head>
<body class="bg-custom bg-cover h-screen">
<div class="container mx-auto flex justify-between items-center mt-4 bg-gray-900 p-3">
    <a href="main.html">
        <img src="logo.png" alt="Logo" class="w-25 h-10"/>
    </a>
    <h1 class="text-2xl text-white justify-center font-bold">Expenses</h1>
    <a href="expenses.php" class="text-white hover:text-gray-200">Back</a>
</div>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <form action="" method="GET" class="mb-4">
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

        <?php if ($monthlyExpensesResult->num_rows > 0): ?>
            <table class="table-auto w-full">
                <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Expense Name</th>
                    <th class="px-4 py-2">Expense Amount</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
    <?php while ($row = $monthlyExpensesResult->fetch_assoc()): ?>
        <tr <?php if ($row["expense_name"] === 'Tea Expense') echo 'class="bg-yellow-200"'; ?>>
            <td class="px-4 py-2"><?php echo $row["expense_name"]; ?></td>
            <td class="px-4 py-2"><?php echo $row["expense_amount"]; ?></td>
            <td class="px-4 py-2">
                <a href="?delete=<?php echo $row["id"]; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                <?php if ($row["expense_name"] !== 'Tea Expense'): ?>
                    <button onclick="openUpdateModal(<?php echo $row['id']; ?>)"
                            class="text-blue-500 hover:text-blue-700">Update
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?> 
</tbody>

                <tfoot>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2"><?php echo $totalExpense; ?></th>
                    <th class="px-4 py-2"></th>
                </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>No monthly expenses found.</p>
        <?php endif; ?>

        <!-- Update Expense Modal -->
        <div id="updateModal" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-75 hidden">
            <div class="bg-white p-4 rounded">
                <h2 class="text-xl font-bold mb-4">Update Expense</h2>
                <form action="" method="POST">
                    <input type="hidden" id="updateId" name="updateId" value="">
                    <div class="mb-2">
                        <label for="expense_name" class="mr-2">Expense Name:</label>
                        <input type="text" id="expense_name" name="expense_name"
                               class="border border-gray-300 px-2 py-1 rounded">
                    </div>
                    <div class="mb-2">
                        <label for="expense_amount" class="mr-2">Expense Amount:</label>
                        <input type="number" id="expense_amount" name="expense_amount"
                               class="border border-gray-300 px-2 py-1 rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" name="update"
                                class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-4 rounded">Update
                        </button>
                        <button type="button" onclick="closeUpdateModal()"
                                class="bg-gray-500 hover:bg-gray-700 text-white py-1 px-4 rounded ml-2">Cancel
                        </button>
                    </div>
                </form>
             
            </div>
        </div>
       

        <script>
            // Open the update modal and populate the fields
            function openUpdateModal(expenseId) {
                const modal = document.getElementById('updateModal');
                const expenseNameField = document.getElementById('expense_name');
                const expenseAmountField = document.getElementById('expense_amount');
                const updateIdField = document.getElementById('updateId');

                // Get the expense details from the table row
                const expenseName = document.querySelector(`tr[data-id="${expenseId}"] td:nth-child(1)`).innerText;
                const expenseAmount = document.querySelector(`tr[data-id="${expenseId}"] td:nth-child(2)`).innerText;

                // Populate the fields with the expense details
                expenseNameField.value = expenseName;
                expenseAmountField.value = expenseAmount;
                updateIdField.value = expenseId;

                // Show the update modal
                modal.classList.remove('hidden');
            }

            // Close the update modal
            function closeUpdateModal() {
                const modal = document.getElementById('updateModal');
                modal.classList.add('hidden');
            }
        </script>
    </div>
</div>
</body>
</html>

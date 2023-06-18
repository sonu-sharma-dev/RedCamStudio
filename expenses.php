<?php
//connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "redcam";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection  valid or not..
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save monthly electricity bill
if (isset($_POST['electricityDate']) && isset($_POST['electricityAmount'])) {
  $electricityDate = $_POST['electricityDate'];
  $electricityAmount = $_POST['electricityAmount'];

  $sql1 = "INSERT INTO monthly_expenses (expense_name, expense_date, expense_amount) VALUES ('Electricity', '$electricityDate', '$electricityAmount')";
  //checks insertion succesful or not..
  if ($conn->query($sql1) === TRUE) {
      echo "Electricity Bill saved successfully.<br>";
  } else {
      echo "Error: " . $sql1 . "<br>" . $conn->error;
  }
}


// Save water bill
if (isset($_POST['waterDate']) && isset($_POST['waterAmount'])) {
    $waterDate = $_POST['waterDate'];
    $waterAmount = $_POST['waterAmount'];

    $sql2 = "INSERT INTO monthly_expenses (expense_name, expense_date, expense_amount) VALUES ('Water', '$waterDate', '$waterAmount')";
      //checks insertion succesful or not..
    if ($conn->query($sql2) === TRUE) {
        echo "Water Bill saved successfully.<br>";
    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
}

// Save internet bill
if (isset($_POST['internetDate']) && isset($_POST['internetAmount'])) {
    $internetDate = $_POST['internetDate'];
    $internetAmount = $_POST['internetAmount'];

    $sql3 = "INSERT INTO monthly_expenses (expense_name, expense_date, expense_amount) VALUES ('Internet', '$internetDate', '$internetAmount')";

      //checks insertion succesful or not..
    if ($conn->query($sql3) === TRUE) {
        echo "Internet Bill saved successfully.<br>";
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn->error;
    }
}

// Save employee salary
if (isset($_POST['employeeSalaryDate']) && isset($_POST['employeeSalaryAmount']) && isset($_POST['employeeName'])) {
    $employeeSalaryDate = $_POST['employeeSalaryDate'];
    $employeeSalaryAmount = $_POST['employeeSalaryAmount'];
    $employeeName = isset($_POST["employeeName"]) ? $_POST["employeeName"] : "";

    $sql4 = "INSERT INTO employee_salaries (salary_date, salary_amount, employee_name) VALUES ('$employeeSalaryDate', '$employeeSalaryAmount', '$employeeName')";

    if ($conn->query($sql4) === TRUE) {
        echo "Employee Salary saved successfully.<br>";
    } else {
        echo "Error: " . $sql4 . "<br>" . $conn->error;
    }
}

// Save other expenses
if (isset($_POST['otherExpenseName']) && isset($_POST['otherExpenseDate']) && isset($_POST['otherExpenseAmount'])) {
    $otherExpenseName = $_POST['otherExpenseName'];
    $otherExpenseDate = $_POST['otherExpenseDate'];
    $otherExpenseAmount = $_POST['otherExpenseAmount'];

    $sql5 = "INSERT INTO other_expenses (expense_name, expense_date, expense_amount) VALUES ('$otherExpenseName', '$otherExpenseDate', '$otherExpenseAmount')";

    if ($conn->query($sql5) === TRUE) {
        echo "Other Expense saved successfully.<br>";
    } else {
        echo "Error: " . $sql5 . "<br>" . $conn->error;
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redcam</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .expense-container {
            display: none;
        }

        .expense-container.active {
            display: block;
        }

        .bg-custom {
            background-image: url("background/expenses.jpg");
        }
    </style>
</head>
<body class="bg-custom bg-cover h-screen">
    <!-- Logo -->
    <div class="container mx-auto flex justify-between items-center mt-4 bg-gray-900 p-3">
    <a href="main.html">
    <img src="logo.png" alt="Logo" class="w-25 h-10"/>
    </a>
        <h1 class="text-2xl text-white justify-center font-bold">Expenses</h1>
        <a href="main.html" class="text-white hover:text-gray-200">Back</a>
    </div>

    <!-- Navigation -->
    <div class="flex justify-center my-8">
        <ul class="flex space-x-4 text-xl underline">
            <li></li>
            <li>
                <a href="#" class="text-white hover:text-white font-semibold hover:bg-gray-900" onclick="showExpense('monthlyExpense')">Monthly Expense</a>
            </li>
            <li>
                <a href="tea.php" class="text-white hover:text-white font-semibold hover:bg-gray-900">Tea Expense</a>
            </li>
            <li>
                <a href="#" class="text-white hover:text-white font-semibold hover:bg-gray-900" onclick="showExpense('otherExpense')">Other Expense</a>
            </li>
            <li>
                <a href="expensesdata.php" class="text-white hover:text-white font-semibold hover:bg-gray-900">All expenses data</a>
            </li>
        </ul>
    </div>

    <div id="monthlyExpense">
        <h1 class="text-2xl font-bold mb-4">Monthly Expense</h1>
        <form action="expenses.php" method="post" class="flex flex-wrap mb-8">
            <div class="mr-4 mb-4">
                <label for="electricityDate" class="block">Date</label>
                <input type="date" id="electricityDate" name="electricityDate" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <div class="mr-4 mb-4">
                <label for="electricityAmount" class="block">Electricity Bill Amount</label>
                <input type="number" id="electricityAmount" name="electricityAmount" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-4 m-3 rounded">Save</button>
        </form>
                   <!-- Water Bill -->
        <form action="expenses.php" method="post" class="flex flex-wrap mb-8">
            <div class="mr-4 mb-4">
                <label for="waterDate" class="block">Water Bill Date</label>
                <input type="date" id="waterDate" name="waterDate" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <div class="mr-4 mb-4">
                <label for="waterAmount" class="block">Water Bill Amount</label>
                <input type="number" id="waterAmount" name="waterAmount" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-4 m-3 rounded">Save</button>
        </form>
             <!-- Internet Bill -->
        <form action="expenses.php" method="post" class="flex flex-wrap mb-8">
            <div class="mr-4 mb-4">
                <label for="internetDate" class="block">Internet Bill Date</label>
                <input type="date" id="internetDate" name="internetDate" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <div class="mr-4 mb-4">
                <label for="internetAmount" class="block">Internet Bill Amount</label>
                <input type="number" id="internetAmount" name="internetAmount" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-4 m-3 rounded">Save</button>
        </form>
           <!-- salary -->
        <form action="expenses.php" method="post" class="flex flex-wrap mb-8">
            <div class="mr-4 mb-4">
                <label for="employeeSalaryDate" class="block">Date</label>
                <input type="date" id="employeeSalaryDate" name="employeeSalaryDate" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <div class="mr-4 mb-4">
                <label for="employeeSalaryAmount" class="block">Amount</label>
                <input type="number" id="employeeSalaryAmount" name="employeeSalaryAmount" class="border border-gray-300 rounded px-2 py-1" required>
            </div>
            <div class="mb-4">
                <label for="employeeName" class="block">Employee</label>
                <select id="employeeName" name="employeeName" class="border border-gray-300 rounded px-2 py-1" required>
                    <option value="" disabled selected>Select Employee</option>
                    <option value="Receptionist">Receptionist</option>
                    <option value="Photographer">Photographer</option>
                    <option value="Cleaner">Cleaner</option>
                </select>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-4 m-3 rounded">Save</button>
        </form>
    </div>
    <!-- other  -->
    
    <div id="otherExpense" class="expense-container">
        <div class="container mx-auto my-8">
            <h1 class="text-2xl font-bold mb-4">Other Expense</h1>
            <form action="expenses.php" method="post" id="otherExpenseForm" class="flex items-center">
              <div class="mr-4">
                <label for="otherExpenseName" class="block">Name</label>
                <input type="text" id="otherExpenseName" name="otherExpenseName" class="border border-gray-300 rounded px-2 py-1" required>
              </div>
              <div class="mr-4">
                  <label for="otherExpenseDate" class="block">Date</label>
                  <input type="date"  name="otherExpenseDate" id="otherExpenseDate" class="border border-gray-300 rounded px-2 py-1" required>
              </div>
                <div class="mr-4">
                    <label for="otherExpenseAmount" class="block">Amount</label>
                    <input type="number" name="otherExpenseAmount" id="otherExpenseAmount" class="border border-gray-300 rounded px-2 py-1" required>
                </div>
                <button type="submit" class="bg-red-600 hover:bg-gray-900 hover:text-white text-white px-4 py-2 rounded">Save</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function showExpense(expenseId) {
            // Hide all expense containers
            const expenseContainers = document.querySelectorAll(".expense-container");
            expenseContainers.forEach((container) => {
                container.classList.remove("active");
            });

            // Show selected expense container
            const selectedExpense = document.getElementById(expenseId);
            if (selectedExpense) {
                selectedExpense.classList.add("active");
            }
        }
    </script>
  </body>
</html>


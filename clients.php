<?php
// database connection 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "redcam";

    $conn = new mysqli($servername, $username, $password, $database);

    //checks the connection..
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    //Variable value assignment
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $invoiceDate = $_POST["invoice_date"];
    $package_name = isset($_POST["package_name"]) ? $_POST["package_name"] : "";
    $Quantity = $_POST["Quantity"];

    $sql = "INSERT INTO clients (name, email, phone, invoice_date, package_name,quantity) VALUES ('$name', '$email', '$phone', '$invoiceDate', '$package_name','$Quantity')";

    //checks result of insertion
    if ($conn->query($sql) === true) {
        // Successful insertion
        header("Location: clientsdata.php"); // Redirect to clientdata.php after successful insertion
        exit;
    } else {
        // Query failed
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<html>
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
      background-image: url("background/clients.jpg");
    }
  </style>
<body class="bg-custom bg-cover h-screen ">
<div
        class="container mx-auto flex justify-between items-center mt-4 bg-gray-900 p-3"
>
<a href="main.html">
    <img src="logo.png" alt="Logo" class="w-25 h-10"/>
    </a>
    <h1 class="text-2xl text-white justify-center font-bold">
        Client Information
    </h1>
    <a href="main.html" class="text-white hover:text-gray-200">Back </a>
</div>

<div class="container mx-auto py-10">
  <ul class="text-white hover:text-white font-semibold bg-red-600 hover:bg-gray-900 p-4 rounded w-max">
    <li>
      <a href="clientsdata.php">All Clients Data </a>
    </li>
  </ul>
    <div>
        <form method="post" class="max-w-md mx-auto" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="name"
                >Name</label
                >
                <input
                        class="shadow appearance-none border rounded w-3/4 py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="name"
                        type="text"
                        placeholder="Enter your name"
                        name="name"
                />
            </div>

            <div class="mb-4">
                <label
                        class="block text-white text-sm font-bold mb-2 "
                        for="email"
                >Email</label
                >
                <input
                        class="shadow appearance-none border rounded py-2 px-3 w-3/4  leading-tight focus:outline-none focus:shadow-outline"
                        id="email"
                        type="email"
                        placeholder="Enter your email"
                        name="email"
                />
            </div>

            <div class="mb-4">
                <label
                        class="block text-white text-sm font-bold mb-2"
                        for="phone"
                >Phone</label
                >
                <input
                        class="shadow appearance-none border rounded w-3/4 py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
                        id="phone"
                        type="text"
                        placeholder="Enter your phone number"
                        name="phone"
                />
            </div>

            <div class="mb-4">
                <label
                        class="block text-white text-sm font-bold mb-2"
                        for="invoice_date"
                >Invoice Date</label
                >
                <input
                        class="shadow appearance-none border rounded w-3/4 py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
                        id="invoice_date"
                        type="date"
                        name="invoice_date"
                />
            </div>
            <label
                        class="block text-white text-sm font-bold mb-2"
                        for="invoice_date"
                >package_name</label
                >
            <div class="relative my-4">
              <select
                class="shadow appearance-none border rounded w-3/4 py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
                id="package"
                name="package_name"
              >
                <option value="" disabled selected>Select a package</option>
                <option value="Passport size Photos">
                  Passport size Photos
                </option>
                <option value="4 x 6 inches Photo with print">
                  4 x 6 inches Photo with print
                </option>
                <option value="5 x 7 inches Photo with print">
                  5 x 7 inches Photo with print
                </option>
                <option value="A4 8 x 10 inches Photo with print">
                  A4 8 x 10 inches Photo with print
                </option>
                <option value="Photo without print">Photo without print</option>
                <option value="Passport size Photos Print only">
                  Passport size Photos Print only
                </option>
                <option value="4 x 6 inches Photo Print (1200 x 1800) pixels">
                  4 x 6 inches Photo Print (1200 x 1800) pixels
                </option>
                <option value="5 x 7 inches Photo Print (1500 x 2100) pixels">
                  5 x 7 inches Photo Print (1500 x 2100) pixels
                </option>
                <option
                  value="A4 8 x 10 inches Photo Print (2400 x 3000) pixels"
                >
                  A4 8 x 10 inches Photo Print (2400 x 3000) pixels
                </option>
                <option value="A3 Photo Print (4961 x 3508) pixels">
                  A3 Photo Print (4961 x 3508) pixels
                </option>
                <option value="A2 Photo print">A2 Photo print</option>
                <option value="5 x 7 inches Photo Frame">
                  5 x 7 inches Photo Frame
                </option>
                <option value="A4 size glossy Photo Frame">
                  A4 size glossy Photo Frame
                </option>
                <option value="A3 size Photo Frame">A3 size Photo Frame</option>
                <option value="A2 size Photo Frame">A2 size Photo Frame</option>
                <option value="Modeling Portfolio Indoor 20 Pictures">
                  Modeling Portfolio Indoor 20 Pictures
                </option>
                <option value="Modeling Portfolio Outdoor 20 Pictures">
                  Modeling Portfolio Outdoor 20 Pictures
                </option>
                <option value="Modeling Portfolio Indoor + Outdoor 25 Pictures">
                  Modeling Portfolio Indoor + Outdoor 25 Pictures
                </option>
                <option value="Product Photoshoot">Product Photoshoot</option>
                <option value="Pet Photoshoot Outdoor">
                  Pet Photoshoot Outdoor
                </option>
                <option value="Couple Photoshoot Outdoor">
                  Couple Photoshoot Outdoor
                </option>
                <option value="Birthday Party Photoshoot">
                  Birthday Party Photoshoot
                </option>
                <option value="Kids Photography indoor / Outdoor">
                  Kids Photography indoor / Outdoor
                </option>
                <option value="Food Photography">Food Photography</option>
                <option value="Textile Photos per dress">
                  Textile Photos per dress
                </option>
                <option value="Cinematic Portrait Video (30-50 Seconds)">
                  Cinematic Portrait Video (30-50 Seconds)
                </option>
                <option
                  value="Instagram / TikTok Reels / Shorts (30-50 Seconds)"
                >
                  Instagram / TikTok Reels / Shorts (30-50 Seconds)
                </option>
                <option
                  value="Outdoor pre-wedding Shoot – (02:00 – 2:30 Seconds)"
                >
                  Outdoor pre-wedding Shoot – (02:00 – 2:30 Seconds)
                </option>
                <option value="2-3 Locations with different dresses">
                  2-3 Locations with different dresses
                </option>
                <option
                  value="Digital Graphics Videos / Ads (10:00 – 15:00 Seconds)"
                >
                  Digital Graphics Videos / Ads (10:00 – 15:00 Seconds)
                </option>
                <option
                  value="Commercial/Cooperative Video (02– 02:50 Seconds)"
                >
                  Commercial/Cooperative Video (02– 02:50 Seconds)
                </option>
                <option value="Event Shoot (03:00 – 05:00 Hours) Highlight">
                  Event Shoot (03:00 – 05:00 Hours) Highlight
                </option>
                <option value="Event Shoot (03:00 – 05:00 Hours) Master">
                  Event Shoot (03:00 – 05:00 Hours) Master
                </option>
                <option value="Song Shoot (Per Day)">
                  Song Shoot (Per Day)
                </option>
                <option value="TVC Project (10:00 - 15:00 Sec)">
                  TVC Project (10:00 - 15:00 Sec)
                </option>
                <option
                  value="School / Short films Projects (05:00 – 10:00 Minutes)"
                >
                  School / Short films Projects (05:00 – 10:00 Minutes)
                </option>
                <option value="Cooperative Video (02:00 – 02:50 Seconds)">
                  Cooperative Video (02:00 – 02:50 Seconds)
                </option>
                <option value="Birthday/Family Function (Per event)">
                  Birthday/Family Function (Per event)
                </option>
                <option value="Product Video Shoot (30:00 – 45:00 Seconds)">
                  Product Video Shoot (30:00 – 45:00 Seconds)
                </option>
                <option value="Textile Video/reel per dress">
                  Textile Video/reel per dress
                </option>
              </select>
              <div class="mb-4">
                <label
                        class="block text-white text-sm font-bold mb-2"
                        for="phone"
                >Quantity</label
                >
                <input
                        class="shadow appearance-none border rounded w-3/4 py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
                        id="Quantity"
                        type="number"
                        placeholder="Enter Quantity"
                        name="Quantity"
                />
            </div>
            </div>

            <div class="flex items-center justify-between">
                <button
                        class="bg-red-600 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

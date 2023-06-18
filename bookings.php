<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customerName'];
    $customerEmail = $_POST['customerEmail'];
    $bookingDate = $_POST['bookingDate'];
    $packageName = $_POST['package'];

    //  database connection  details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "redcam";

    $conn = new mysqli($servername, $username, $password, $database);
    // Check the connection is valid or not
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //  query to insert the form data into the database
    $sql = "INSERT INTO bookings (customer_name, customer_email, booking_date, package_name) VALUES ('$customerName', '$customerEmail', '$bookingDate', '$packageName')";
    //checks sql query 
    if ($conn->query($sql) === TRUE) {
        header("Location: bookingsdata.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
    />
    <style>
    .bg-custom {
      background-image: url("background/booking2.jpg");
    }
  </style>
  </head>
  <body class="bg-custom bg-cover h-screen ">
    <div class="mx-auto flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white mb-4">Booking</h1>
    <a href="main.html" class="text-white hover:text-gray-900 text-xl">Back </a>
    </div>
    <ul class="text-white hover:text-white font-semibold bg-red-600 hover:bg-gray-900 p-4 rounded w-max">
    <li>
      <a href="bookingsdata.php">All Bookings Data </a>
    </li>
  </ul>
    <form id="bookingForm" class="max-w-md mx-auto" method="POST" action="">
      <div class="mb-4">
        <label for="customerName" class="block mb-1 text-white">Customer Name:</label>
        <input
          type="text"
          id="customerName"
          name="customerName"
          required
          class="w-full px-4 py-2 rounded bg-gray-100 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600"
        />
      </div>

      <div class="mb-4">
        <label for="customerEmail" class="block mb-1 text-white">Customer Email:</label>
        <input
          type="email"
          id="customerEmail"
          name="customerEmail"
          required
          class="w-full px-4 py-2 rounded bg-gray-100 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600"
        />
      </div>

      <div class="mb-4">
        <label for="bookingDate" class="block mb-1 text-white">Booking Date:</label>
        <input
          type="date"
          id="bookingDate"
          name="bookingDate"
          required
          class="w-full px-4 py-2 rounded bg-gray-100 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600"
        />
      </div>

      <div class="mb-4">
        <label for="package" class="block mb-1 text-white">Package:</label>
        <select
          id="package"
          name="package"
          required
          class="w-full px-4 py-2 rounded bg-gray-100 text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600"
        >
          <option value="" disabled selected>Select a package</option>
          <option value="Passport size Photos">Passport size Photos</option>
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
          <option value="A4 8 x 10 inches Photo Print (2400 x 3000) pixels">
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
          <option value="Pet Photoshoot Outdoor">Pet Photoshoot Outdoor</option>
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
          <option value="Instagram / TikTok Reels / Shorts (30-50 Seconds)">
            Instagram / TikTok Reels / Shorts (30-50 Seconds)
          </option>
          <option value="Outdoor pre-wedding Shoot – (02:00 – 2:30 Seconds)">
            Outdoor pre-wedding Shoot – (02:00 – 2:30 Seconds)
          </option>
          <option value="2-3 Locations with different dresses">
            2-3 Locations with different dresses
          </option>
          <option value="Digital Graphics Videos / Ads (10:00 – 15:00 Seconds)">
            Digital Graphics Videos / Ads (10:00 – 15:00 Seconds)
          </option>
          <option value="Commercial/Cooperative Video (02– 02:50 Seconds)">
            Commercial/Cooperative Video (02– 02:50 Seconds)
          </option>
          <option value="Event Shoot (03:00 – 05:00 Hours) Highlight">
            Event Shoot (03:00 – 05:00 Hours) Highlight
          </option>
          <option value="Event Shoot (03:00 – 05:00 Hours) Master">
            Event Shoot (03:00 – 05:00 Hours) Master
          </option>
          <option value="Song Shoot (Per Day)">Song Shoot (Per Day)</option>
          <option value="TVC Project (10:00 - 15:00 Sec)">
            TVC Project (10:00 - 15:00 Sec)
          </option>
          <option value="School / Short films Projects (05:00 – 10:00 Minutes)">
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
          <!-- Dynamically populate package options using JavaScript or server-side code -->
        </select>
      </div>


      <button
        type="submit"
        class="px-4 py-2 bg-red-600 hover:bg-gray-900 rounded text-white"
      >
        Book Now
      </button>
    </form>
  </body>
</html>

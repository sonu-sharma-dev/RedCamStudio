# RedCamStudio
RedCamStudio is a web-based application built to assist studio owners in managing expenses, bookings, clients, and generating invoices. This README file provides an overview of the application's features, technologies used, and installation instructions.

## Features
> RedCamStudio offers the following features:

* Expense Management: Easily track and manage studio expenses, including rent, utilities, equipment maintenance, and other overhead costs.

* Booking Management: Keep track of studio bookings, including date, time, client details, and studio availability. You can view, create, edit, and cancel bookings as needed.

* Client Management: Manage client information, including contact details, project requirements, and payment history. Add new clients, update existing client information, and maintain a comprehensive client database.

* Invoice Generation: Generate professional invoices for your clients directly from the application. Customize invoice templates, add billable items, and keep track of payments received.

## Technologies Used
RedCamStudio is developed using the following technologies:

* HTML: The application's user interface is built using HTML, providing the structure and layout for the web pages.

* CSS: Cascading Style Sheets (CSS) are used to enhance the visual appearance of the application. Tailwind CSS framework is employed to simplify styling and improve responsiveness.

* JavaScript: The application utilizes JavaScript to add interactivity and dynamic functionality, enhancing the user experience.

* MySQL: The MySQL database is used to store and manage data related to bookings, expenses, clients, and invoices.

* XAMPP: XAMPP is a popular software package used for local development environments. It provides Apache (web server), MySQL (database), and PHP (server-side scripting language) components required to run the application on your local machine.

## Installation
To set up RedCamStudio on your local machine, follow these steps:

> Ensure you have XAMPP installed. If not, download and install XAMPP from the official website: https://www.apachefriends.org/index.html.

> Clone the RedCamStudio repository from GitHub using the following command:

``` git clone https://github.com/sonu-sharma-dev/RedCamStudio ```
> Move the cloned repository into the XAMPP web server directory. On Windows, the default path is C:\xampp\htdocs\. On macOS, it is /Applications/XAMPP/xamppfiles/htdocs/.

> Start XAMPP and ensure both the Apache and MySQL services are running.

> Open a web browser and navigate to ```http://localhost/RedCamStudio/```. This will launch the RedCamStudio application.

> You will be prompted to set up the MySQL database. Follow the on-screen instructions to create the necessary database tables and establish a connection.

> Once the database setup is complete, you can start using RedCamStudio by signing in as the owner of the studio.

## Configuration
To configure RedCamStudio for your specific environment or preferences, you may need to modify certain files:

* Database Configuration: If you have a different MySQL database setup, open the config.php file in the project's root directory and update the database connection details accordingly.

* Invoice Template: Customize the invoice template by modifying the HTML and CSS files located in the invoice_template directory. Tailwind CSS classes can be used to style the invoice according to your branding.

## Contributing
> Thank you for considering contributing to RedCamStudio! If you have any suggestions, bug reports, or feature requests, please submit them as issues on the project's GitHub repository: ```https://github.com/sonu-sharma-dev/RedCamStudio/issues```

> If you would like to contribute code changes, you can submit a pull request on GitHub. Your contributions are greatly appreciated!

## License
RedCamStudio is open-source software released under the MIT License. See the LICENSE file for more information.

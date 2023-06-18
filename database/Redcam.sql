CREATE DATABASE Redcam;
USE Redcam;

select * from clients;


CREATE TABLE clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255),
  phone VARCHAR(255),
  invoice_date DATE ,
  package_name VARCHAR(255),
  quantity INT,
  package_id INT
);

CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  description VARCHAR(255),
  quantity INT,
  price DECIMAL(10, 2)
);
INSERT INTO packages (description, quantity, price) VALUES
    ('Passport size Photos', 4, 600),
    ('Passport size Photos', 8, 900),
    ('4 x 6 inches Photo with print', 1, 400),
    ('5 x 7 inches Photo with print', 1, 500),
    ('A4 8 x 10 inches Photo with print', 1, 600),
    ('Photo without print', 1, 300),
    ('Passport size Photos Print only', 4, 300),
    ('Passport size Photos Print only', 8, 400),
    ('4 x 6 inches Photo Print (1200 x 1800) pixels', 1, 100),
    ('5 x 7 inches Photo Print (1500 x 2100) pixels', 1, 250),
    ('A4 8 x 10 inches Photo Print (2400 x 3000) pixels', 1, 300),
    ('A3 Photo Print (4961 x 3508) pixels', 1, 1200),
    ('A2 Photo print', 1, 1500),
    ('5 x 7 inches Photo Frame', 1, 1000),
    ('A4 size glossy Photo Frame', 1, 1500),
    ('A3 size Photo Frame', 1, 2500),
    ('A2 size Photo Frame', 1, 4500),
    ('Cinematic Portrait Video (30-50 Seconds)', 1, 5000),
    ('Instagram / TikTok Reels / Shorts (30-50 Seconds)', 1, 5000),
    ('Outdoor pre-wedding Shoot – (02:00 – 2:30 Seconds) 2-3 Locations with different dresses', 1, 40000),
    ('Digital Graphics Videos / Ads (10:00 – 15:00 Seconds)', 1, 10000),
    ('Commercial/Cooperative Video (02– 02:50 Seconds)', 1, 15000),
    ('Event Shoot (03:00 – 05:00 Hours) Highlight', 1, 10000),
    ('Event Shoot (03:00 – 05:00 Hours) Master', 1, 15000),
    ('Song Shoot (Per Day)', 1, 20000),
    ('TVC Project (10:00 - 15:00 Sec)', 1, 35000),
    ('School / Short films Projects (05:00 – 10:00 Minutes)', 1, 25000),
    ('Cooperative Video (02:00 – 02:50 Seconds)', 1, 20000),
    ('Birthday/Family Function (Per event)', 1, 10000),
    ('Product Video Shoot (30:00 – 45:00 Seconds)', 1, 5000),
    ('Textile Video/reel per dress', 1, 7000);

select * from packages;

CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255),
  phone VARCHAR(255),
  invoice_date DATE,
  package_description VARCHAR(255),
  quantity INT,
  price int,
  total_amount int
);


DELIMITER $$
CREATE TRIGGER generate_invoice AFTER INSERT ON clients
FOR EACH ROW
BEGIN
   DECLARE packageDesc VARCHAR(255);
   DECLARE packagePrice DECIMAL(10, 2);
   DECLARE packageQuantity INT;
   DECLARE totalAmount DECIMAL(10, 2);
   
   SELECT p.description, p.price, NEW.quantity INTO packageDesc, packagePrice, packageQuantity
   FROM packages AS p
   WHERE p.description = NEW.package_name;
   
   SET totalAmount = CASE
        WHEN packageQuantity < 10 THEN packagePrice * packageQuantity
        ELSE (packagePrice  * packageQuantity)- 200
    END;
   
   INSERT INTO invoices (name, email, phone, invoice_date, package_description, quantity, price, total_amount)
   VALUES (NEW.name, NEW.email, NEW.phone, NEW.invoice_date, packageDesc, packageQuantity, packagePrice, totalAmount);
END $$
DELIMITER ;




CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(255),
  customer_email VARCHAR(255),
  booking_date DATE,
  package_name text
);


CREATE TABLE tea_expenses (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  month VARCHAR(20),
  quantity INT(11) NOT NULL,
  total_price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE monthly_expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
   expense_name VARCHAR(255),
   expense_date DATE,
   expense_amount DECIMAL(10, 2)
);


select * from monthly_expenses;

CREATE TABLE employee_salaries(
  salary_id INT AUTO_INCREMENT PRIMARY KEY,
  salary_date DATE,
  salary_amount DECIMAL(10, 2),
  employee_name VARCHAR(50)
);
CREATE TABLE other_expenses(
  id INT AUTO_INCREMENT PRIMARY KEY,
  expense_name varchar(50),
  expense_date Date,
  expense_amount VARCHAR(50)
);
select * from other_expenses;

DELIMITER $$
CREATE TRIGGER insert_monthly_expense
AFTER INSERT ON other_expenses
FOR EACH ROW
BEGIN
  INSERT INTO monthly_expenses (expense_name, expense_date, expense_amount)
  VALUES (NEW.expense_name, NEW.expense_date, NEW.expense_amount);
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER insert_monthly_expense
AFTER INSERT ON tea_expenses
FOR EACH ROW
BEGIN
    DECLARE existingRecordCount INT;

    SELECT COUNT(*) INTO existingRecordCount
    FROM monthly_expenses
    WHERE expense_name = 'Tea Expense' AND MONTH(expense_date) = MONTH(NEW.date) AND YEAR(expense_date) = YEAR(NEW.date);
    
    IF existingRecordCount > 0 THEN
        UPDATE monthly_expenses
        SET expense_amount = (
            SELECT SUM(total_price)
            FROM tea_expenses
            WHERE MONTH(date) = MONTH(NEW.date) AND YEAR(date) = YEAR(NEW.date)
        )
        WHERE expense_name = 'Tea Expense' AND MONTH(expense_date) = MONTH(NEW.date) AND YEAR(expense_date) = YEAR(NEW.date);
    ELSE
        INSERT INTO monthly_expenses (expense_name, expense_date, expense_amount)
        VALUES ('Tea Expense', NEW.date, (
            SELECT SUM(total_price)
            FROM tea_expenses
            WHERE MONTH(date) = MONTH(NEW.date) AND YEAR(date) = YEAR(NEW.date)
        ));
    END IF;
END$$
DELIMITER ;












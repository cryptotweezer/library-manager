-- Create database
CREATE DATABASE IF NOT EXISTS library_manager;
USE library_manager;

-- Drop tables if they already exist (optional clean start)
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

-- Create 'categories' table
CREATE TABLE categories (
    categoryID INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(255) NOT NULL
);

-- Create 'products' table
CREATE TABLE products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    categoryID INT NOT NULL,
    productCode VARCHAR(50),
    productName VARCHAR(255),
    listPrice DECIMAL(10,2),
    FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
);

-- Insert sample categories
INSERT INTO categories (categoryName) VALUES 
('Fiction'),
('Science'),
('History'),
('Children');

-- Insert sample books into each category
INSERT INTO products (categoryID, productCode, productName, listPrice) VALUES
-- Fiction
(1, 'F001', 'The Great Gatsby', 15.99),
(1, 'F002', '1984', 12.49),
(1, 'F003', 'To Kill a Mockingbird', 13.50),
(1, 'F004', 'Pride and Prejudice', 11.99),

-- Science
(2, 'S001', 'A Brief History of Time', 18.99),
(2, 'S002', 'The Selfish Gene', 16.49),
(2, 'S003', 'Cosmos', 17.00),
(2, 'S004', 'The Origin of Species', 19.95),

-- History
(3, 'H001', 'Sapiens', 22.99),
(3, 'H002', 'Guns, Germs, and Steel', 20.50),
(3, 'H003', 'The Silk Roads', 18.00),
(3, 'H004', 'Team of Rivals', 21.75),

-- Children
(4, 'C001', 'Harry Potter and the Sorcerer\'s Stone', 10.99),
(4, 'C002', 'Charlotte\'s Web', 8.99),
(4, 'C003', 'The Cat in the Hat', 6.99),
(4, 'C004', 'Matilda', 9.50);

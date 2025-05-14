# 📚 Library Manager Web App

**Student Name:** Andres Henao  
**Student ID:** s8103043  
**Student Name:** Akshay Patel
**Student ID:** s8113302
**Course:** NIT1204 Web Application and Server Management  
**Project:** PHP Book Manager

---

## 📦 About the Project

This PHP web application allows users to manage a list of books by category.  
Users can:

- View books by category
- Add new books
- Modify existing books
- Delete books
- Sort books in ascending or descending order
- View all books at once

It uses **basic PHP with MySQL (XAMPP)**,

---

## 🛠 Installation Instructions

1. Download and install [XAMPP](https://www.apachefriends.org/).
2. Place the project folder inside:

   ```
   C:\xampp\htdocs\library_manager\
   ```

3. Start **Apache** and **MySQL** via the XAMPP Control Panel.
4. Open [phpMyAdmin](http://localhost/phpmyadmin) in your browser.
5. Run the SQL script `init_library_manager.sql` to create the database and insert sample data.
6. Visit the app in your browser:

   ```
   http://localhost/library_manager/index.php
   ```

---

## 👨‍💻 Usage

- Navigate the sidebar to view books by category.
- Use the “Add Book” form to insert a new book.
- Use the “Modify” and “Delete” buttons to update or remove books.
- Sort books alphabetically using the sorting links.

---

## 📁 Source Code Structure

```
index.php               → Main controller file
model/
  └── database.php       → Database connection
  └── category_db.php    → Category functions
  └── product_db.php     → Product functions
view/
  └── header.php         → Page header
  └── footer.php         → Page footer
  └── product_list.php   → Book list view
  └── product_add.php    → Add book form
  └── product_modify.php → Modify book form
style.css               → Basic layout styling
```

---

## 🧪 Test Cases

- ✅ **Add Book**
  - Valid input → book appears in list.
  - Empty input → shows validation warning.
- ✅ **Delete Book**
  - Deletes correctly from list.
- ✅ **Modify Book**
  - Updates name and price.
- ✅ **Sort Books**
  - Ascending/Descending works.
- ✅ **View All**
  - Clicking "Book List" shows all books.
- ✅ **Validation**
  - `required` fields used in form.
  - Price validated as a float.
- ✅ **Error Handling**
  - DB error shows user-friendly message.

---

## 📚 Acknowledgements



**End of README**

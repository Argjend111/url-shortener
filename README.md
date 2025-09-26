URL Shortener

This project is a simple URL shortener where you can paste a long link, choose an expiration time if you want, and get back a short link that can also be opened through a QR code.

To make it work you first need to install XAMPP on your computer and make sure that both Apache and MySQL are running. Once XAMPP is ready, open phpMyAdmin from your browser and create a database called url_shortener. Inside the project there is a file called database.sql in the sql folder which contains all the tables needed for the application, so you just import that file into the database you created.

After the database is ready you place the project folder url-shortener inside the htdocs directory of XAMPP, which is usually located in C:\xampp\htdocs.

When everything is in place you open your browser and go to http://localhost/url-shortener. The application will load and you will see the main page where you can paste a URL, select how long it should stay active or just leave it empty if you don’t want an expiration, and then generate a short link. Each short link can also be displayed as a QR code so you can scan it directly from your phone. The system also keeps track of how many times each short link has been opened.

Argjend Bytyci - AnchorzUp
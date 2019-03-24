Web server: XAMPP.
1. Configure the $mysqli connection variable in index.php and process.php.
2. Start Apache and MySQL.
3. Create a new DB and name it phpTest.
4. Create a new table:
```
      CREATE TABLE data (
        id int NOT NULL AUTO_INCREMENT,
        name varchar(50),
        address varchar(50),
      	email varchar(50),
      	phone varchar(50),
        PRIMARY KEY (id)
       );
```
5. Navigate to localhost -> phpcrud in the web browser.

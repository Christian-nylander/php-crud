<?php
  session_start();
  //Connection to DB
  $mysqli = new mysqli('localhost', 'root', '', 'phpTest') or die(mysqli_error($mysqli));

  $id = 0;
  $update=false;
  $name='';
  $address='';
  $email='';
  $phone='';

 // Checks if save button has been clicked, validates data and inserts into DB
 if(isset($_POST['save'])){
  $name = $_POST['name'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $duplicateEmail=mysqli_query($mysqli,"select * from data where email='$email'");
  $duplicatePhone=mysqli_query($mysqli,"select * from data where phone='$phone'");

  if(empty($name) || empty($address)  || empty($email)  || empty($phone) ) {
    $_SESSION['message'] = "All fields need to be filled";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
  }
  else if(mysqli_num_rows($duplicateEmail)>0) {
    $_SESSION['message'] = "Email " . $email . " is already registered";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
  }
  else if(mysqli_num_rows($duplicatePhone)>0) {
    $_SESSION['message'] = "Phone number " . $phone . " is already registered";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
  }
  else {
    $mysqli->query("INSERT INTO data (name, address, email, phone) VALUES('$name', '$address', '$email', '$phone')") or
    die($mysqli->error);

    $_SESSION['message'] = "User has been added to the list";
    $_SESSION['msg_type'] = "success";
    header("location: index.php");
  }
 }

 // Checks if delete button is clicked and deletes from DB.
 if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());

   $_SESSION['message'] = "User has been deleted from the list";
   $_SESSION['msg_type'] = "danger";
   header("location: index.php");
 }

  // Checks if edit button has been cliocked and select the ID
  if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;

    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if(@count($result)==1) {
      $row = $result->fetch_array();
      $name = $row['name'];
      $address = $row['address'];
      $email = $row['email'];
      $phone = $row['phone'];
    }
 }

  // Checks if update button has been clicked, validates data and updates
  if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $duplicateEmail=mysqli_query($mysqli,"select * from data where email='$email' AND id!='$id'");
    $duplicatePhone=mysqli_query($mysqli,"select * from data where phone='$phone' AND id!='$id'");

    if(mysqli_num_rows($duplicateEmail)>0) {
      $_SESSION['message'] = "Someone is already using email: " . $email;
      $_SESSION['msg_type'] = "warning";
      header("location: index.php");
    }
    else if(mysqli_num_rows($duplicatePhone)>0) {
      $_SESSION['message'] = "Someone is already using phone: " . $phone;
      $_SESSION['msg_type'] = "warning";
      header("location: index.php");
    }
    else {
      $mysqli->query("UPDATE data SET name='$name', address='$address', email='$email', phone='$phone' WHERE id=$id") or die($mysql->error);
      $_SESSION['message'] = "User has been successfully updated!";
      $_SESSION['msg_type'] = "warning";
      header("location: index.php");
  }
 }

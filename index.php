<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php require_once 'process.php'; ?>

    <?php
      //Limiting length of output in list view
      function custom_echo($x, $length) {
        if(strlen($x)<=$length) {
          echo $x;
        } else {
          $y=substr($x,0,$length) . '...';
          echo $y;
        }
       }
     ?>

    <?php if(isset($_SESSION['message'])): ?>
      <div class="alert alert-<?=$_SESSION['msg_type']?>">
    <?php
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    ?>
    </div>
    <?php endif ?>

    <div class="parent-container">
      <div class="input-container">
        <form class="" action="process.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="form-group">
              <label>Name</label>
              <input class="form-control" type="text" name="name" value="<?php echo $name?>" placeholder="Enter your name">
            </div>
            <div class="form-group">
              <label>Address</label>
              <input class="form-control" type="text" name="address" value="<?php echo $address ?>" placeholder="Enter your address">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input class="form-control" type="email" name="email" value="<?php echo $email ?>" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input class="form-control" type="number" name="phone" value="<?php echo $phone ?>" placeholder="Enter your phone">
            </div>
            <div class="form-group">
              <?php
              if($update === true):
              ?>
              <button class="btn btn-info" type="submit" name="update">Update</button>
              <?php else: ?>
              <button class="btn btn-primary" type="submit" name="save">Save</button>
              <?php endif; ?>
            </div>
        </form>
      </div>
      <div class="row-container">
        <?php
        //Connect to DB and populate $result.
        $mysqli = new mysqli('localhost', 'root', '', 'phpTest') or die(mysqli_error($mysqli));
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        ?>
        <div class="list-container">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th colspan="2">Action</th>
              </tr>
            </thead>
            <?php
            while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="td-text"><?php custom_echo($row['name'], 16); ?></td>
              <td class="td-text"><?php custom_echo($row['address'], 20); ?></td>
              <td class="td-text"><?php custom_echo($row['email'], 20); ?></td>
              <td class="td-text"><?php custom_echo($row['phone'], 16); ?></td>
              <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>

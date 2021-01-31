<?php 
  include('config/constants.php');

  // get the current values of selected list from DB
  if(isset($_GET['list_id'])) {

    // get the list id value
    $list_id = $_GET['list_id'];

    // connect the DB
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

    // select the DB
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

    // query
    $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

    // execute query
    $res = mysqli_query($conn, $sql);

    // check if the query executed successfuly
    if($res == true) {
      //get the value from DB
      $row = mysqli_fetch_assoc($res); // value is in array

      // create inidivdual variable to save the data
      $list_name = $row['list_name'];
      $list_description = $row['list_description'];

    } else {
      //go to manage-list.php 
      header('location:' . SITEURL . 'manage-list.php');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
</head>
<body>

<div class="wrapper"> <!-- wrapper starts here -->

    <h1>Task Manager</h1>

    <div class="menu">
      <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
      <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
    </div>

    <h3>Update List Page</h3>

    <p>
      <?php 
        //check if the session is set
        if(isset($_SESSION['update_fail'])) {
          echo $_SESSION['update_fail'];
          unset($_SESSION['update_fail']);
        }
      ?>
    </p>

    <!-- form to update list starts here -->

    <form method="POST" action="">
      <table class="tbl-half">

        <tr>
          <td>List Name: </td>
          <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required></td>
        </tr>

        <tr>
          <td>List Description</td>
          <td><textarea name="list_description" id="" cols="30" rows="10"><?php echo $list_description; ?></textarea></td>
        </tr>

        <tr>
          <td><input class="btn-lg btn-primary" type="submit" name="submit" value="Update"></td>
        </tr>

      </table>
    </form>

    <!-- form to update list ends here -->
  </div> <!-- wrapper ends here -->  
</body>
</html>


<?php 
  // check if the update button is clicked
  if(isset($_POST['submit'])) {

    // get the updated values from our form
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];

    // connect DB, this time we need conn2 because there is already $conn variable
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

    // select the DB
    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

    // query using $list_id from top
    $sql2 = "UPDATE tbl_lists SET 
    list_name = '$list_name',
    list_description = '$list_description'
    WHERE list_id =$list_id 
    ";

    // execute query
    $res2 = mysqli_query($conn2, $sql2);

    // check if the query executed successfully 
    if($res2 == true) {
      // update successful
      // set the message
      $_SESSION['update'] = "List updated successfuly";

      // redirect 
      header('location:' . SITEURL . 'manage-list.php');


    } else {
      // failed to update
      // set the message
      $_SESSION['update_failed'] = "Failed to update";
      header('location:' . SITEURL . 'update-list.php?list_id=' . $list_id);

    }
  }

?>
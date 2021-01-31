<?php 
  include('config/constants.php');

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

    <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>

    <h3>Add List Page</h3>

    <p>
      <?php 
        // check if the session is created
        if(isset($_SESSION['add_fail'])) {
          // display session message
          echo $_SESSION['add_fail'];
          // we need to remove the message or it will be displayin the message forever, so we need to unset it
          unset($_SESSION['add_fail']);
        }
      ?>
    </p>

    <!-- form to add list starts here -->

    <form method="POST" action="">
      <table class="tbl-half">

        <tr>
          <td>List Name: </td>
          <td><input type="text" name="list_name" placeholder="Write list name here" required></td>
        </tr>

        <tr>
          <td>List Description</td>
          <td><textarea name="list_description" id="" cols="30" rows="10" placeholder="Write list desc here"></textarea></td>
        </tr>

        <tr>
          <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Save"></td>
        </tr>

      </table>
    </form>

    <!-- form to add list ends here -->
  </div > <!-- wrapper ends here -->  
</body>
</html>



<?php 

  // check if the form is submitted or not
  if(isset($_POST['submit'])) {
    
    // get data from form and save it in variables
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];

    // connect the database
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    
    /*
    // check if the connection was successful
    if($conn = true) {
      echo "DB connected";
    }
    */

    // select DB
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

    /*
    // db check
    if($db_select = true) {
      echo "db selected";
    }
    */

    // sql query to insert into DB
    $sql = "INSERT INTO tbl_lists SET
      list_name = '$list_name',
      list_description = '$list_description'
    ";

    // execute query and insert into DB
    $res = mysqli_query($conn, $sql);

    // check if the query executed successfuly
    if($res = true) {
      // data inserted successfuly
      //echo "data inserted";

      // create a session variable to display message. Need to be set before redirecting otherwise will not be set
      $_SESSION['add'] = "List added successfuly";

      // redirect to manage list page
      header('location:' . SITEURL . 'manage-list.php');

    } else {
      // failed to insert
      //echo "failed to insert data";

      // create a session variable to message. Need to be set before redirecting otherwise will not be set
      $_SESSION['add_failed'] = "List NOT added successfuly";

      // redirect to same page
      header('location:' . SITEURL . 'add-list.php');
    }
    

  }
  
?>
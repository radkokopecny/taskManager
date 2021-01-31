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

    <h3>Add Task Page</h3>

    <p>
      <?php 
        if(isset($_SESSION['add_fail'])) {
          echo $_SESSION['add_fail'];
          unset($_SESSION['add_fail']);
        }
      ?>
    </p>

    <!-- form to add task starts here -->

    <form method="POST" action="">
      <table class="tbl-half">

        <tr>
          <td>Task Name: </td>
          <td><input type="text" name="task_name" placeholder="Write task name here" required="required"></td>
        </tr>

        <tr>
          <td>Task Description</td>
          <td><textarea name="task_description" id="" cols="30" rows="10" placeholder="Write task desc here"></textarea></td>
        </tr>

        <tr>
          <td>Select list:</td>
          <td>
            <select name="list_id" id="">

              <?php
                // connect the database
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                // select DB
                $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                // sql query to get the list from table
                $sql = "SELECT * FROM tbl_lists";

                // execute query
                $res = mysqli_query($conn, $sql);

                // check if the query executed
                if($res == true) {
                  // create variable to count rows
                  $count_rows = mysqli_num_rows($res);

                  // if there is data in DB, display in dropdown else display none
                  if($count_rows > 0) {
                    // display dropdown from DB
                    while($row=mysqli_fetch_assoc($res)) {
                      $list_id = $row['list_id'];
                      $list_name = $row['list_name'];
                      ?>
                      <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>

                      <?php

                    }
                  } else {
                    // display None as option
                    ?>
                    <option value="0">None</option>
                    <?php
                  }
                }

              
              ?>

            </select>
          </td>
        </tr>

        <tr>
          <td>Priority</td>
          <td>
            <select name="priority" id="">
              <option value="High">High</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Deadline</td>
          <td>
            <input type="date" name="deadline">
          </td>
        </tr>
          
        <tr>
          <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Save"></td>
        </tr>

      </table>
    </form>

    <!-- form to add task ends here -->
  </div> <!-- wrapper ends here -->  
</body>
</html>

<?php 

// check if the save button is clicked
  if(isset($_POST['submit'])) {

    // get data from form and save it in variables
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    // connect the database, we need conn2 because conn was used but we can use the conn from before, this is just for show only
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

    // select DB
    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

    // sql query to insert into DB, list_id is integer we dont need to have it in ''
    $sql2 = "INSERT INTO tbl_tasks SET
      task_name = '$task_name',
      task_description = '$task_description',
      list_id = $list_id,
      priority = '$priority',
      deadline = '$deadline'
    ";

    // execute query and insert into DB
    $res2 = mysqli_query($conn2, $sql2);

    // check if the query executed successfuly
    if($res = true) {
      // task inserted successfuly
      //echo "task inserted";

      // create a session variable to display message. Need to be set before redirecting otherwise will not be set
      $_SESSION['add'] = "Task added successfuly";

      // redirect to home page
      header('location:' . SITEURL);
    }  else {
      // failed to add task
      //echo "failed to insert task";

      // create a session variable to message. Need to be set before redirecting otherwise will not be set
      $_SESSION['add_failed'] = "Task NOT added successfuly";

      // redirect to same page
      header('location:' . SITEURL . 'add-task.php');
    }

  }

?>
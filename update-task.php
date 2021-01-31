<?php 
  include('config/constants.php');

  // get the current values of selected task from DB
  if(isset($_GET['task_id'])) {

    // get the task id value
    $task_id = $_GET['task_id'];

    // connect the DB
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

    // select the DB
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

    // query
    $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

    // execute query
    $res = mysqli_query($conn, $sql);

    // check if the query executed successfuly
    if($res == true) {
      //get the value from DB
      $row = mysqli_fetch_assoc($res); // value is in array

      // create inidivdual variable to save the data
      $task_name = $row['task_name'];
      $task_description = $row['task_description'];
      $list_id = $row['list_id'];
      $priority = $row['priority'];
      $deadline = $row['deadline'];

    } else {
      //go to HP 
      header('location:' . SITEURL);
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
    </div>

    <h3>Update Task Page</h3>

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
          <td>Task Name: </td>
          <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required"></td>
        </tr>

        <tr>
          <td>Task Description</td>
          <td><textarea name="task_description" id="" cols="30" rows="10"><?php echo $task_description; ?></textarea></td>
        </tr>

        <tr>
          <td>Select List:</td>
          <td>
            <select name="list_id">

              <?php 
                // connect the DB
                $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                // select the DB
                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

                // query
                $sql2 = "SELECT * FROM tbl_lists";

                // execute query
                $res2 = mysqli_query($conn2, $sql2);

                // check if the query executed successfuly
                if($res2 == true) {
                  //get the value from DB
                  $count_rows2 = mysqli_num_rows($res2);

                  if($count_rows2 > 0) {
                    //loop
                    while($row2 = mysqli_fetch_assoc($res2)) {
                      //get individual value
                      $list_id_db = $row2['list_id'];
                      $list_name = $row2['list_name']
                      ?>
                      <option <?php if($list_id_db == $list_id) {echo "selected='selected'";} ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>
                      <?php
                    }

                  } else {
                    // no list added
                    // display None as option
                    ?>
                    <option <?php if($list_id=0) {echo "selected='selected'";} ?> value="0">None</option>
                    <?php
                  }

                } else {
                  //go to HP 
                  header('location:' . SITEURL);
                }
              ?>
              <option value="1">Doing</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Priority: </td>
          <td>
            <select name="priority" id="">
              <option <?php if($priority == "High") {echo "selected='selected'";} ?> value="High">High</option>
              <option <?php if($priority == "Medium") {echo "selected='selected'";} ?> value="Medium">Medium</option>
              <option <?php if($priority == "Low") {echo "selected='selected'";} ?> value="Low">Low</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Deadline: </td>
          <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"></td>
        </tr>

        <tr>
          <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Update"></td>
        </tr>

      </table>
    </form>

    <!-- form to update list ends here -->
  </div> <!-- wrapper ends here -->  
</body>
</html>


<?php 

    // check if the button clicked
    if(isset($_POST['submit']))
    {
        // echo "Clicked";
        
        // get the values from form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        
        // connect DB
        $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        
        // select DB
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());
        
        // sql qUery
        $sql3 = "UPDATE tbl_tasks SET 
        task_name = '$task_name',
        task_description = '$task_description',
        list_id = '$list_id',
        priority = '$priority',
        deadline = '$deadline'
        WHERE 
        task_id = $task_id
        ";
        
        // execute query
        $res3 = mysqli_query($conn3, $sql3);
        
        // check if the query executed or not
        if($res3==true)
        {
            // query executed and task updated
            $_SESSION['update'] = "Task updated.";
            
            // redirect to HP
            header('location:'.SITEURL);
        }
        else
        {
            // failed to update 
            $_SESSION['update_fail'] = "Failed to update";
            
            // redirect to this page
            header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
        }
        
        
    }

?>
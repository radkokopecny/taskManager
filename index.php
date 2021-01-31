<?php 
  include('config/constants.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task manager</title>
  <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
</head>
<body>

  <div class="wrapper">
    <h1>Task Manager</h1>

    <!-- menu starts here -->

    <div class="menu">
      <a href="<?php echo SITEURL; ?>">Home</a>
          
          <?php 
              
              // display lists from DB in our HP menu
              $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
              
              // select DB
              $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
              
              // query
              $sql2 = "SELECT * FROM tbl_lists";
              
              // execute query
              $res2 = mysqli_query($conn2, $sql2);
              
              // check if query executed or not
              if($res2==true)
              {
                  // display lists in menu
                  while($row2=mysqli_fetch_assoc($res2))
                  {
                      $list_id = $row2['list_id'];
                      $list_name = $row2['list_name'];
                      ?>
                      
                      <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
                      
                      <?php
                      
                  }
              }
              
          ?>

      <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
    </div>

    <!-- menu ends here -->

    <!-- tasks starts here -->

    <p>
      <?php 
        if(isset($_SESSION['add'])) {
          echo $_SESSION['add'];
          unset($_SESSION['add']);
        }

        if(isset($_SESSION['delete'])) {
          echo $_SESSION['delete'];
          unset($_SESSION['delete']);
        }

        if(isset($_SESSION['delete_fail'])) {
          echo $_SESSION['delete_fail'];
          unset($_SESSION['delete_fail']);
        }
      ?>
    </p>

    <div class="all-tasks">

      <a class="btn-primary" href="<?php echo SITEURL; ?>add-task.php">Add Task</a>

      <table class="tbl-full">
        <tr>
          <th>S.N.</th>
          <th>Task Name</th>
          <th>Priority</th>
          <th>Deadline</th>
          <th>Actions</th>
        </tr>

        <?php 

          // connect the DB
          $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

          // select DB
          $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

          // SQL query to display all data from DB
          $sql = "SELECT * FROM tbl_tasks";

          // execute the query
          $res = mysqli_query($conn, $sql);

          // check if the query executed successfuly
          if($res == true) {
            // echo "executed";

            // count the rows of data in DB
            $count_rows = mysqli_num_rows($res);

            // we cant use task_id from DB because when you delete some from DB, you get 1,2,4,5,8..., so create serial number variable and increment it in loop
            $sn = 1;

            // check if there are data in DB
            if($count_rows > 0) {
              // there is data in DB
              // so use while loop to loop over data in DB and get them. So while there are still data in DB, the $res variable from executing the query will be used into mysqli_fetch_assoc function to get the all data from DB and will be stored as $row
              while($row=mysqli_fetch_assoc($res)) {
                $task_id = $row['task_id'];
                $task_name = $row['task_name'];
                $task_description = $row['task_description'];
                $priority = $row['priority'];
                $deadline = $row['deadline'];
                ?>
                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $task_name; ?></td>
                    <td><?php echo $priority; ?></td>
                    <td><?php echo $deadline; ?></td>
                    <td>
                      <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>
                      <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                    </td>
                  </tr>
                <?php
              }
            } else {
              // no data in DB
              ?>

                <tr>
                  <td colspan="5">No task added yet</td>
                </tr>

              <?php
            }
          }     
        ?>

      </table>
    </div>

    <!-- tasks ends here -->

  </div>  
</body>
</html>
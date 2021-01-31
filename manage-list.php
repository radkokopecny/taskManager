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

    <h3>Manage Lists Page</h3>

    <p>
      <?php 
        // check if the session is created
        if(isset($_SESSION['add'])) {
          // display session message
          echo $_SESSION['add'];
          // we need to remove the message or it will be displayin the message forever, so we need to unset it
          unset($_SESSION['add']);
        }

        // check if the session for delete exists
        if(isset($_SESSION['delete'])) {
          // display session message
          echo $_SESSION['delete'];
          // we need to remove the message or it will be displayin the message forever, so we need to unset it
          unset($_SESSION['delete']);
        }

        // check session message for update
        if(isset($_SESSION['update'])) {
          // display session message
          echo $_SESSION['update'];
          unset($_SESSION['update']);
        }

        // check if the session for delete_fail exists
        if(isset($_SESSION['delete_fail'])) {
          // display session message
          echo $_SESSION['delete_fail'];
          // we need to remove the message or it will be displayin the message forever, so we need to unset it
          unset($_SESSION['delete_fail']);
        }
      ?>
    </p>


    <!-- table to display lists starts here -->

    <div class="all-lists">

      <a class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Add List</a>

      <table class="tbl-half">
        <tr>
          <th>S.N.</th>
          <th>List Name</th>
          <th>Actions</th>
        </tr>

        <?php 
        
          // connect the DB
          $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

          // select DB
          $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

          // SQL query to display all data from DB
          $sql = "SELECT * FROM tbl_lists";

          // execute the query
          $res = mysqli_query($conn, $sql);

          // check if the query executed successfuly
          if($res == true) {
            // echo "executed";

            // count the rows of data in DB
            $count_rows = mysqli_num_rows($res);

            // we cant use list_id from DB because when you delete some from DB, you get 1,2,4,5,8..., so create serial number variable and increment it in loop
            $sn = 1;

            // check if there are data in DB
            if($count_rows > 0) {
              // there is data in DB
              // so use while loop to loop over data in DB and get them. So while there are still data in DB, the $res variable from executing the query will be used into mysqli_fetch_assoc function to get the all data from DB and will be stored as $row
              while($row=mysqli_fetch_assoc($res)) {
                $list_id = $row['list_id'];
                $list_name = $row['list_name'];
                ?>
                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $list_name; ?></td>
                    <td>
                      <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
                      <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                    </td>
                  </tr>
                <?php
              }
            } else {
              // no data in DB
              ?>

                <tr>
                  <td colspan="3">No list added yet</td>
                </tr>

              <?php
            }
          }


        
        ?>
      
      </table>
    
    </div>

    <!-- table to display lists ends here -->

  </div> <!-- wrapper ends here -->
</body>
</html>
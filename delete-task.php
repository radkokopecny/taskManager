<?php
include('config/constants.php');


// check if the task_id is assigned to session or not
if(isset($_GET['task_id'])) {
  // delete the task from DB

  // get the task value from URL with GET method
  $task_id = $_GET['task_id'];

  // connect the DB
  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

  // select DB
  $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

  // write the query to delete task from DB
  $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";

  // execute the query
  $res = mysqli_query($conn, $sql);

  // check if the query is executed successfuly
  if($res == true) {
    // query executed successfuly = task is deleted successfuly
    $_SESSION['delete'] = "Task deleted successfuly";

    //redirect to HP
    header('Location:' . SITEURL);

  } else {
    // failed deleted the task
    $_SESSION['delete_fail'] = "Failed to delete task";

    //redirect to HP
    header('Location:' . SITEURL);
  }

} else {
  // redirect to HP
  header('Location:' . SITEURL);
}





?>
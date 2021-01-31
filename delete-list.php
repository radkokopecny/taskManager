<?php
include('config/constants.php');


// check if the list_id is assigned or not
if(isset($_GET['list_id'])) {
  // delete the list from DB

  // get the list_value from URL with GET method
  $list_id = $_GET['list_id'];

  // connect the DB
  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

  // select DB
  $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

  // write the query to delete list from DB
  $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";

  // execute the query
  $res = mysqli_query($conn, $sql);

  // check if the query is executed successfuly
  if($res == true) {
    // query executed successfuly = list is deleted successfuly
    $_SESSION['delete'] = "List deleted successfuly";

    //redirect to manage-list
    header('Location:' . SITEURL . 'manage-list.php');

  } else {
    // failed deleted the list
    $_SESSION['delete_fail'] = "Failed to delete list";

    //redirect to manage-list
    header('Location:' . SITEURL . 'manage-list.php');
  }

} else {
  // redirect to manage-list.php 
  header('Location:' . SITEURL . 'manage-list.php');
}





?>
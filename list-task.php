<?php 
    include('config/constants.php');
    //Get the listid from URL
    
    $list_id_url = $_GET['list_id'];
?>

<html>
    <head>
        <title>Task Manager</title>
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
        
        
        <div class="all-task">
        
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
                
                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                    
                    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
                    
                    // query
                    $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";
                    
                    // execute query
                    $res = mysqli_query($conn, $sql);
                    
                    if($res==true)
                    {
                        // display the tasks on current list
                        // count the rows
                        $count_rows = mysqli_num_rows($res);

                        // we cant use task_id from DB because when you delete some from DB, you get 1,2,4,5,8..., so create serial number variable and increment it in loop
                        $sn = 1;
                        
                        if($count_rows>0)
                        {
                            // if we have tasks on this list
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $task_id = $row['task_id'];
                                $task_name = $row['task_name'];
                                $priority = $row['priority'];
                                $deadline = $row['deadline'];
                                ?>
                                
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $task_name; ?></td>
                                    <td><?php echo $priority; ?></td>
                                    <td><?php echo $deadline; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update </a>
                                    
                                    <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                    </td>
                                </tr>
                                
                                <?php
                            }
                        }
                        else
                        {
                            // no tasks on list
                            ?>
                            
                            <tr>
                                <td colspan="5">No tasks on this list.</td>
                            </tr>
                            
                            <?php
                        }
                    }
                ?>
                
                
            
            </table>
        
        </div>
        
        </div>
    </body>
    
</html>
































<?php
    include('../Query/db_conn.php');

    $Semester=$_GET['sub'];                        
    $sql_bat = "SELECT * FROM `course` WHERE `C_Sem` = '$Semester'";
    if($result_bat = mysqli_query($conn, $sql_bat)){
        if(mysqli_num_rows($result_bat) > 0){
            while($row = mysqli_fetch_array($result_bat)){
            echo "<option value=". htmlspecialchars($row['C_Code']) .">". htmlspecialchars($row['C_Name']) ."</option>";
            }
            mysqli_free_result($result_bat);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

?>
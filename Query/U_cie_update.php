<?php
 if (isset($_POST['submit'])) {
    include './db_conn.php';
    $Get_Bat = trim($_GET['batch']);
    $sql = "SELECT * FROM `student` WHERE S_Batch = '$Get_Bat'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    for ($i=1; $i <= $count; $i++) { 
        $Susn = mysqli_real_escape_string($conn,trim($_POST['usn_'.$i]));
        $Code = mysqli_real_escape_string($conn,trim($_POST['cour'.$i]));
        $cief = mysqli_real_escape_string($conn,trim($_POST['cief'.$i]));
        $cies = mysqli_real_escape_string($conn,trim($_POST['cies'.$i]));
        $ciet = mysqli_real_escape_string($conn,trim($_POST['ciet'.$i]));
        $Assi = mysqli_real_escape_string($conn,trim($_POST['assi'.$i]));
        mysqli_query($conn, "UPDATE `cie` SET `CIE1`='$cief',`CIE2`='$cies',`CIE3`='$ciet',`Assignment`='$Assi' WHERE `USN`='$Susn' AND `SubCode`='$Code'");
    }
    mysqli_close($conn);
    header("location: ../CIE");
 }
?> 
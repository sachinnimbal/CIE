<?php
 if (isset($_POST['submit'])) {
    include './db_conn.php';
    $Get_Bat = trim($_GET['batch']);
    $sql = "SELECT * FROM `student` WHERE S_Batch = '$Get_Bat'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    for ($i=1; $i <= $count; $i++) {
        $Batc = mysqli_real_escape_string($conn,trim($_POST['batc'.$i]));
        $Susn = mysqli_real_escape_string($conn,trim($_POST['usn_'.$i]));
        $Name = mysqli_real_escape_string($conn,trim($_POST['name'.$i]));
        $Seme = mysqli_real_escape_string($conn,trim($_POST['seme'.$i]));
        $Code = mysqli_real_escape_string($conn,trim($_POST['cour'.$i]));
        $cief = mysqli_real_escape_string($conn,trim($_POST['cief'.$i]));
        $cies = mysqli_real_escape_string($conn,trim($_POST['cies'.$i]));
        $ciet = mysqli_real_escape_string($conn,trim($_POST['ciet'.$i]));
        $Assi = mysqli_real_escape_string($conn,trim($_POST['assi'.$i]));
        mysqli_query($conn, "INSERT INTO `cie`(`Batch`, `USN`, `Name`, `Semester`, `SubCode`, `CIE1`, `CIE2`, `CIE3`, `Assignment`) VALUES ('$Batc','$Susn','$Name','$Seme','$Code','$cief','$cies','$ciet','$Assi')");
    }
    mysqli_close($conn);
    header("location: ../CIE");
 }
?>
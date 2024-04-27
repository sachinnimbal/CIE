<?php
require_once "../Query/db_conn.php";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUK | CIE Project</title>
    <link rel="icon" type="image/x-icon" href="./asset/img/sb.png">
    <link rel="stylesheet" href="../asset/css/bootstrap.css">
    <link rel="stylesheet" href="../asset/css/FontAwesome.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                if (isset($_POST['studentBatch']) && isset($_POST['Semester']) && isset($_POST['Course'])) {
                    $studentBatch = mysqli_real_escape_string($conn,test_input($_POST['studentBatch']));
                    $Semester = mysqli_real_escape_string($conn,test_input($_POST['Semester']));
                    $Course = mysqli_real_escape_string($conn,test_input($_POST['Course']));
                    $sql = "SELECT * FROM `cie` WHERE `Batch` = '$studentBatch' AND `Semester` = '$Semester' AND `subCode` = '$Course'";
                ?>
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th colspan="8"><img src="../Asset/img/header.jpg" class="w-100" alt=""></th>
                        </tr>
                        <tr>
                            <td class="text-end">Batch : </td>
                            <td class="text-start fw-bold"><?php echo htmlspecialchars($studentBatch); ?></td>
                            <td class="text-end" colspan="2">Semester : </td>
                            <td class="text-start fw-bold"><?php echo htmlspecialchars($Semester); ?></td>
                            <td class="text-end" colspan="2">Course Code : </td>
                            <td class="text-start fw-bold"><?php echo htmlspecialchars($Course); ?></td>
                        </tr>
                        <tr>
                            <th class="text-center">SL No.</th>
                            <th class="text-center">USN</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">CIE 01</th>
                            <th class="text-center">CIE 02</th>
                            <th class="text-center">CIE 03</th>
                            <th class="text-center">Assignment</th>
                            <th class="text-center">CIE + Assignment</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        $count = 0;
                        while($row = mysqli_fetch_array($result)){
                            $count++;
?>
                    <tr>
                        <td class="text-center"><?php echo $count; ?></td>
                        <td class="text-center fw-bold"><?php echo $row['USN']; ?></td>
                        <td class="text-start"><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['CIE1']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['CIE2']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['CIE3']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['Assignment']); ?></td>
                        <td class="text-center fw-bold">
                            <?php
                                $CIE1 = $row['CIE1'];
                                $CIE2 = $row['CIE2'];
                                $CIE3 = $row['CIE3'];
                                $FINAL = $row['Assignment'];
                                if ($CIE1 > $CIE2){
                                    if ($CIE2 > $CIE3){
                                        echo (round(($CIE1 + $CIE2)/2))+$FINAL;
                                    }else{
                                        echo (round(($CIE1 + $CIE3)/2))+$FINAL;
                                    }
                                }
                                else if($CIE1 > $CIE3){    
                                    echo (round(($CIE1 +  $CIE2)/2))+$FINAL;
                                }else{
                                    echo (round(($CIE2 + $CIE3)/2))+$FINAL;
                                }
                            ?>
                        </td>
                    </tr>
<?php
                        }
                        mysqli_free_result($result);
                    } else{
                        echo '<tr><td  colspan="8"><div class="alert alert-danger"><em>No records were found.</em></div></td></tr>';
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}else{
    echo '<div class="alert alert-danger"><em>Please Select a valid options.</em></div>';
}

?>
    <script src="../asset/js/bootstrap.js"></script>
    <script src="../asset/js/jquery.js"></script>
    <script src="../asset/js/FontAwesome.js"></script>
    <link rel="stylesheet" href="../Asset/css/jquery_Tables.css">
    <link rel="stylesheet" href="../Asset/css/buttons_Tables.css">
    <script src="../Asset/js/jquery.dataTables.min.js"></script>
    <script src="../Asset/js/dataTables.buttons.min.js"></script>
    <script src="../Asset/js/jszip.min.js"></script>
    <script src="../Asset/js/pdfmake.min.js"></script>
    <script src="../Asset/js/vfs_fonts.js"></script>
    <script src="../Asset/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
</body>

</html>
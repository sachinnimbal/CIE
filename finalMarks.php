<?php 
include 'header.php'; 
require_once "./Query/db_conn.php";
?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Final Marks Sheet</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">CIE & Assignment Final Marks Sheet</p>
            <div class="">

            </div>
            <div class="">
                <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                    <div class="col-md-3">
                        <label for="studentBatch" class="form-label">Batch</label>
                        <select class="form-select" id="studentBatch" name="studentBatch" required>
                            <option selected disabled value="">Choose...</option>
                            <?php
                                $sql_bat = "SELECT * FROM `batch`";
                                if($result_bat = mysqli_query($conn, $sql_bat)){
                                    if(mysqli_num_rows($result_bat) > 0){
                                        while($row = mysqli_fetch_array($result_bat)){
                                        echo "<option value=". htmlspecialchars($row['Batch']) .">". htmlspecialchars($row['Batch']) ."</option>";
                                        }
                                        mysqli_free_result($result_bat);
                                    } else{
                                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                    }
                                } else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please select a Batch.
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="cie" class="form-label">CIE</label>
                        <select class="form-select" id="cie" name="cie" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="CIE1">CIE1</option>
                            <option value="CIE2">CIE2</option>
                            <option value="CIE3">CIE3</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid CIE.
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="Semester" class="form-label">Semester</label>
                        <select class="form-select" id="Semester" name="Semester" onchange="mySubject(this.value)"
                            required>
                            <option selected disabled value="">Choose...</option>
                            <option value="SEM1">SEM1</option>
                            <option value="SEM2">SEM2</option>
                            <option value="SEM3">SEM3</option>
                            <option value="SEM4">SEM4</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid Semester.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="Course" class="form-label">Course</label>
                        <select class="form-select" id="Course" name="Course" required>
                            <option selected disabled value="">Choose...</option>
                            <?php                           
                                $sql_bat = "SELECT * FROM `course` WHERE `C_Emp` = '$user'";
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
                        </select>
                        <div class="invalid-feedback">
                            Please select a Course.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-success mt-4" type="submit">Get Marks</button>
                    </div>

                </form>
            </div>

            <hr class="hr">

            <div class="">
                <?php
                if (isset($_POST['studentBatch']) && isset($_POST['cie']) && isset($_POST['Semester']) && isset($_POST['Course'])) {
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    $Get_Bat = test_input($_POST['studentBatch']);
                    $Get_cie = test_input($_POST['cie']);
                    $Get_sem = test_input($_POST['Semester']);
                    $Get_cou = test_input($_POST['Course']);
                    $check = "SELECT * FROM `cie` WHERE Batch = '$Get_Bat' AND SubCode = '$Get_cou'";
                    if($result_Student = mysqli_query($conn, $check)){
                        if(mysqli_num_rows($result_Student) > 0){
                            $counter = 0;
                            ?>
                <form action="" method="" class="needs-validation" novalidate>
                    <table class="table">
                        <tr>
                            <td class="text-end">Batch :</td>
                            <td class="text-start fw-bold">
                                <?= $Get_Bat ?>
                            </td>
                            <td class="text-end">Semester :</td>
                            <td class="text-start fw-bold">
                                <?= $Get_sem ?>
                            </td>
                            <td class="text-end">Marks Type :</td>
                            <td class="text-start fw-bold">
                                <?= $Get_cie ?>
                            </td>
                            <td class="text-end">Course Code :</td>
                            <td class="text-start fw-bold">
                                <?= $Get_cou ?>
                            </td>
                        </tr>
                    </table>
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 100px;">SL No.</th>
                                    <th class="text-center" hidden>Batch</th>
                                    <th class="text-center">USN</th>
                                    <th class="text-center" hidden>Name</th>
                                    <th class="text-center" hidden>Semester</th>
                                    <th class="text-center" hidden>SubCode</th>
                                    <th class="text-center" style="width: 100px;">CIE1</th>
                                    <th class="text-center" style="width: 100px;">CIE2</th>
                                    <th class="text-center" style="width: 100px;">CIE3</th>
                                    <th class="text-center" style="width: 100px;">Assignment</th>
                                    <th class="text-center" style="width: 150px;">Final marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($result_Student)){
                                    $counter++;
                                ?>
                                <tr>
                                    <td><input type="text" name="" id="" value="<?php echo $counter; ?>" class="form-control text-center" disabled></td>
                                    <td hidden><input type="text" name="batc<?php echo $counter; ?>" id="" value="<?php echo htmlspecialchars($row['Batch']); ?>" class="form-control text-center"></td>
                                    <td><input type="text" name="usn_<?php echo $counter; ?>" id="usn" value="<?php echo htmlspecialchars($row['USN']); ?>" class="form-control text-center"></td>
                                    <td hidden><input type="text" name="name<?php echo $counter; ?>" id="name" value="<?php echo htmlspecialchars($row['Name']); ?>" class="form-control text-center"></td>
                                    <td hidden><input type="text" name="seme<?php echo $counter; ?>" id="" value="<?php echo htmlspecialchars($row['Semester']); ?>" class="form-control text-center"></td>
                                    <td hidden><input type="text" name="cour<?php echo $counter; ?>" id="" value="<?php echo htmlspecialchars($row['SubCode']); ?>" class="form-control text-center"></td>
                                    <td><input 
                                            type="text" 
                                            name="cief<?php echo $counter; ?>" 
                                            id="cief" 
                                            value="<?php echo htmlspecialchars($row['CIE1']); ?>" 
                                            class="form-control text-center
                                            <?php
                                            $CIE1 = $row['CIE1'];
                                            if($CIE1<8)
                                            {
                                                echo 'text-danger fw-bold';
                                            }
                                            else
                                            {
                                                echo 'text-success fw-bold';
                                            }
                                            ?>"></td>
                                    <td><input 
                                            type="text" 
                                            name="cies<?php echo $counter; ?>" 
                                            id="cies" 
                                            value="<?php echo htmlspecialchars($row['CIE2']); ?>" 
                                            class="form-control text-center
                                            <?php
                                            $CIE1 = $row['CIE2'];
                                            if($CIE1<8)
                                            {
                                                echo 'text-danger fw-bold';
                                            }
                                            else
                                            {
                                                echo 'text-success fw-bold';
                                            }
                                            ?>"></td>
                                    <td><input 
                                            type="text" 
                                            name="ciet<?php echo $counter; ?>" 
                                            id="ciet" 
                                            value="<?php echo htmlspecialchars($row['CIE3']); ?>" 
                                            class="form-control text-center
                                            <?php
                                            $CIE1 = $row['CIE3'];
                                            if($CIE1<8)
                                            {
                                                echo 'text-danger fw-bold';
                                            }
                                            else
                                            {
                                                echo 'text-success fw-bold';
                                            }
                                            ?>"></td>
                                    <td><input 
                                            type="text" 
                                            name="assi<?php echo $counter; ?>" 
                                            id="assi" 
                                            value="<?php echo htmlspecialchars($row['Assignment']); ?>" 
                                            class="form-control text-center
                                            <?php
                                            $A = $row['Assignment'];
                                            if($A<25)
                                            {
                                                echo 'text-danger fw-bold';
                                            }
                                            else
                                            {
                                                echo 'text-success fw-bold';
                                            }
                                            ?>"></td>
                                    <td><input 
                                            type="text" 
                                            name="avg<?php echo $counter; ?>" 
                                            id="avg" 
                                            value="<?php
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
                                            ?>" 
                                            class="form-control text-center fw-bold"></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?php
                            while($row = mysqli_fetch_array($result_Student)){
                                $counter++;   
                            }
                            mysqli_free_result($result_Student);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                    }
                                }                    
                            }
                            ?>
            </div>

        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<?php
    // Close connection
    mysqli_close($conn);
?>
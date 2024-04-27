<?php 
include 'header.php'; 
require_once "../Query/db_conn.php";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<div class="container">
    <div class="row mt-4">
        <div class="col d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Course</li>
                </ol>
            </nav>
            <a href="courseView" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Course Edit</p>
            <div class="">
            <?php
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $C_Id =  test_input($_GET["id"]);
        $sql = "SELECT * FROM course WHERE C_Id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $C_Id;
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $C_Sem = $row["C_Sem"];
                    $C_Code = $row["C_Code"];
                    $C_Name = $row["C_Name"];
                    $C_Emp = $row["C_Emp"];
                } else{
                    header("location: error.php");
                    exit();
                }                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }  else{
        exit();
    }
            ?>
            <div class="">
            <?php
            if (isset($_POST['couresUpdate'])) {
                $C_id = mysqli_real_escape_string($conn,test_input($_POST["courseId"]));
                $C_seme = mysqli_real_escape_string($conn,test_input($_POST["Semester"]));
                $C_code = mysqli_real_escape_string($conn,test_input($_POST["courseCode"]));
                $C_name = mysqli_real_escape_string($conn,test_input($_POST["courseName"]));
                $C_empl = mysqli_real_escape_string($conn,test_input($_POST["employee"]));
                $sql = "UPDATE `course` SET `C_Sem`=?, `C_Code`=?, `C_Name`=? ,`C_Emp`=? WHERE `C_Id`=? ";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "ssssi", $param_seme, $param_code, $param_name, $param_empl, $param_id);
                    $param_seme = $C_seme;
                    $param_code = $C_code;
                    $param_name = $C_name;
                    $param_empl = $C_empl;
                    $param_id = $C_id;
                    if(mysqli_stmt_execute($stmt)){
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Course </strong> Course Updated Successfully. Please Refresh the Page....
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else{
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Course </strong> Oops! Something went wrong. Please try again later.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            ?>
            </div>
            </div>
            <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                <input type="hidden" name="courseId" value="<?php echo htmlspecialchars($C_Id); ?>">
                <div class="col-md-4">
                    <label for="Semester" class="form-label">Semester</label>
                    <select class="form-select" id="Semester" name="Semester" required>
                        <option selected value="<?php echo htmlspecialchars($C_Sem); ?>"><?php echo htmlspecialchars($C_Sem); ?></option>
                        <option value="SEM1">SEM1</option>
                        <option value="SEM2">SEM2</option>
                        <option value="SEM3">SEM3</option>
                        <option value="SEM4">SEM4</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid Semester.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="courseCode" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode" value="<?php echo htmlspecialchars($C_Code); ?>" required>
                    <div class="invalid-feedback">
                        Please provide a valid Course Code.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="courseName" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="courseName" name="courseName" value="<?php echo htmlspecialchars($C_Name); ?>" required>
                    <div class="invalid-feedback">
                        Please provide a valid Course Name.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="employee" class="form-label">Faculty</label>
                    <select class="form-select" id="employee" name="employee" required>
                        <option selected value="<?php echo htmlspecialchars($C_Emp); ?>"><?php echo htmlspecialchars($C_Emp); ?></option>
                        <?php                            
                            $sql_emp = "SELECT * FROM `employee`";
                            if($result_emp = mysqli_query($conn, $sql_emp)){
                                if(mysqli_num_rows($result_emp) > 0){
                                    while($row = mysqli_fetch_array($result_emp)){
                                    echo "<option value=". htmlspecialchars($row['E_Id']) .">". htmlspecialchars($row['E_Name']) ."</option>";
                                    }
                                    mysqli_free_result($result_emp);
                                } else{
                                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                }
                            } else{
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Please select a Professor.
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to Submit Form
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" name="couresUpdate">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<?php
    // Close connection
    mysqli_close($conn);
?>
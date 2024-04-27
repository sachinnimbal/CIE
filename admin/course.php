<?php 
include 'header.php'; 
require_once "../Query/db_conn.php";
?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Course</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Course Form</p>
            <div class="">  
                <?php
                function test_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                  }
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $C_seme = mysqli_real_escape_string($conn,test_input($_POST["Semester"]));
                    $C_code = mysqli_real_escape_string($conn,test_input($_POST["courseCode"]));
                    $C_name = mysqli_real_escape_string($conn,test_input($_POST["courseName"]));
                    $C_empl = mysqli_real_escape_string($conn,test_input($_POST["employee"]));
                    $check = mysqli_query($conn, "SELECT `C_Code` FROM `course` WHERE `C_Code` = '$C_code'");
                    if (mysqli_num_rows($check)) {
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Course </strong> Course Code Has Been Already Taken...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else {
                        $sql = "INSERT INTO `course`(`C_Sem`, `C_Code`, `C_Name`, `C_Emp`) VALUES (?, ?, ?, ?)";
                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "ssss", $param_seme, $param_code, $param_name, $param_empl);
                            $param_seme = $C_seme;
                            $param_code = $C_code;
                            $param_name = $C_name;
                            $param_empl = $C_empl;
                            if(mysqli_stmt_execute($stmt)){
                                echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Course </strong> New Course Has Been Saved Successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            }else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                ?>
            </div>
            <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                <div class="col-md-4">
                    <label for="Semester" class="form-label">Semester</label>
                    <select class="form-select" id="Semester" name="Semester" required>
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

                <div class="col-md-4">
                    <label for="courseCode" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode" style='text-transform:uppercase' required>
                    <div class="invalid-feedback">
                        Please provide a valid Course Code.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="courseName" class="form-label">Course Title</label>
                    <input type="text" class="form-control" id="courseName" name="courseName" required>
                    <div class="invalid-feedback">
                        Please provide a valid Course Name.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="employee" class="form-label">Faculty </label>
                    <select class="form-select" id="employee" name="employee" required>
                        <option selected disabled value="">Choose...</option>
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
                        Please select a Faculty.
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
                    <button class="btn btn-primary" type="submit">Submit form</button>
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
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
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Faculty</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Faculty Form</p>
            <div class="">  
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $E_ID = mysqli_real_escape_string($conn,test_input($_POST["employeeId"]));
                    $S_nam = mysqli_real_escape_string($conn,test_input($_POST["employeeName"]));
                    $check = mysqli_query($conn, "SELECT `E_Id` FROM `employee` WHERE `E_Id` = '$E_ID'");
                    if (mysqli_num_rows($check)) {
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Faculty </strong> ID Has Been Already Taken...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else {
                        $sql = "INSERT INTO `employee`(`E_Id`, `E_Name`) VALUES (?, ?)";
                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "ss", $param_ID, $param_name);
                            $param_ID = $E_ID;
                            $param_name = $S_nam;
                            if(mysqli_stmt_execute($stmt)){
                                echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Faculty </strong> New Faculty Has Been Saved Successfully.
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
                    <label for="employeeId" class="form-label">Faculty  ID</label>
                    <input type="text" class="form-control" id="employeeId" name="employeeId" style='text-transform:uppercase' required>
                    <div class="invalid-feedback">
                        Please provide a valid Faculty  ID.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="employeeName" class="form-label">Faculty  Name</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName" required>
                    <div class="invalid-feedback">
                        Please provide a valid Faculty Name.
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
                    <button class="btn btn-primary" type="submit" name="employeeSubmit">Submit form</button>
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
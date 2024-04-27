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
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Faculty</li>
                </ol>
            </nav>
            <a href="employeeView" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Faculty Edit</p>
            <div class="">
            <?php
    if(isset($_GET["eid"]) && !empty(trim($_GET["eid"]))){
        $E_ID =  test_input($_GET["eid"]);
        $sql = "SELECT * FROM `employee` WHERE `E_Id` = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_EId);
            $param_EId = $E_ID;
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $E_Id = $row["E_Id"];
                    $E_Name = $row["E_Name"];
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
            if (isset($_POST['employeeUpdate'])) {
                $E_name = mysqli_real_escape_string($conn,test_input($_POST["EmployeeName"]));
                $sql = "UPDATE `employee` SET  `E_Name`=? WHERE `E_Id`=? ";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "ss", $param_Ename, $param_Eid);
                    $param_Ename = $E_name;
                    $param_Eid = $E_Id;
                    if(mysqli_stmt_execute($stmt)){
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Faculty </strong> Details has been Updated Successfully. Please Refresh the Page....
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else{
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Faculty </strong> Oops! Something went wrong. Please try again later.
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

                <div class="col-md-4">
                    <label for="EmployeeId" class="form-label">Faculty ID</label>
                    <input disabled type="text" class="form-control" id="EmployeeId" name="EmployeeId" value="<?php echo htmlspecialchars($E_Id); ?>" required>
                    <div class="invalid-feedback">
                        Please provide a valid Student USN.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="EmployeeName" class="form-label">Faculty Name</label>
                    <input type="text" class="form-control" id="EmployeeName" name="EmployeeName" value="<?php echo htmlspecialchars($E_Name); ?>" required>
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
                    <button class="btn btn-primary" type="submit" name="employeeUpdate">Submit form</button>
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
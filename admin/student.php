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
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Student</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Student Form</p>
            <div class="">  
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $S_USN = mysqli_real_escape_string($conn,test_input($_POST["studentUSN"]));
                    $S_bat = mysqli_real_escape_string($conn,test_input($_POST["studentBatch"]));
                    $S_nam = mysqli_real_escape_string($conn,test_input($_POST["studentName"]));
                    $check = mysqli_query($conn, "SELECT `S_USN` FROM `student` WHERE `S_USN` = '$S_USN'");
                    if (mysqli_num_rows($check)) {
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Student </strong> USN Has Been Already Taken...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else {
                        $sql = "INSERT INTO `student`(`S_USN`, `S_Batch`, `S_Name`) VALUES (?, ?, ?)";
                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "sss", $param_USN, $param_bat, $param_nam);
                            $param_USN = $S_USN;
                            $param_bat = $S_bat;
                            $param_nam = $S_nam;
                            if(mysqli_stmt_execute($stmt)){
                                echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Student </strong> New Student Has Been Saved Successfully.
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
            <form method="POST" action="" class="row g-3 needs-validation" novalidate autocomplete="off">
                <div class="col-md-4">
                    <label for="studentUSN" class="form-label">Student USN</label>
                    <input type="text" class="form-control" id="studentUSN" name="studentUSN" style='text-transform:uppercase' required>
                    <div class="invalid-feedback">
                        Please provide a valid USN No.
                    </div>
                </div>

                <div class="col-md-4">
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



                <div class="col-md-4">
                    <label for="studentName" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="studentName" name="studentName" required>
                    <div class="invalid-feedback">
                        Please provide a valid Student Name.
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
                    <button class="btn btn-primary" type="submit" name="studentSubmit">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="../Asset/js/inputmask.js"></script>
<script src="../Asset/js/inputmask_.js"></script>
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
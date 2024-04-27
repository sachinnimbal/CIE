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
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Student</li>
                </ol>
            </nav>
            <a href="studentView" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Student Edit</p>
            <div class="">
            <?php
    if(isset($_GET["usn"]) && !empty(test_input($_GET["usn"]))){
        $S_USN =  trim($_GET["usn"]);
        $sql = "SELECT * FROM student WHERE S_USN = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_USN);
            $param_USN = $S_USN;
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $S_Batch = $row["S_Batch"];
                    $S_Name = $row["S_Name"];
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
            if (isset($_POST['studentUpdate'])) {
                $S_batc = mysqli_real_escape_string($conn,test_input($_POST["studentBatch"]));
                $S_name = mysqli_real_escape_string($conn,test_input($_POST["studentName"]));
                $sql = "UPDATE `student` SET `S_Batch`=?, `S_Name`=? WHERE `S_USN`=? ";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "sss", $param_batc, $param_name, $param_usn);
                    $param_batc = $S_batc;
                    $param_name = $S_name;
                    $param_usn = $S_USN;
                    if(mysqli_stmt_execute($stmt)){
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Student </strong> Details has been Updated Successfully. Please Refresh the Page....
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else{
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Student </strong> Oops! Something went wrong. Please try again later.
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
                    <label for="studentUSN" class="form-label">Student USN</label>
                    <input disabled type="text" class="form-control" id="studentUSN" name="studentUSN" value="<?php echo htmlspecialchars($S_USN); ?>" required>
                    <div class="invalid-feedback">
                        Please provide a valid Student USN.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="studentBatch" class="form-label">Batch</label>
                    <select class="form-select" id="studentBatch" name="studentBatch" required>
                        <option selected value="<?php echo htmlspecialchars($S_Batch); ?>"><?php echo htmlspecialchars($S_Batch); ?></option>
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
                        Please select a Professor.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="studentName" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="studentName" name="studentName" value="<?php echo htmlspecialchars($S_Name); ?>" required>
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
                    <button class="btn btn-primary" type="submit" name="studentUpdate">Submit form</button>
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
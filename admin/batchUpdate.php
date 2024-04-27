<?php 
include 'header.php'; 
require_once "../Query/db_conn.php";
?>

<div class="container">
    <div class="row mt-4">
        <div class="col d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Batch</li>
                </ol>
            </nav>
            <a href="batchView" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Batch Edit</p>
            <div class="">
            <?php
    if(isset($_GET["Bid"]) && !empty(trim($_GET["Bid"]))){
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        $B_Id =  test_input($_GET["Bid"]);
        $sql = "SELECT * FROM batch WHERE B_Id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $B_Id;
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $B_Id = $row["B_Id"];
                    $B_Batch = $row["Batch"];
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
                $B_Id = mysqli_real_escape_string($conn,test_input($_POST["batchId"]));
                $B_Batch = mysqli_real_escape_string($conn,test_input($_POST["batch"]));
                $sql = "UPDATE `batch` SET `Batch`=? WHERE `B_Id`=? ";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "si", $param_batch, $param_id);
                    $param_batch = $B_Batch;
                    $param_id = $B_Id;
                    if(mysqli_stmt_execute($stmt)){
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Batch </strong> Batch Updated Successfully. Please Refresh the Page....
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else{
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Batch </strong> Oops! Something went wrong. Please try again later.
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
                <input type="hidden" name="batchId" value="<?php echo htmlspecialchars($B_Id); ?>">

                <div class="col-md-4">
                    <label for="batch" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="batch" name="batch" value="<?php echo htmlspecialchars($B_Batch); ?>" required>
                    <div class="invalid-feedback">
                        Please provide a valid Batch.
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

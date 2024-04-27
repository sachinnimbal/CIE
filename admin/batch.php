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
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Batch</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Batch Form</p>
            <div class=""> 
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                      }
                    $B_batch = mysqli_real_escape_string($conn,test_input($_POST["batch"]));
                    $check = mysqli_query($conn, "SELECT `Batch` FROM `batch` WHERE `Batch` = '$B_batch'");
                    if (mysqli_num_rows($check)) {
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Batch </strong> Has Been Already Taken...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else {
                        $sql = "INSERT INTO `Batch`(`Batch`) VALUES (?)";
                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "s", $param_batch);
                            $param_batch = $B_batch;
                            if(mysqli_stmt_execute($stmt)){
                                echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Batch </strong> New Batch Has Been Saved Successfully.
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
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="row g-3 needs-validation" novalidate>

                <div class="col-md-4">
                    <label for="batch" class="form-label">New Batch (Eg:20**-20**)</label>
                    <input type="text" class="form-control" id="batch" name="batch" required>
                    <div class="invalid-feedback">
                        Please provide a valid batch.
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
                    <button class="btn btn-primary" type="submit" name="batchSubmit">Submit form</button>
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
<script src="../Asset/js/inputmask.js"></script>
<?php
    // Close connection
    mysqli_close($conn);
?>
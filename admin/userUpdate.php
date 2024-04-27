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
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Account</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Users Edit</p>
            <div class="">
            <?php
            $status = '';
            $username = $password = "";
            $username_err = $password_err = $login_err = "";
            if(isset($_POST['admin_passwordBtn'])){                
                // Check if password is empty
                if(empty(trim($_POST["admin_password"]))){
                    $password_err = "Please enter your password.";
                } else{
                    $password = trim($_POST["admin_password"]);
                }
                
                // Validate credentials
                if(empty($username_err) && empty($password_err) && empty($role_err)){
                    // Prepare a select statement
                    $sql = "SELECT id, username, password FROM users WHERE username = ?";
                    
                    if($stmt = mysqli_prepare($conn, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        
                        // Set parameters
                        $param_username = $user;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Store result
                            mysqli_stmt_store_result($stmt);
                            
                            // Check if username exists, if yes then verify password
                            if(mysqli_stmt_num_rows($stmt) == 1){                    
                                // Bind result variables
                                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    if(password_verify($password, $hashed_password)){
                                        // Password is correct, so start a new session
                                        $status = 1;
                                    } else{
                                        // Password is not valid, display a generic error message
                                        echo "Invalid username, role or password.";
                                    }
                                }
                            } else{
                                // Username doesn't exist, display a generic error message
                                echo "Invalid username, role or password.";
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
            
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                }
                
            }
            ?>
            </div>
            <form action="" method="post" class="row g-3 needs-validation w-50" novalidate>
                <div class="">
                    <label for="admin_password" class="form-label">Enter User Password</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                    <div class="invalid-feedback">
                        Please Enter Loggen in user Password.
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
                <button type="submit" class="btn btn-primary" name="admin_passwordBtn">Submit</button>
            </form>
        </div>
    </div>
    <hr class="hr">
    
    <div class="row">
        <div class="col px-5">
            <div class="">
            <?php
            if (isset($_POST['userUpdate'])) {
                $U_role = mysqli_real_escape_string($conn,test_input($_POST["Faculty_rold"]));
                $U_pass = mysqli_real_escape_string($conn,test_input($_POST["userPassword"]));
                if (strlen($U_pass) < 6) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> Password must have atleast 6 characters...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                } else {
                    $sql = "UPDATE `users` SET `Role`=?, `Password`=? WHERE `Username`=? ";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "sss", $param_role, $param_pass, $param_user);
                        $param_role = $U_role;
                        $param_pass = password_hash($U_pass, PASSWORD_DEFAULT); 
                        $param_user = $user;
                        if(mysqli_stmt_execute($stmt)){
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>User Account </strong> has been Updated Successfully. Please Refresh the Page....
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                        } else{
                            echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>User Account </strong> Oops! Something went wrong. Please try again later.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                        }
                        mysqli_stmt_close($stmt);
                    }
                }              

            }
            ?>
            </div>
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="col-md-4">
                    <label for="FacultyID" class="form-label">Faculty ID</label>
                    <input type="text" class="form-control" id="FacultyID" value="<?php echo $_GET['FAC']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label for="Faculty_rold" class="form-label">User Role</label>
                    <select class="form-select" id="Faculty_rold" name="Faculty_rold" required <?php if ($status == 1) { echo 'hello'; }else { echo 'disabled'; } ?>>
                        <option selected disabled value="">Choose...</option>
                        <option selected value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid Role.
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="userPassword" class="form-label">Enter New Password</label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" required <?php if ($status == 1) { echo 'hello'; }else { echo 'disabled'; } ?>>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="userUpdate" <?php if ($status == 1) { echo 'hello'; }else { echo 'disabled'; } ?> required>
                        <label class="form-check-label" for="userUpdate">
                            Agree to Submit Form
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" value="userUpdate" name="userUpdate" <?php if ($status == 1) { echo 'hello'; }else { echo 'disabled'; } ?>>Submit
                        form</button>
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
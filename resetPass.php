<?php 
include 'header.php'; 
require_once "./Query/db_conn.php";
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
            <p class="fs-4 fw-bold">Reset Password</p>
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
                $U_hint = mysqli_real_escape_string($conn,test_input($_POST["hint"]));
                $U_answ = mysqli_real_escape_string($conn,test_input($_POST["ans"]));
                $U_role = mysqli_real_escape_string($conn,test_input($_POST["Faculty_rold"]));
                $U_pass = mysqli_real_escape_string($conn,test_input($_POST["userPassword"]));
                $sql = "UPDATE `users` SET `Role`=?,`Hint`=?,`Ans`=?, `Password`=? WHERE `Username`=? ";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "sssss", $param_role, $param_hint, $param_answ, $param_pass, $param_user);
                    $param_role = $U_role;
                    $param_hint = $U_hint;
                    $param_answ = $U_answ;
                    $param_pass = password_hash($U_pass, PASSWORD_DEFAULT); 
                    $param_user = $user;
                    if(mysqli_stmt_execute($stmt)){
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Password </strong> has been Reset Successfully...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    } else{
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Password </strong> Oops! Something went wrong. Please try again later.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            ?>
            </div>
            <br>
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-4">
                        <label for="FacultyID" class="form-label">Faculty ID</label>
                        <input type="text" class="form-control" id="FacultyID" value="<?php echo $user; ?>" disabled>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="role" class="form-label">Hint</label>
                        <select class="form-select" id="hint" name="hint" required <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>
                            <option value="" selected disabled>--- Choose ---</option>
                            <option value="What is your Date of Birth?">What is your Date of Birth?</option>
                            <option value="What is the name of the town where you were born?">What is the name of the town where you were born?</option>
                            <option value="What is your favorite colour?">What is your favorite colour?</option>
                            <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                            <option value="What was your dream job as a child?">What was your dream job as a child?</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a User Role.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="ans" class="form-label">Answer</label>
                        <input type="text" class="form-control" id="ans" name="ans" required <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="Faculty_rold" class="form-label">User Role</label>
                        <select class="form-select" id="Faculty_rold" name="Faculty_rold" disabled required <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>
                            <!-- <option selected disabled value="">Choose...</option> -->
                            <option selected value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid Role.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="userPassword" class="form-label">Enter New Password</label>
                        <input type="password" class="form-control" id="userPassword" name="userPassword" required <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="userUpdate" <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?> required>
                        <label class="form-check-label" for="userUpdate">
                            Agree to Submit Form
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" value="userUpdate" name="userUpdate" <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>Submit
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
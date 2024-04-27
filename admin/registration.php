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
                    <li class="breadcrumb-item" aria-current="page">Users</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Registration Form</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col-12 px-5">
            <p class="fs-4 fw-bold">Registration Form</p>
            <div class="">  
                <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if (isset($_POST["username"]) && isset($_POST["hint"])) {
                    $username = mysqli_real_escape_string($conn,test_input($_POST["username"]));
                    $role = mysqli_real_escape_string($conn,test_input($_POST["role"])); 
                    $hint = mysqli_real_escape_string($conn,test_input($_POST["hint"])); 
                    $ans = mysqli_real_escape_string($conn,test_input($_POST["ans"])); 
                    $password = mysqli_real_escape_string($conn,test_input($_POST["password"])); 
                    $cpassword = mysqli_real_escape_string($conn,test_input($_POST["confirm_password"]));
                    $check = mysqli_query($conn, "SELECT `Username` FROM `users` WHERE `Username` = '$username'"); 
                    if (mysqli_num_rows($check)) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> User Have already Taken....
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else if ($hint=="") {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> Select Hint...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }  else if ($ans=="") {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> Provide valid hint answer...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else if (strlen($password) < 6) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> Password must have atleast 6 characters...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else if ($password != $cpassword) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form </strong> Password did not match...
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        $sql = "INSERT INTO `users`(`Username`, `Role` ,`Hint` ,`Ans` , `Password`) VALUES (?, ?, ?, ?, ?)";
                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_role, $param_hint, $param_ans, $param_password);
                            $param_username = $username;
                            $param_role = $role;
                            $param_hint = $hint;
                            $param_ans = $ans;
                            $param_password = password_hash($password, PASSWORD_DEFAULT); 
                            if(mysqli_stmt_execute($stmt)){
                                echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Registration Form  </strong> New User Has Been Saved Successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            }else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        }
                        mysqli_stmt_close($stmt);
                    }
                    }else{
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration Form  </strong> Select Fields.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                    }
                    
                }
                ?>
            </div>

        </div>
        <div class="row px-5">
        <div class="col-5">
            <form method="POST" action="" class="row g-3 needs-validation" novalidate>

                <div class="col-12">
                    <label for="username" class="form-label">Faculty Name   </label>
                    <select class="form-select" id="username" name="username" required>
                        <option selected disabled value="">Choose...</option>
                        <?php                            
                            $sql_bat = "SELECT * FROM `employee`";
                            if($result_bat = mysqli_query($conn, $sql_bat)){
                                if(mysqli_num_rows($result_bat) > 0){
                                    while($row = mysqli_fetch_array($result_bat)){
                                    echo "<option value=". htmlspecialchars($row['E_Id']) .">". htmlspecialchars($row['E_Name']) ."</option>";
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
                        Please select a Faculty ID.
                    </div>
                </div>

                <div class="col-12">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a User Role.
                    </div>
                </div>

                <div class="col-12">
                    <label for="role" class="form-label">Hint</label>
                    <select class="form-select" id="hint" name="hint" required>
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

                <div class="col-12">
                    <label for="ans" class="form-label">Answer</label>
                    <input type="text" class="form-control" id="ans" name="ans" required>
                    <div class="invalid-feedback">
                        Please provide a valid Answer.
                    </div>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Please provide a valid password.
                    </div>
                </div>

                <div class="col-12">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="invalid-feedback">
                        Please provide a confirm password.
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
                    <button class="btn btn-primary" type="submit" name="employeeSubmit">Register</button>
                </div>
            </form>

            </div>
            <div class="col-7">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">SL No.</th>
                          <th scope="col" class="text-center">Fac ID</th>
                          <th scope="col" class="text-center">Fac Name</th>
                          <th scope="col" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php                            
                                $sql_emp = "SELECT * FROM `employee`";
                                if($result_emp = mysqli_query($conn, $sql_emp)){
                                    if(mysqli_num_rows($result_emp) > 0){
                                      $count = 0;
                                        while($row = mysqli_fetch_array($result_emp)){
                                          $count++;
                                        ?>
                                      <tr>
                                          <td class="text-center">
                                          <?php echo $count; ?>
                                          </td>
                                          <td class="text-center">
                                          <?php echo htmlspecialchars($row['E_Id']) ?>
                                          </td>
                                          <td class="text-start">
                                          <?php echo htmlspecialchars($row['E_Name']) ?>
                                          </td>
                                          <td class="text-center">
                                          <a href="employeeUpdate?eid=<?= htmlspecialchars($row['E_Id']); ?>" class="btn btn-warning"
                                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                                              class="fa-solid fa-marker"></i> </a>
                                          <a href="employeeView?eid=<?= htmlspecialchars($row['E_Id']); ?>" class="btn btn-danger"
                                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                                              class="fa-solid fa-trash-can"></i> </a>
                                          </td>
                                      </tr>
                                      <?php
                                        }
                                        mysqli_free_result($result_emp);
                                    } else{
                                        echo '
                                        <tr>
                                          <td colspan="7"><div class="alert alert-danger"><em>No records were found.</em></div></td>
                                        </tr>
                                        ';
                                    }
                                } else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                            ?>
                      </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
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
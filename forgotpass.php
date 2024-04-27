<?php 
require_once "./Query/db_conn.php"; 
$status = 0;                           
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharnbasva University | CIE Project</title>
    <link rel="icon" type="image/x-icon" href="./Asset/img/sb.png">
    <link href="./Asset/css/bootstrap.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center my-5">Forgot Password</h1>
                <?php
                    if (!isset($_GET['username'])) {
                       ?>
                       
                <div class="card w-50 m-auto">
                    <div class="card-body">
                        <h5 class="card-title">Find Your Account</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Please enter your name to search for your account.
                        </h6>
                        <form action="" method="GET" autocomplete="off">
                            <div class="form-floating mt-2">
                                <select class="form-select"
                                    id="floatingSelect" name="username" aria-label="Floating label select example"
                                    required>
                                    <option selected disabled value="">Choose...</option>
                                    <?php
                                    $sql_user = "SELECT employee.E_Id, employee.E_Name FROM users, employee WHERE users.Username = employee.E_Id";
                                    if($result_user = mysqli_query($conn, $sql_user)){
                                        if(mysqli_num_rows($result_user) > 0){
                                            while($row = mysqli_fetch_array($result_user)){
                                            echo "<option value=". htmlspecialchars($row['E_Id']) .">". htmlspecialchars($row['E_Name']) ."</option>";
                                            }
                                            mysqli_free_result($result_user);
                                        } else{
                                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                        }
                                    } else{
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                                ?>
                                </select>
                                <label for="floatingSelect">Select Faculty</label>
                                <span class="invalid-feedback">
                                    <?php echo $role_err; ?>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Search</button>
                        </form>
                    </div>
                </div>
                       <?php 
                    }elseif (isset($_GET['username'])) {
                        $user = mysqli_real_escape_string($conn,test_input($_GET["username"]));
                        ?>
                <div class="card w-50 m-auto">
                    <div class="card-body">
                        <h5 class="card-title">Find Your Account</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Please enter your hint answer to verify for your account.
                        </h6>
                        <?php
                            if (isset($_POST['verify'])) {
                                
                                $ans = mysqli_real_escape_string($conn,test_input($_POST["ans"]));
                                $sql = "SELECT * FROM `users` WHERE Username = '$user' AND Ans = '$ans'";  
                                $result = mysqli_query($conn, $sql);  
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
                                $count = mysqli_num_rows($result); 
                                if($count == 1){ 
                                    $status=1;
                                }  
                                else{  
                                    echo "<div class='alert alert-danger'><em>Wrong Answer...</em></div>";  
                                } 
                            }
                        ?>
                        <form action="" method="POST" autocomplete="off"> 
                            <div class="form-floating mt-2">
                                <div class="mb-3">
                                    <label for="hint" class="form-label">Hint Question</label>
                                    <?php
                                        $Forgot_user = mysqli_real_escape_string($conn,test_input($_GET['username']));
                                        $sql_hint = "SELECT * FROM `users` WHERE Username='$Forgot_user'";
                                        if($result_emp = mysqli_query($conn, $sql_hint)){
                                            if(mysqli_num_rows($result_emp) > 0){
                                                while($row = mysqli_fetch_array($result_emp)){
                                                    ?>
                                                    <input type='text' class='form-control' id='hint' value="<?php echo htmlspecialchars($row['Hint']); ?>">
                                                    <?php
                                                }
                                                mysqli_free_result($result_emp);
                                            } else{
                                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                            }
                                        } else{
                                            echo "Oops! Something went wrong. Please try again later.";
                                        }
                                    ?>
                                    
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="ans" name="ans">
                                    <div id="ans" class="form-text">Enter Hint answer to Update your password</div>
                                </div>
                            </div>
                            <button type="submit" name="verify" id="verify" class="btn btn-primary mt-3">verify</button>
                        </form>
                        <form action="" method="post" class="mt-4" autocomplete="off">
                        <div class="">
                            <?php
                            if (isset($_POST['userUpdate'])) {
                                $U_pass = mysqli_real_escape_string($conn,test_input($_POST["reset"]));
                                $sql = "UPDATE `users` SET `Password`=? WHERE `Username`=? ";
                                if (strlen($U_pass) < 6) {
                                    echo '
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Registration Form </strong> Password must have atleast 6 characters...
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                } else {
                                    if($stmt = mysqli_prepare($conn, $sql)){
                                        mysqli_stmt_bind_param($stmt, "ss", $param_user, $param_pass);
                                        $param_user = password_hash($U_pass, PASSWORD_DEFAULT); 
                                        $param_pass = $user;
                                        if(mysqli_stmt_execute($stmt)){
                                            echo '
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>User </strong> Password Reset successful... <a href="./login.php" class="text-center fw-bold">Login</a>
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
                                
                                
                            }
                            ?>
                            </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Password</label>
                            <input type="password" name="reset" class="form-control" id="Password"<?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>
                            <button class="btn btn-primary mt-3" type="submit" value="userUpdate" name="userUpdate" <?php if ($status == 1) { echo ''; }else { echo 'disabled'; } ?>>Reset Password</button>
                        </div>
                        </form>
                    </div>
                </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
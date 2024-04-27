<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to Home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "./Query/db_conn.php";
 
// Define variables and initialize with empty values
$username = $role = $password = "";
$username_err = $role_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

        // Check if Role is empty
        if(empty(trim($_POST["role"]))){
            $role_err = "Please enter your role.";
        } else{
            $role = trim($_POST["role"]);
        }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err) && empty($role_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, Role, password FROM users WHERE username = ? AND Role = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_role);
            
            // Set parameters
            $param_username = $username;
            $param_role = $role;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $role, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            $_SESSION["role"] = $role; 
                            $_SESSION["status"] = $status; 
                            if ( $_SESSION["role"] == 'admin') {
                                session_start();
                                // Store data in session variables
                                $_SESSION["admin_loggedin"] = true;
                                $_SESSION["admin_id"] = $id;
                                $_SESSION["admin_username"] = $username;
                                $_SESSION["Admin_role"] = $role; 
                                // Redirect user to Home page
                                header("location: admin/index.php");
                            }elseif ($_SESSION["role"] == 'user') {
                                session_start();
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["role"] = $role; 
                                // Redirect user to Home page
                                header("location: index.php");
                            }else {
                                session_start();
                                $_SESSION = array();
                                session_destroy();
                                header("location: login");
                            }
                            
                            
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username, role or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username, role or password.";
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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharnbasva University | CIE Project</title>
    <link rel="icon" type="image/x-icon" href="./Asset/img/sb.png">
    <link href="./Asset/css/bootstrap.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body>

    <main class="form-signin w-100 m-auto">
        <center>
            <img class="mb-4" src="./Asset/img/sb.png" alt="" width="150" height="150">
            <h1 class="h3 mb-3 fw-normal">Login</h1>
            <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
            ?>
        </center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">       
            <!-- <div class="form-floating">
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">User Name</label>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div> -->
            <div class="form-floating mt-2">
                <select class="form-select <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" id="floatingSelect" name="username" aria-label="Floating label select example" required>
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
                <span class="invalid-feedback"><?php echo $role_err; ?></span>
            </div>
            <div class="form-floating mt-2">
                <select class="form-select <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" id="floatingSelect" name="role" aria-label="Floating label select example">
                  <option selected value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
                <label for="floatingSelect">Select User Role</label>
                <span class="invalid-feedback"><?php echo $role_err; ?></span>
            </div>
            <div class="form-floating mt-2">
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" value="Login">Sign in</button>
            <center>
            <p class=" mb-0 text-muted">
                <a href="./forgotpass.php" class="fw-semibold">Forgot password?</a><br>
            Copyright &copy; 
            <span id="year"></span> Sharnbasva University,Kalaburagi <br>
            <span class="fw-semibold">Designed & Developed by Department of</span><br>
            <span class="fw-bolder"><span class="fs-4">M</span>aster of Computer Application.</span> <br>      
            <span class="fw-bolder"><a href="team">The Team Byte</a></span>      
            </p>
            </center>
        </form>
    </main>
    <script src="./Asset/js/bootstrap.js"></script>
    <script src="./Asset/js/jquery.js"></script>
        <script>
      $("#year").text( (new Date).getFullYear() );
    </script>
</body>

</html>
<?php
    // Close connection
    mysqli_close($conn);
?>

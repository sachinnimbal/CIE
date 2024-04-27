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
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Account</li>
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Users</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <hr class="hr">
    <div class="col px-5">
      <p class="fs-4 fw-bold">Users Table</p>
      <div class="">
      <?php
      if(isset($_GET["UDid"]) && !empty($_GET["UDid"])){
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
          mysqli_stmt_bind_param($stmt, "i", $param_id);
          $param_id = trim($_GET["UDid"]);
          if(mysqli_stmt_execute($stmt)){
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>User </strong> User Deleted Successfully...
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
          mysqli_stmt_close($stmt);
      }
      }else{
        if(isset($_GET["Uid"]) && empty(trim($_GET["Uid"]))){
          echo '
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>User </strong> User Invalid...
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
      }
      }
      ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col" class="text-center">SL No.</th>
                <th scope="col" class="text-center">User ID</th>
                <th scope="col" class="text-center">Role</th>
                <th scope="col" class="text-center">Password</th>
                <th scope="col" class="text-center">Created On</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php                            
                      $sql_batch = "SELECT * FROM `users`";
                      if($result_batch = mysqli_query($conn, $sql_batch)){
                          if(mysqli_num_rows($result_batch) > 0){
                            $count = 0;
                              while($row = mysqli_fetch_array($result_batch)){
                                $count++;
                              ?>
                            <tr>
                                <td class="text-center">
                                <?php echo htmlspecialchars($count); ?>
                                </td>
                                <td class="text-center">
                                <?php echo htmlspecialchars($row['Username']); ?>
                                </td>
                                <td class="text-center">
                                <?php echo htmlspecialchars($row['Role']); ?>
                                </td>
                                <td class="text-center">
                                <a href="?Uid=<?= htmlspecialchars($row['id']); ?>" class="btn btn-primary"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </td>
                                <td class="text-center">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?php echo htmlspecialchars($row['Created_On']) ?>"><?php echo htmlspecialchars($row['Updated_On']) ?></span>                  
                                </td>
                                <td class="text-center">
                                <a href="userUpdate?FAC=<?= htmlspecialchars($row['Username']); ?>" class="btn btn-warning"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                                    class="fa-solid fa-marker"></i> </a>
                                <a href="users?UDid=<?= htmlspecialchars($row['id']); ?>" class="btn btn-danger"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                                    class="fa-solid fa-trash-can"></i> </a>
                                </td>
                            </tr>
                            <?php
                              }
                              mysqli_free_result($result_batch);
                          } else{
                              echo '
                              <tr>
                                <td colspan="8"><div class="alert alert-danger"><em>No records were found.</em></div></td>
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
</script>
<?php
    // Close connection
    mysqli_close($conn);
?>
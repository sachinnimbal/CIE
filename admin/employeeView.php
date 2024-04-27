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
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Faculty</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <hr class="hr">
    <div class="col px-5">
      <p class="fs-4 fw-bold">Faculty Details</p>
      <div class="">
      <?php
      if(isset($_GET["eid"]) && !empty($_GET["eid"])){
        $sql = "DELETE FROM `employee` WHERE E_Id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_id);
          $param_id = test_input($_GET["eid"]);
          if(mysqli_stmt_execute($stmt)){
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Faculty </strong> Deleted Successfully...
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
          mysqli_stmt_close($stmt);
      }
      }else{
        if(isset($_GET["usn"]) && empty(test_input($_GET["usn"]))){
          echo '
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Faculty </strong> USN Invalid...
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
                <th scope="col" class="text-center">Fac ID</th>
                <th scope="col" class="text-center">Faculty Name</th>
                <th scope="col" class="text-center">Created On</th>
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
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?php echo htmlspecialchars($row['Created_On']) ?>"><?php echo htmlspecialchars($row['Updated_On']) ?></span>                  
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
</script>
<?php
    // Close connection
    mysqli_close($conn);
?>
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
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Student</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <hr class="hr">
    <div class="col px-5">
      <p class="fs-4 fw-bold">Student Details</p>
      <div class="">
        <?php
      if(isset($_GET["usn"]) && !empty($_GET["usn"])){
        $sql = "DELETE FROM `student` WHERE S_USN = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_id);
          $param_id = test_input($_GET["usn"]);
          if(mysqli_stmt_execute($stmt)){
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Student </strong> USN Deleted Successfully...
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
          <strong>Student </strong> USN Invalid...
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
      }
      }
      ?>
        <form action="" method="get">
          <div class="row">
            <div class="col-md-6">
              <select class="form-select" id="studentBatch" name="studentBatch" required>
                <?php 
                  if (isset($_GET['studentBatch'])) {
                    echo '<option selected disabled value="'.$_GET['studentBatch'].'">'.$_GET['studentBatch'].'</option>';
                  }else {
                    echo '<option selected disabled value="">Select Batch...</option>';
                  }
                ?>                  
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
                  Please select a Batch.
              </div>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
        <div class="table-responsive mt-3">
          <table class="table">
            <thead>
              <tr>
                <th scope="col" class="text-center">SL No.</th>
                <th scope="col" class="text-center">USN</th>
                <th hidden scope="col" class="text-center">Batch</th>
                <th scope="col" class="text-center">Student Name</th>
                <th scope="col" class="text-center">Created On</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if (isset($_GET['studentBatch'])) {
                $batch = test_input($_GET['studentBatch']);
                $sql_stu = "SELECT * FROM `student` WHERE S_Batch = '$batch'";
                  if($result_stu = mysqli_query($conn, $sql_stu)){
                      if(mysqli_num_rows($result_stu) > 0){
                        $count = 0;
                          while($row = mysqli_fetch_array($result_stu)){
                              $count++;
                ?>
              <tr>
                <td class="text-center">
                  <?php echo htmlspecialchars($count); ?>
                </td>
                <td class="text-center">
                  <?php echo htmlspecialchars($row['S_USN']); ?>
                </td>
                <td hidden class="text-center">
                  <?php echo htmlspecialchars($row['S_Batch']); ?>
                </td>
                <td class="text-start">
                  <?php echo htmlspecialchars($row['S_Name']); ?>
                </td>
                <td class="text-center">
                  <span data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="<?php echo htmlspecialchars($row['Created_On']); ?>">
                    <?php echo htmlspecialchars($row['Updated_On']); ?>
                  </span>
                </td>
                <td class="text-center">
                  <a href="studentUpdate?usn=<?= htmlspecialchars($row['S_USN']); ?>" class="btn btn-warning"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                      class="fa-solid fa-marker"></i> </a>
                  <a href="studentView?usn=<?= htmlspecialchars($row['S_USN']); ?>" class="btn btn-danger"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i
                      class="fa-solid fa-trash-can"></i> </a>
                </td>
              </tr>
              <?php
                            }
                            mysqli_free_result($result_stu);
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
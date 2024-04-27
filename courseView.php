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
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Course</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <hr class="hr">
    <div class="col px-5">
      <p class="fs-4 fw-bold">Course Details</p>
      <div class="">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col" class="text-center">SL No.</th>
                <th scope="col" class="text-center">Semester</th>
                <th scope="col" class="text-center">Course Code</th>
                <th scope="col" class="text-center">Course Title</th>
                <th scope="col" class="text-center">Faculty</th>
                <th scope="col" class="text-center">Created On</th>
              </tr>
            </thead>
            <tbody>
              <?php                            
                      $sql_cou = "SELECT * FROM `course` WHERE `C_Emp` = '$user'";
                      if($result_cou = mysqli_query($conn, $sql_cou)){
                          if(mysqli_num_rows($result_cou) > 0){
                            $count = 0;
                              while($row = mysqli_fetch_array($result_cou)){
                                $count++;
                              ?>
              <tr>
                <td class="text-center">
                  <?php echo $count; ?>
                </td>
                <td class="text-center">
                  <?php echo htmlspecialchars($row['C_Sem'])?>
                </td>
                <td class="text-center">
                  <?php echo htmlspecialchars($row['C_Code'])?>
                </td>
                <td class="text-start">
                  <?php echo htmlspecialchars($row['C_Name'])?>
                </td>
                <td class="text-start">
                  <?php echo htmlspecialchars($row['C_Emp'])?>
                </td>
                <td class="text-center">
                  <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?php echo htmlspecialchars($row['Created_On'])?>"><?php echo htmlspecialchars($row['Updated_On'])?></span>                  
                </td>
              </tr>
              <?php
                              }
                              mysqli_free_result($result_cou);
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
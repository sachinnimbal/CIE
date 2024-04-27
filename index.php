<?php 
include'header.php'; 
require_once "./Query/db_conn.php";
$sql1 = "SELECT * FROM `student`";
$sql2 = "SELECT * FROM `course` WHERE C_Emp = '$user'";
$sql4 = "SELECT * FROM `batch`";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result4 = mysqli_query($conn, $sql4);
?>
<style>
  #Home_details {
    font-size: 100px;
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
</style>
<div class="container">
  <div class="row mt-4">
    <div class="col">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Home</li>
        </ol>
      </nav>
    </div>
    <hr class="hr">
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="row g-0 bg-light position-relative rounded-5 border">
        <div class="col-md-6 mb-md-0 p-md-4">
          <i class="fa-solid fa-user-graduate" id="Home_details"></i>
        </div>
        <div class="col-md-6 p-4 ps-md-0">
          <h5 class="mt-0">Student Details</h5>
          <p class="m-0">Total No of Student's</p>
          <?php
                if ($result1){
                  $row = mysqli_num_rows($result1);          
                    if ($row){
                        echo "<p class='m-0 fs-1 fw-bold text-info'>".$row."</p>";
                    }
                  mysqli_free_result($result1);
                }
                ?>
          <a href="StudentView" class="text-decoration-none"><i class="fa-solid fa-link"></i> Go Students</a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="row g-0 bg-light position-relative rounded-5 border">
        <div class="col-md-6 mb-md-0 p-md-4">
          <i class="fa-solid fa-book" id="Home_details"></i>
        </div>
        <div class="col-md-6 p-4 ps-md-0">
          <h5 class="mt-0">Course Details</h5>
          <p class="m-0">Total No of Subject's</p>
          <?php
                if ($result2){
                  $row = mysqli_num_rows($result2);          
                    if ($row){
                        echo "<p class='m-0 fs-1 fw-bold text-info'>".$row."</p>";
                    }
                  mysqli_free_result($result2);
                }
                ?>
          <a href="CourseView" class="text-decoration-none"><i class="fa-solid fa-link"></i> Go Course</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-6">
      <div class="row g-0 bg-light position-relative rounded-5 border">
        <div class="col-md-6 mb-md-0 p-md-4">
          <i class="fa-solid fa-id-card-clip" id="Home_details"></i>
        </div>
        <div class="col-md-6 p-4 ps-md-0">
          <h5 class="mt-0">Batch Details</h5>
          <p class="m-0">Total No of Batch's</p>
          <?php
                  if ($result4){
                    $row = mysqli_num_rows($result4);          
                      if ($row){
                          echo "<p class='m-0 fs-1 fw-bold text-info'>".$row."</p>";
                      }
                    mysqli_free_result($result4);
                  }
                  ?>
          <a href="batchView" class="text-decoration-none"><i class="fa-solid fa-link"></i> Go Batch</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
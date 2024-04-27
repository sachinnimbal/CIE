<?php 
include 'header.php'; 
require_once "./Query/db_conn.php";
?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item fw-bold text-primary" aria-current="page">Report</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <hr class="hr">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Generate Report</p>
            <div class="">

            </div>
            <div class="">
                <form action="report" method="POST" class="row g-3 needs-validation" novalidate>
                    <div class="col-md-3">
                        <label for="studentBatch" class="form-label">Batch</label>
                        <select class="form-select" id="studentBatch" name="studentBatch" required>
                            <option selected disabled value="">Choose...</option>
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

                    <div class="col-md-2">
                        <label for="Semester" class="form-label">Semester</label>
                        <select class="form-select" id="Semester" name="Semester" onchange="mySubject(this.value)"
                            required>
                            <option selected disabled value="">Choose...</option>
                            <option value="SEM1">SEM1</option>
                            <option value="SEM2">SEM2</option>
                            <option value="SEM3">SEM3</option>
                            <option value="SEM4">SEM4</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid Semester.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="Course" class="form-label">Course</label>
                        <select class="form-select" id="Course" name="Course" required>
                        <option selected disabled value="">Choose...</option>
                        <?php                            
                            $sql_bat = "SELECT * FROM `course` WHERE `C_Emp` = '$user'";
                            if($result_bat = mysqli_query($conn, $sql_bat)){
                                if(mysqli_num_rows($result_bat) > 0){
                                    while($row = mysqli_fetch_array($result_bat)){
                                    echo "<option value=". htmlspecialchars($row['C_Code']) .">". htmlspecialchars($row['C_Name']) ."</option>";
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
                            Please select a Course.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-success mt-4" type="submit">Get Marks</button>
                    </div>

                </form>
            </div>

            <hr class="hr">
        </div>
    </div>

    <div class="row">
        <div class="col px-5">
            <p class="fs-4 fw-bold">Export Report</p>
            <div class="">

            </div>
            <div class="">
                <form action="convert" method="POST" class="row g-3 needs-validation" novalidate>
                    <div class="col-md-3">
                        <label for="studentBatch" class="form-label">Batch</label>
                        <select class="form-select" id="studentBatch" name="studentBatch" required>
                            <option selected disabled value="">Choose...</option>
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

                    <div class="col-md-2">
                        <label for="Semester" class="form-label">Semester</label>
                        <select class="form-select" id="Semester" name="Semester" onchange="mySubject(this.value)"
                            required>
                            <option selected disabled value="">Choose...</option>
                            <option value="SEM1">SEM1</option>
                            <option value="SEM2">SEM2</option>
                            <option value="SEM3">SEM3</option>
                            <option value="SEM4">SEM4</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid Semester.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="Course" class="form-label">Course</label>
                        <select class="form-select" id="Course" name="Course" required>
                        <option selected disabled value="">Choose...</option>
                        <?php                            
                            $sql_bat = "SELECT * FROM `course` WHERE `C_Emp` = '$user'";
                            if($result_bat = mysqli_query($conn, $sql_bat)){
                                if(mysqli_num_rows($result_bat) > 0){
                                    while($row = mysqli_fetch_array($result_bat)){
                                    echo "<option value=". htmlspecialchars($row['C_Code']) .">". htmlspecialchars($row['C_Name']) ."</option>";
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
                            Please select a Course.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary mt-4" type="submit">Export</button>
                    </div>

                </form>
            </div>

            <hr class="hr">
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<?php
    // Close connection
    mysqli_close($conn);
?>
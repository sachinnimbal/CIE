<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  if(!isset($_SESSION["role"]) || $_SESSION["role"] !== true){
    $_SESSION = array();
    session_destroy();
    header("location: login.php");
    exit;
  }
}
$user = $_SESSION['username']; 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sharnbasva University | CIE Project</title>
    <link rel="icon" type="image/x-icon" href="./Asset/img/sb.png">
    <link href="./Asset/css/bootstrap.css" rel="stylesheet">
    <link href="./Asset/css/fontAwesome.css" rel="stylesheet">
    <link href="./Asset/css/style.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <img src="./Asset/img/header-removebg-preview.png" class="img-fluid w-100" alt="..." >
    <div class="container-fluid mt-2">
        <div class="row">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="col-md-3 border rounded-4 bg-white">
                <div class="flex-shrink-0 p-4" >
                    <a href="index" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                      <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
                      <span class="fs-5 fw-semibold">Sharnbasva University</span>
                    </a>
                    <ul class="list-unstyled ps-0">

                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                            Home
                        </button>
                        <div class="collapse" id="home-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="index" class="link-dark d-inline-flex text-decoration-none rounded">Overview</a></li>
                          </ul>
                        </div>
                      </li>

                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#Course-collapse" aria-expanded="false">
                            Course 
                        </button>
                        <div class="collapse" id="Course-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="courseView" class="link-dark d-inline-flex text-decoration-none rounded">View Courses</a></li>
                          </ul>
                        </div>
                      </li>

                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#Student-collapse" aria-expanded="false">
                            Student
                        </button>
                        <div class="collapse" id="Student-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="studentView" class="link-dark d-inline-flex text-decoration-none rounded">View Students</a></li>
                          </ul>
                        </div>
                      </li>

                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#CIE-collapse" aria-expanded="false">
                            Marks Entry
                        </button>
                        <div class="collapse" id="CIE-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="CIE" class="link-dark d-inline-flex text-decoration-none rounded">CIE</a></li>
                          </ul>
                        </div>
                      </li>

                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#Report-collapse" aria-expanded="false">
                            Report
                        </button>
                        <div class="collapse" id="Report-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="reportGen" class="link-dark d-inline-flex text-decoration-none rounded">Add...</a></li>
                          </ul>
                        </div>
                      </li>

                      <li class="border-top my-3"></li>
                      <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                          Account
                        </button>
                        <div class="collapse" id="account-collapse">
                          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="resetPass" class="link-dark d-inline-flex text-decoration-none rounded">Reset Password</a></li>
                            <li><a href="logout" class="link-dark d-inline-flex text-decoration-none rounded">Logout</a></li>
                          </ul>
                        </div>
                      </li>

                    </ul>
                  </div>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="col-md-8 border rounded-4 bg-white p-2">
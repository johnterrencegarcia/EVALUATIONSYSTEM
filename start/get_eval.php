<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">


    <title>eval Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel=" stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">
    <?php
    session_start();
    $userID = $_SESSION['user_id'];

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role'])) {
        header('location:../index.php');
        exit();
    } else {
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role']) && $_SESSION['admin_role'] !== 'Admin') {
        header('location:../index.php');
        exit();
    } else {
    }

    if (isset($_SESSION['success_msg'])) {
        $success_msg = $_SESSION['success_msg'];
        // Unset session variable to prevent displaying the message again on page refresh
        unset($_SESSION['success_msg']);

        // Display success message using SweetAlert JS
    ?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end', // Bottom right
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            });
        </script>
    <?php
    }
    ?>


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #00008B;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admindashboard.php">
                <div class="sidebar-brand-icon ">
                    <!-- Insert your logo here -->
                    <img src="../assets/img/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                </div>
                <div class="sidebar-brand-text mx-2">AISAT DAU <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../start/admindashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Items -->
            <li class="nav-item">
                <a class="nav-link" href="admincourse.php">
                    <i class="fas fa-fw fa fa-book"></i>
                    <span>Course</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminsubject.php">
                    <i class="fas fa-fw fas fa-clipboard"></i>
                    <span>Subject</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminsection.php">
                    <i class="fas fa-fw fa fa-folder"></i>
                    <span>Section</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminfaculty.php">
                    <i class="fas fa-fw fa fa-graduation-cap"></i>
                    <span>Faculty</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminstudents.php">
                    <i class="fas fa-fw fa fa-graduation-cap"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminquestion.php">
                    <i class="bx bxs-food-menu"></i>
                    <span>Questionaire</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminevalstatus.php">
                    <i class="bx bxs-food-menu"></i>
                    <span>Evaluation Status</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminautorize.php">
                    <i class="bx bxs-lock"></i>
                    <span>Access Control</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php
                                                                                            if (isset($_SESSION['admin_role'])) {
                                                                                                $userName = $_SESSION['admin_role'];
                                                                                                echo 'Welcome, ' . $userName . '!';
                                                                                            }
                                                                                            ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <style>

                </style>
                <div class="modal fade rounded" id="addfacultyModal" tabindex="-1" role="dialog" aria-labelledby="addfacultyModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background-color: #00008B;">
                                <h5 class="modal-title" id="addfacultyModalLabel">Add Faculty</h5>
                                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="../code/add_faculty.php" enctype="multipart/form-data" id="facultyForm">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="name-f">First Name</label>
                                                <input type="text" class="form-control" name="fname" id="name-f" placeholder="Enter First Name" required>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="name-l">Last Name</label>
                                                <input type="text" class="form-control" name="lname" id="name-l" placeholder="Enter Last Name" required>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="sex">Gender</label>
                                                <select id="sex" name="sex" class="form-control browser-default custom-select">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="tel">Contact No</label>
                                                <input type="tel" name="phone" class="form-control" id="tel" placeholder="Enter Your Contact Number" required>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Locality/House/Street No" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="photoUpload" class="form-label">Upload Photo:</label>
                                                <input type="file" class="form-control" id="photoUpload" name="photoUpload" accept="image/*" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary" name="addFaculty">Add Faculty</button>
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Evaluation Data Dashboard</h1>
                    </div>
                    <?php
                    include '../assets/connection/connection.php';

                    // Check if the faculty_id is provided in the URL
                    if (isset($_GET['id'])) {
                        $faculty_id = $_GET['id'];

                        // Query to retrieve evaluations along with subject description
                        $query = "SELECT e.evaluation_id, e.subject_id, s.subject_name, s.discription, e.schoolyear, e.semester, e.rating_avg, e.date 
              FROM evaluation_tbl e
              INNER JOIN subject_tbl s ON e.subject_id = s.subject_id
              WHERE e.faculty_id = $faculty_id";

                        // Execute the query
                        $result = mysqli_query($conn, $query);

                        // Check for errors
                        if (!$result) {
                            // Display error message
                            echo "Error: " . mysqli_error($conn);
                        } else {
                            // Check if there are evaluations found
                            if (mysqli_num_rows($result) > 0) {
                    ?>
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-2 text-primary"><b>Evaluations</b></h5>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Evaluation ID</th>
                                                        <th>Subject Name</th>
                                                        <th>Description</th>
                                                        <th>School Year</th>
                                                        <th>Semester</th>
                                                        <th>Average Rating</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Loop through each evaluation record
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $row['evaluation_id']; ?></td>
                                                            <td><?= $row['subject_name']; ?></td>
                                                            <td><?= $row['discription']; ?></td>
                                                            <td><?= $row['schoolyear']; ?></td>
                                                            <td><?= $row['semester']; ?></td>
                                                            <td><?= $row['rating_avg']; ?></td>
                                                            <td><?= $row['date']; ?></td>
                                                            <td>
                                                                <a href="./get_data.php?id=<?= $row['evaluation_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            } else {
                                // No evaluations found
                                echo "<p>No evaluations found for the provided faculty.</p>";
                            }
                        }
                    } else {
                        // No faculty_id provided in the URL
                        echo "<p>No faculty ID provided.</p>";
                    }
                    ?>



                    <!-- Pagination links -->

                </div>
            </div>
        </div>



        <?php
        if (isset($_SESSION['error_message'])) {
        ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '<?php echo $_SESSION['error_message']; ?>',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php
            unset($_SESSION['error_message']); // Clear the session variable
        }

        // Display success message if exists
        if (isset($_SESSION['success_message'])) {
        ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '<?php echo $_SESSION['success_message']; ?>',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php
            unset($_SESSION['success_message']); // Clear the session variable
        }
        ?>
        <!-- Content Row -->


        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">

            </div>

            <!-- Pie Chart -->

        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->



        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->

    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
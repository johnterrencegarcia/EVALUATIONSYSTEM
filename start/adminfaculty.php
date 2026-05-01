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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

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
    <style>
        #content-wrapper {
            overflow-y: auto;
            /* Enable vertical scrolling */
            max-height: calc(100vh - 56px);
            /* Adjust the maximum height to fit the viewport minus the height of the top bar */
        }
    </style>

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
                        <h1 class="h3 mb-0 text-gray-800">Faculty Dashboard</h1>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-2 text-primary"><b>Manage Course</b></h5>
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class='bx bx-search' style="height: 24px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="search-Input" name="search" placeholder="Search">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addfacultyModal">
                                            <i class="bx bxs-user-plus" style="border-radius: 100px;"></i> Add Faculty
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-no-border" style="margin-top: 10px; width: 100%;">
                                    <thead>
                                        <tr style="color: black; border-radius: 100px;">
                                            <th style="width: 5%; text-align: center;">Id</th>
                                            <th style="width: 10%; text-align: center;">Photo</th>
                                            <th style="width: 9%; text-align: center;">First name</th>
                                            <th style="width: 8%; text-align: center;">Last name</th>
                                            <th style="width: 20%; text-align: center;">Email</th>
                                            <th style="width: 8%; text-align: center;">Gender</th>
                                            <th style="width: 25%; text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="outputfaculty">
                                        <?php
                                        include '../assets/connection/connection.php';

                                        // Pagination parameters
                                        $records_per_page = 5; // Number of records per page
                                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

                                        // Calculate the starting record index for the current page
                                        $start_from = ($current_page - 1) * $records_per_page;

                                        // Query to retrieve records for the current page
                                        $query = "SELECT * FROM faculty_tbl LIMIT $start_from, $records_per_page";
                                        $query_run = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            foreach ($query_run as $row) {
                                        ?>
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;"><?= $row['faculty_id']; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <img src="<?= $row['photo']; ?>" alt="Faculty Photo" width="100" height="100" style="border-radius: 50%;">
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;"><?= $row['firstname']; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;"><?= $row['lastname']; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;"><?= $row['email']; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;"><?= $row['gender']; ?></td>
                                
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <a href="../start/get_eval.php?id=<?= $row['faculty_id']; ?>">
                                                            <button type="button" name="view-faculty" value="<?= $row['faculty_id']; ?>" class="btn btn-primary btn-sm">
                                                                <i class='bx bx-show'></i> View Evaluation <!-- View icon -->
                                                            </button>
                                                        </a>
                                                        <button type="button" name="delete-faculty" value="<?= $row['faculty_id']; ?>" class="btn btn-danger btn-sm" onclick="deletefaculty(<?= $row['faculty_id']; ?>)">
                                                            <i class='bx bx-trash'></i> Delete<!-- Delete icon -->
                                                        </button>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='9' class='text-center'>No records found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Pagination links -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="pagination justify-content-center">
                                            <?php
                                            $total_records_query = "SELECT COUNT(*) AS total_records FROM faculty_tbl";
                                            $total_records_result = mysqli_query($conn, $total_records_query);
                                            $total_records = mysqli_fetch_assoc($total_records_result)['total_records'];
                                            $total_pages = ceil($total_records / $records_per_page);

                                            // Previous page link
                                            if ($current_page > 1) {
                                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
                                            }

                                            // Page numbers
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                            }

                                            // Next page link
                                            if ($current_page < $total_pages) {
                                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .search-results {
                            max-height: 0;
                            overflow: hidden;
                            transition: max-height 0.3s ease-in-out;
                            /* Smooth transition */
                        }
                    </style>
                    <script>
                        document.getElementById('search-Input').addEventListener('input', function() {
                            const searchInputValue = this.value.trim();

                            // Send an AJAX request to the backend PHP script with the search query
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    // Update the table body with the search results
                                    const outputCourse = document.getElementById('outputfaculty');
                                    outputfaculty.style.opacity = '0'; // Set opacity to 0 for smooth fade out
                                    outputfaculty.style.pointerEvents = 'none'; // Disable pointer events during transition

                                    setTimeout(() => {
                                        outputfaculty.innerHTML = xhr.responseText;
                                        outputfaculty.style.opacity = '1'; // Set opacity to 1 for smooth fade in
                                        outputfaculty.style.pointerEvents = 'auto'; // Enable pointer events after transition
                                    }, 300); // Adjust the delay as needed for smoother animation
                                }
                            };
                            xhr.open('POST', '../code/search_faculty.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.send('facultyName=' + searchInputValue);
                        });
                    </script>
                    <!-- to get course id validation-->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                    <script>
                        function deletefaculty(facultyId) {
                            // Display SweetAlert2 confirmation dialog
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You are about to delete this course.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Send AJAX request to delete_course.php
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === XMLHttpRequest.DONE) {
                                            if (xhr.status === 200) {
                                                // Show success message
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: 'The course has been deleted.',
                                                    icon: 'success'
                                                }).then(() => {
                                                    // Reload the page after successful deletion
                                                    window.location.reload();
                                                });
                                            } else {
                                                // Show error message
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: 'Failed to delete the course. Please try again later.',
                                                    icon: 'error'
                                                });
                                            }
                                        }
                                    };
                                    xhr.open('POST', '../code/delete_faculty.php', true);
                                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                    xhr.send('faculty_id=' + facultyId);
                                }
                            });
                        }
                    </script>
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
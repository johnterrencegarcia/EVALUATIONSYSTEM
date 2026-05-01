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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" rel=" stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel=" stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../start/js/chartmaker.js" rel="stylesheet">
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
                <div class="sidebar-brand-text mx-2">FES SYSTEM <sup></sup></div>
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
                <nav class="navbar navbar-expand navbar-light bg-light topbar mb-4 static-top shadow">

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include '../assets/connection/connection.php';
                                                $query = "SELECT login_id FROM login_tbl ORDER BY login_id";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo $row;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Students</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php
                                                include '../assets/connection/connection.php';
                                                $query = "SELECT student_id FROM student_tbl ORDER BY student_id";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo $row;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-graduation-cap fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Course</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php
                                                                                                    include '../assets/connection/connection.php';
                                                                                                    $query = "SELECT id FROM course_tbl ORDER BY id";
                                                                                                    $query_run = mysqli_query($conn, $query);
                                                                                                    $row = mysqli_num_rows($query_run);
                                                                                                    echo $row;
                                                                                                    ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-book fa-2x text-gray-300"></i>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Subject
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php
                                                        include '../assets/connection/connection.php';
                                                        $query = "SELECT id FROM subject_tbl ORDER BY id";
                                                        $query_run = mysqli_query($conn, $query);
                                                        $row = mysqli_num_rows($query_run);
                                                        echo $row;
                                                        ?></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Section</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include '../assets/connection/connection.php';
                                                $query = "SELECT section_id FROM section_tbl ORDER BY section_id";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo $row;
                                                ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Faculty</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php
                                                include '../assets/connection/connection.php';
                                                $query = "SELECT faculty_id FROM faculty_tbl ORDER BY faculty_id";
                                                $query_run = mysqli_query($conn, $query);
                                                $row = mysqli_num_rows($query_run);
                                                echo $row;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-graduation-cap fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Evaluation</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                    include '../assets/connection/connection.php';
                                                    $query = "SELECT evaluation_id FROM evaluation_tbl ORDER BY evaluation_id";
                                                    $query_run = mysqli_query($conn, $query);
                                                    $totaleval = mysqli_num_rows($query_run);
                                                    echo $totaleval;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Assuming you have established a database connection already
                        include '../assets/connection/connection.php';

                        // SQL query to select data from the active_tbl
                        $query = "SELECT * FROM active_tbl LIMIT 1"; // Assuming you only have one active record

                        $result = mysqli_query($conn, $query);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the data as an associative array
                            $row = mysqli_fetch_assoc($result);

                            // Assign fetched data to variables
                            $school_year = $row['school_year'];
                            $semester = $row['semester'];
                            $status = $row['status'];
                        } else {
                            // Handle error if the query fails
                            echo "Error fetching data: " . mysqli_error($conn);
                        }
                        ?>

                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card border-left-info shadow" style="height: auto;">
                                <div class="card-body p-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-4">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Academic Year
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $school_year; ?></div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Semester
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $semester; ?></div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Evaluation Status
                                            </div>
                                            <?php if ($status === 'In Progress') : ?>
                                                <div class="h6 mb-0 font-weight-bold text-success blink">
                                                    <?php echo $status; ?>
                                                </div>
                                            <?php elseif ($status === 'Finished') : ?>
                                                <div class="h6 mb-0 font-weight-bold text-danger">
                                                    <?php echo $status; ?>
                                                </div>
                                            <?php else : ?>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $status; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            @keyframes blink {
                                0% {
                                    opacity: 1;
                                }

                                50% {
                                    opacity: 0;
                                }

                                100% {
                                    opacity: 1;
                                }
                            }

                            .blink {
                                animation: blink 1s infinite;
                            }
                        </style>




                    </div>

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
                <?php
                include '../assets/connection/connection.php';

                function fetchCount($table, $conn, $condition = '')
                {
                    $query = "SELECT COUNT(*) AS count FROM $table $condition";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        return $row['count'];
                    } else {
                        return 0; // Return 0 if there's an error or no rows found
                    }
                }

                // Fetch counts for each table
                $totalUsers = fetchCount('login_tbl', $conn);
                $totalStudents = fetchCount('student_tbl', $conn);
                $totalCourses = fetchCount('course_tbl', $conn);
                $totalSubjects = fetchCount('subject_tbl', $conn);
                $totalSections = fetchCount('section_tbl', $conn);
                $totalFaculty = fetchCount('faculty_tbl', $conn);
                $totalEvaluations = fetchCount('evaluation_tbl', $conn);
                $totalRegistered = fetchCount('accessid_tbl', $conn, 'WHERE status = 1');
                $totalNotRegistered = fetchCount('accessid_tbl', $conn, 'WHERE status = 0');
                ?>
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div>
                                    <canvas id="overviewChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div>
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        // Data for the bar chart
                        const overviewChartData = {
                            labels: ['Users', 'Courses', 'Subjects', 'Sections', 'Evaluations'],
                            datasets: [{
                                label: 'Counts',
                                data: [
                                    <?php echo $totalUsers; ?>,
                                    <?php echo $totalCourses; ?>,
                                    <?php echo $totalSubjects; ?>,
                                    <?php echo $totalSections; ?>,
                                    <?php echo $totalEvaluations; ?>
                                ],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 205, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(54, 162, 235, 1)'
                                ],
                                borderWidth: 1
                            }]
                        };

                        // Config for the bar chart
                        const overviewChartConfig = {
                            type: 'bar',
                            data: overviewChartData,
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false, // Hide the legend
                                    },
                                    title: {
                                        display: true,
                                        text: 'Overview'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) {
                                                    label += ': ';
                                                }
                                                if (context.parsed.y !== null) {
                                                    label += context.parsed.y;
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        // Render the bar chart
                        const ctxOverview = document.getElementById('overviewChart').getContext('2d');
                        const overviewChart = new Chart(ctxOverview, overviewChartConfig);

                        // Data for the doughnut chart
                        const doughnutChartData = {
                            labels: ['Registered student', 'Not Registered Student'],
                            datasets: [{
                                label: 'Counts',
                                data: [
                                    <?php echo $totalRegistered; ?>,
                                    <?php echo $totalNotRegistered; ?>
                                ],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)', // Blue
                                    'rgba(255, 99, 132, 0.2)' // Red
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)', // Blue
                                    'rgba(255, 99, 132, 1)' // Red
                                ],
                                borderWidth: 1
                            }]
                        };

                        // Config for the doughnut chart
                        const doughnutChartConfig = {
                            type: 'doughnut',
                            data: doughnutChartData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Registration Status'
                                    }
                                }
                            }
                        };

                        // Render the doughnut chart
                        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
                        const doughnutChart = new Chart(ctxDoughnut, doughnutChartConfig);
                    });
                </script>


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

</body>

</html>
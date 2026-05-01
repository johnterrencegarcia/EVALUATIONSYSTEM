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
                        <h1 class="h3 mb-0 text-gray-800">Evaluation Data </h1>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-4 text-primary">Rating Legend</h5>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-danger text-white shadow">
                                            <div class="card-body">
                                                1. STRONGLY AGREE
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-warning text-white shadow">
                                            <div class="card-body">
                                                2. DISAGREE
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-info text-white shadow">
                                            <div class="card-body">
                                                3. UNCERTAIN
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="card bg-primary text-white shadow">
                                            <div class="card-body">
                                                4. AGREE
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-success text-white shadow">
                                            <div class="card-body">
                                                5. STRONGLY AGREE
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        /* Custom CSS for disabled radio buttons */
                        .disabled-radio {
                            opacity: 100%;
                            /* Reduce opacity to visually indicate disabled state */
                            cursor: not-allowed;
                            /* Show not-allowed cursor when hovering */
                        }
                    </style>

                    <div class="row">
                        <!-- Big Box (Left Column) -->
                        <div class="col-lg-8">
                            <div class="bg-light "> <!-- Add your content here -->

                                <p>
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Questionnaire</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="max-width: 550px; width: 600px;">Question</th>
                                                <th>Strongly Disagree</th>
                                                <th>Disagree</th>
                                                <th>Uncertain</th>
                                                <th>Agree</th>
                                                <th>Strongly Agree</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        include '../assets/connection/connection.php';
                                        // Check if evaluation_id is provided in the URL
                                        if (isset($_GET['id'])) {
                                            $evaluation_id = $_GET['id'];
                                            $sql_feedback = "SELECT * FROM feedback_tbl WHERE evaluation_id = $evaluation_id";
                                            $result_feedback = mysqli_query($conn, $sql_feedback);
                                            // Fetch questions from questions_tbl
                                            $sql = "SELECT question_id, question FROM questions_tbl ORDER BY question_id";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                $primary_id = $row["question_id"];
                                                $question = $row["question"];
                                                echo "<tr>";
                                                echo "<td>$question</td>"; // Display the question text
                                                // Check if there is feedback for this question and populate radio buttons accordingly
                                                if (mysqli_num_rows($result_feedback) > 0) {
                                                    while ($row_feedback = mysqli_fetch_assoc($result_feedback)) {
                                                        if ($row_feedback['question_id'] == $primary_id) {
                                                            $answer = $row_feedback['answer'];
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                // Add 'disabled' class to style the radio buttons when they are disabled
                                                                echo "<td data-label='" . ($i == $answer ? 'checked' : '') . "'><input type='radio' class='disabled-radio' name='question$primary_id' value='$i' " . ($i == $answer ? 'checked' : '') . " required  disabled></td>";
                                                            }
                                                        }
                                                    }
                                                    mysqli_data_seek($result_feedback, 0); // Reset the pointer of $result_feedback
                                                } else {
                                                    // If no feedback found, display empty radio buttons with 'disabled' class
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo "<td data-label=''><input type='radio' name='question$primary_id' value='$i' required disabled></td>";
                                                    }
                                                }
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "Evaluation ID not provided in the URL.";
                                        }
                                        mysqli_close($conn);
                                        ?>

                                    </table>
                                    <div class="form-group">
                                        <label for="comment" class="label-question">Do you have any suggestions or opinions? Write your feedback.</label>
                                        <?php
                                        include '../assets/connection/connection.php';
                                        // Check if evaluation_id is provided in the URL
                                        if (isset($_GET['id'])) {
                                            $evaluation_id = $_GET['id'];
                                            // Retrieve comment from evaluation_tbl based on evaluation_id
                                            $sql_comment = "SELECT comment FROM evaluation_tbl WHERE evaluation_id = $evaluation_id";
                                            $result_comment = mysqli_query($conn, $sql_comment);
                                            // Check if comment exists
                                            if (mysqli_num_rows($result_comment) > 0) {
                                                $row_comment = mysqli_fetch_assoc($result_comment);
                                                $comment = $row_comment['comment'];
                                                // Echo the textarea with the retrieved comment
                                                echo "<textarea id='comment' name='comment' class='form-control' rows='3' required readonly>$comment</textarea>";
                                            } else {
                                                echo "<textarea id='comment' name='comment' class='form-control' rows='3' required readonly></textarea>";
                                            }
                                        } else {
                                            echo "Evaluation ID not provided in the URL.";
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Two Column Boxes (Right Column) -->
                        <div class="col-lg-4">
                            <div class="bg-light mb-3" style="padding-top: 4rem;"> <!-- Add your content here -->
                                <h3>Evaluation Details</h3>
                                <?php
                                include '../assets/connection/connection.php';
                                // Check if evaluation_id is provided in the URL
                                if (isset($_GET['id'])) {
                                    $evaluation_id = $_GET['id'];
                                    // Retrieve data from evaluation_tbl based on evaluation_id
                                    $sql_evaluation = "SELECT rating_avg, comment, date, schoolyear, semester FROM evaluation_tbl WHERE evaluation_id = $evaluation_id";
                                    $result_evaluation = mysqli_query($conn, $sql_evaluation);
                                    // Check if evaluation record exists
                                    if (mysqli_num_rows($result_evaluation) > 0) {
                                        $row_evaluation = mysqli_fetch_assoc($result_evaluation);
                                        $rating_avg = $row_evaluation['rating_avg'];
                                        $comment = $row_evaluation['comment'];
                                        $date = $row_evaluation['date'];
                                        $schoolyear = $row_evaluation['schoolyear'];
                                        $semester = $row_evaluation['semester'];

                                        // Determine the descriptive rating based on the numeric average rating
                                        if ($rating_avg == 5) {
                                            $rating = "Excellent";
                                        } else if ($rating_avg >= 4.5 && $rating_avg < 5) {
                                            $rating = "Very Good";
                                        } else if ($rating_avg >= 4 && $rating_avg < 4.5) {
                                            $rating = "Good";
                                        } else if ($rating_avg >= 3.5 && $rating_avg < 4) {
                                            $rating = "Above Average";
                                        } else if ($rating_avg >= 3 && $rating_avg < 3.5) {
                                            $rating = "Average";
                                        } else if ($rating_avg >= 2.5 && $rating_avg < 3) {
                                            $rating = "Below Average";
                                        } else if ($rating_avg >= 2 && $rating_avg < 2.5) {
                                            $rating = "Poor";
                                        } else if ($rating_avg >= 1 && $rating_avg < 2) {
                                            $rating = "Very Poor";
                                        } else {
                                            $rating = "Unsatisfactory";
                                        }

                                        // Display evaluation details
                                        echo "<p><strong>Average Rating:</strong> $rating_avg</p>";
                                        echo "<p><strong>Rating:</strong> $rating</p>";
                                        echo "<p><strong>School Year:</strong> $schoolyear</p>";
                                        echo "<p><strong>Semester:</strong> $semester</p>";
                                        echo "<p><strong>Date:</strong> $date</p>";
                                    } else {
                                        echo "<p>Evaluation not found.</p>";
                                    }
                                } else {
                                    echo "<p>Evaluation ID not provided in the URL.</p>";
                                }
                                mysqli_close($conn);
                                ?>
                            </div>


                            <div class="bg-light p-3"> <!-- Add your content here -->
                                <h3>Respond Chart</h3>
                                <canvas id="responseChart" width="400" height="200"></canvas>
                            </div>

                            <?php
                            include '../assets/connection/connection.php';

                            // Check if evaluation_id is provided in the URL
                            if (isset($_GET['id'])) {
                                $evaluation_id = $_GET['id'];

                                // Retrieve evaluation details from evaluation_tbl
                                $sql_evaluation = "SELECT rating_avg, comment, date, schoolyear, semester FROM evaluation_tbl WHERE evaluation_id = $evaluation_id";
                                $result_evaluation = mysqli_query($conn, $sql_evaluation);

                                if (mysqli_num_rows($result_evaluation) > 0) {
                                    // Fetch data from feedback_tbl based on evaluation_id
                                    $sql_feedback = "SELECT answer, COUNT(*) as count FROM feedback_tbl WHERE evaluation_id = $evaluation_id GROUP BY answer";
                                    $result_feedback = mysqli_query($conn, $sql_feedback);

                                    $response_counts = array_fill(1, 5, 0); // Initialize an array to store counts for each response

                                    while ($row = mysqli_fetch_assoc($result_feedback)) {
                                        $response_counts[$row['answer']] = $row['count'];
                                    }

                                    // JavaScript for rendering the chart
                                    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
                                    echo "<script>
                var ctx = document.getElementById('responseChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Strongly Disagree', 'Disagree', 'Uncertain', 'Agree', 'Strongly Agree'],
                        datasets: [{
                            label: 'Response Count',
                            data: [" . implode(',', $response_counts) . "],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 205, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>";
                                } else {
                                    echo "<p>Evaluation not found.</p>";
                                }
                            } else {
                                echo "<p>Evaluation ID not provided in the URL.</p>";
                            }

                            mysqli_close($conn);
                            ?>


                        </div>
                    </div>
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
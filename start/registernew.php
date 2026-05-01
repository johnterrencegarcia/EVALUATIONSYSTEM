<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Evaluation System</title>
    <link rel="icon" type="image/png" href="/images/systems-plus-computer-college-logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --background: #FAFAFA;
            --foreground: #0F172A;
            --muted: #F1F5F9;
            --muted-foreground: #64748B;
            --accent: #0052FF;
            --accent-secondary: #4D7CFF;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --ring: #0052FF;
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.08);
            --shadow-xl: 0 20px 25px rgba(0,0,0,0.1);
            --shadow-accent: 0 4px 14px rgba(0,82,255,0.25);
            --shadow-accent-lg: 0 8px 24px rgba(0,82,255,0.35);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Abstract Background Glows */
        .bg-glow {
            position: absolute;
            width: 800px;
            height: 800px;
            background: var(--accent);
            opacity: 0.05;
            filter: blur(150px);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }
        .bg-glow-1 { top: -300px; left: -300px; }
        .bg-glow-2 { bottom: -300px; right: -300px; background: var(--accent-secondary); opacity: 0.04; }

        .login-wrapper {
            width: 100%;
            max-width: 550px;
            padding: 24px;
            z-index: 10;
        }

        .login-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            padding: 48px 40px;
            position: relative;
            transition: all 0.3s ease-out;
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(28px);
        }

        .login-card:hover {
            box-shadow: 0 25px 40px rgba(0,0,0,0.12);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header img {
            width: 80px;
            margin-bottom: 24px;
        }

        .login-title {
            font-family: 'Calistoga', Georgia, serif;
            font-size: 2.25rem;
            font-weight: normal;
            line-height: 1.15;
            margin-bottom: 12px;
            color: var(--foreground);
            letter-spacing: -0.02em;
        }

        .gradient-text {
            background: linear-gradient(to right, var(--accent), var(--accent-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: var(--muted-foreground);
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 24px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .form-control, select.form-control {
            width: 100%;
            height: 56px;
            padding: 0 16px;
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--foreground);
            transition: all 0.2s ease-out;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(0, 82, 255, 0.15);
        }

        .form-control::placeholder {
            color: rgba(100, 116, 139, 0.5);
        }

        /* File Upload Styling */
        input[type="file"].form-control {
            padding: 10px;
            height: auto;
            min-height: 56px;
        }
        
        input[type="file"]::file-selector-button {
            border-radius: 8px;
            padding: 0 16px;
            height: 36px;
            cursor: pointer;
            background-color: var(--muted);
            color: var(--foreground);
            border: 1px solid var(--border);
            margin-right: 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease-out;
        }
        
        input[type="file"]::file-selector-button:hover {
            background-color: var(--border);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 32px;
            gap: 16px;
        }

        .navigation-buttons.right-only {
            justify-content: flex-end;
        }

        .btn-primary {
            height: 56px;
            padding: 0 24px;
            background: linear-gradient(to right, var(--accent), var(--accent-secondary));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease-out;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-accent-lg);
            filter: brightness(1.05);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .btn-secondary {
            height: 56px;
            padding: 0 24px;
            background: transparent;
            color: var(--foreground);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease-out;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .btn-secondary:hover {
            background-color: var(--muted);
            border-color: rgba(0, 82, 255, 0.3);
        }

        .btn-secondary:active {
            transform: scale(0.98);
        }

        .form-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--muted-foreground);
        }

        .form-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .form-footer a:hover {
            color: var(--accent-secondary);
            text-decoration: underline;
        }

        .step {
            display: none;
            animation: fadeIn 0.4s ease-out forwards;
        }

        .step.active {
            display: block;
        }

        /* Step Indicators */
        .step-indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 32px;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--border);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background-color: var(--accent);
            width: 24px;
            border-radius: 4px;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(28px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 24px;
            }
            .login-title {
                font-size: 1.75rem;
            }
            .navigation-buttons {
                flex-direction: column-reverse;
            }
            .btn-primary, .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <?php
    @include '../assets/connection/connection.php';

    if (isset($_POST['Submit-R'])) {
        $uid = mysqli_real_escape_string($conn, $_POST['uid']);
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $yearlevel = mysqli_real_escape_string($conn, $_POST['yearlevel']);
        $course_id = mysqli_real_escape_string($conn, $_POST['course']);
        $section_id = mysqli_real_escape_string($conn, $_POST['section']);
        $role = "Student";

        // Check if the user already exists
        $select = "SELECT * FROM login_tbl WHERE uid = '$uid'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            showErrorAndRedirect('User already exists!');
        } else {
            // Check if the student ID exists and is not registered
            $checkStudentIdQuery = "SELECT * FROM accessid_tbl WHERE student_id = '$uid' AND status = 0";
            $checkStudentIdResult = mysqli_query($conn, $checkStudentIdQuery);

            if (mysqli_num_rows($checkStudentIdResult) == 0) {
                showErrorAndRedirect('Invalid or already registered student ID!');
            } elseif ($pass != $cpass) {
                showErrorAndRedirect('Passwords do not match!');
            } else {
                // Check if the file is uploaded and no errors occurred
                if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
                    $target_dir = "../uploads/students/";
                    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a valid image
                    $check = getimagesize($_FILES["photo"]["tmp_name"]);
                    if ($check !== false) {
                        // File is an image
                        $uploadOk = 1;
                    } else {
                        showErrorAndRedirect('File is not an image.');
                    }

                    // Check file size
                    if ($_FILES["photo"]["size"] > 500000) {
                        showErrorAndRedirect('File is too large.');
                    }

                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        showErrorAndRedirect('Only JPG, JPEG, PNG & GIF files are allowed.');
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        showErrorAndRedirect('File was not uploaded.');
                    } else {
                        // Attempt to move the uploaded file to the target directory
                        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                            // File uploaded successfully, proceed with database insertion
                            $photo = $target_file;

                            $sql_student = "INSERT INTO student_tbl (firstname, lastname, email, gender, yearlevel, photo, course_id, section_id, password, student_id) 
                        VALUES ('$firstname', '$lastname', '$email', '$gender', '$yearlevel', '$photo', '$course_id', '$section_id', '$pass', '$uid')";

                            // Attempt insert query execution for login_tbl
                            $sql_login = "INSERT INTO login_tbl (uid, password, role) VALUES ('$uid', '$pass', '$role')";

                            if (mysqli_query($conn, $sql_student) && mysqli_query($conn, $sql_login)) {
                                // Update the status in accessid_tbl
                                $updateStatusQuery = "UPDATE accessid_tbl SET status = 1, time = NOW() WHERE student_id = '$uid'";
                                mysqli_query($conn, $updateStatusQuery);

                                // Display success message using SweetAlert2 and redirect
                                showSuccessAndRedirect('You have successfully registered.');
                            } else {
                                showErrorAndRedirect("ERROR: Could not execute queries. " . mysqli_error($conn));
                            }
                        } else {
                            showErrorAndRedirect('There was an error uploading your file.');
                        }
                    }
                } else {
                    showErrorAndRedirect('No file uploaded or an error occurred during file upload.');
                }
            }
        }
    }

    function showErrorAndRedirect($errorMessage)
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>";
        echo "Swal.fire({";
        echo "  icon: 'error',";
        echo "  title: 'Registration failed!',";
        echo "  text: '$errorMessage',";
        echo "  position: 'top',";
        echo "  showConfirmButton: false,";
        echo "  timer: 1800";
        echo "}).then(() => {";
        echo "  window.location.href = './registernew.php';";
        echo "});";
        echo "</script>";
        exit();
    }

    function showSuccessAndRedirect($successMessage)
    {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>";
        echo "Swal.fire({";
        echo "  icon: 'success',";
        echo "  title: 'Registration successful!',";
        echo "  text: '$successMessage',";
        echo "  position: 'top',";
        echo "  showConfirmButton: false,";
        echo "  timer: 1800";
        echo "}).then(() => {";
        echo "  window.location.href = '../index.php';";
        echo "});";
        echo "</script>";
        exit();
    }
    ?>

    <div class="login-wrapper">
        <form id="registration-form" action="" method="POST" enctype="multipart/form-data">
            <div class="login-card">
                
                <div class="login-header">
                    <img src="../assets/img/logo.png" alt="Logo">
                    <h1 class="login-title">AISAT CENTRAL INK <span class="gradient-text">DAU</span></h1>
                    <p class="login-subtitle">Join us to shape the leaders of tomorrow.</p>
                </div>

                <div class="step-indicators">
                    <div class="step-dot active" id="dot-0"></div>
                    <div class="step-dot" id="dot-1"></div>
                    <div class="step-dot" id="dot-2"></div>
                    <div class="step-dot" id="dot-3"></div>
                    <div class="step-dot" id="dot-4"></div>
                </div>

                <div class="login-content">
                    
                    <!-- Step 1 -->
                    <div class="step step-1 active">
                        <div class="step-title">Step 1: User ID</div>
                        
                        <div class="form-group">
                            <label for="uid">Student Number</label>
                            <input type="number" name="uid" class="form-control" required placeholder="Enter Student Number">
                        </div>
                        <div class="navigation-buttons right-only">
                            <button type="button" class="btn-primary" onclick="nextStep()">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step step-2">
                        <div class="step-title">Step 2: Password</div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" required placeholder="Confirm Password">
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn-primary" onclick="nextStep()">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step step-3">
                        <div class="step-title">Step 3: Basic Information</div>
                        
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control" required placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control" required placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Choose...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn-primary" onclick="nextStep()">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="step step-4">
                        <div class="step-title">Step 4: Academic Information</div>
                        
                        <div class="form-group">
                            <label for="yearlevel">Year Level</label>
                            <select name="yearlevel" class="form-control" required>
                                <option value="">Select Year Level</option>
                                <?php
                                include '../assets/connection/connection.php';
                                $query = "SELECT * FROM yearlevel_tbl";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['yearlevel']) . '">' . htmlspecialchars($row['yearlevel']) . '</option>';
                                }
                                mysqli_free_result($result);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select name="course" class="form-control" required>
                                <option value="">Select Course</option>
                                <?php
                                $query = "SELECT * FROM course_tbl";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['course_id'] . '">' . $row['discription'] . '</option>';
                                }
                                mysqli_free_result($result);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select name="section" class="form-control" required>
                                <option value="">Select Section</option>
                                <?php
                                $query = "SELECT * FROM section_tbl";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
                                }
                                mysqli_free_result($result);
                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="btn-primary" onclick="nextStep()">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="step step-5">
                        <div class="step-title">Step 5: Upload Photo</div>
                        
                        <div class="form-group">
                            <label for="photo">Profile Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="form-control" required>
                        </div>
                        <div class="navigation-buttons">
                            <button type="button" class="btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" name="Submit-R" class="btn-primary" id="add-button">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                        </div>
                    </div>

                    <div class="form-footer">
                        <p>Already have an account? <a href="../index.php">Login now</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('registration-form');
        const inputs = form.querySelectorAll('input, select');
        
        let currentStep = 0;

        function updateDots() {
            document.querySelectorAll('.step-dot').forEach((dot, index) => {
                if (index === currentStep) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((stepElement, index) => {
                stepElement.classList.remove('active');
                if (index === step) {
                    stepElement.classList.add('active');
                }
            });
            updateDots();
        }

        function nextStep() {
            const currentForm = document.querySelectorAll('.step')[currentStep];
            if (validateStep(currentForm)) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            currentStep--;
            showStep(currentStep);
        }

        function validateStep(formSection) {
            const inputs = formSection.querySelectorAll('input, select');
            for (let input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Validate each input field
            inputs.forEach((input) => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            // Validate file upload
            const fileInput = document.getElementById('photo');
            if (fileInput.files.length === 0) {
                alert('Please select a file to upload.');
                isValid = false;
            } else {
                const file = fileInput.files[0];
                const fileSize = file.size;
                const fileType = file.type;

                if (fileSize > 500000) {
                    alert('File is too large. Maximum file size is 500KB.');
                    isValid = false;
                }

                if (!['image/jpeg', 'image/png', 'image/gif'].includes(fileType)) {
                    alert('Only JPG, JPEG, PNG & GIF files are allowed.');
                    isValid = false;
                }
            }

            if (isValid) {
                form.submit();
            }
        });
    </script>
</body>
</html>
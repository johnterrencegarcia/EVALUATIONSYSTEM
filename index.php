<?php
session_start();
@include './assets/connection/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Faculty Evaluation System</title>
    <link rel="icon" type="image/png" href="/images/systems-plus-computer-college-logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
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
            overflow: hidden;
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
            max-width: 480px;
            padding: 24px;
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(28px);
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
        }

        .login-card:hover {
            box-shadow: 0 25px 40px rgba(0,0,0,0.12);
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
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
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .form-control {
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
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(0, 82, 255, 0.15);
        }

        .form-control::placeholder {
            color: rgba(100, 116, 139, 0.5);
        }

        .btn-primary {
            width: 100%;
            height: 56px;
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
            margin-top: 12px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-accent-lg);
            filter: brightness(1.05);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .btn-primary i {
            transition: transform 0.2s ease-out;
        }

        .btn-primary:hover i {
            transform: translateX(4px);
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

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 24px;
            }
            .login-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <?php
    if (isset($_POST['login'])) {
        $uid = trim(mysqli_real_escape_string($conn, $_POST['login_id']));
        $password = $_POST['password'];

        $select = "SELECT * FROM login_tbl WHERE uid = '$uid'";
        $result = mysqli_query($conn, $select);
        $row = mysqli_fetch_assoc($result);

        // verify if a user record exists 
        if ($row && $password === $row['password']) {
            // password matches
            if ($row['role'] == 'Admin') {
                $userID = $row['login_id'];
                $_SESSION['user_id'] = $userID;
                $_SESSION['admin_id'] = $row['uid'];
                $_SESSION['admin_role'] = $row['role'];
                $_SESSION['success_msg'] = 'Login successful!';

                // Redirect to Admin Dashboard
                echo "<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>";
                echo "Swal.fire({";
                echo "  icon: 'success',";
                echo "  title: 'Login successful!',";
                echo "  text: 'Redirecting to Admin Dashboard...',";
                echo "  showConfirmButton: false,";
                echo "  timer: 2000";
                echo "}).then(() => {";
                echo "  window.location.href = './start/admindashboard.php';";
                echo "});";
                echo "</script>";
                exit();
            } elseif ($row['role'] == 'Student') {
                $userID = $row['login_id'];
                $_SESSION['user_id'] = $userID;
                $_SESSION['user_studuid'] = $row['uid'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['success_msg'] = 'Login successful!';

                // Redirect to Student Dashboard
                echo "<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>";
                echo "Swal.fire({";
                echo "  icon: 'success',";
                echo "  title: 'Login successful!',";
                echo "  text: 'Redirecting to Student Dashboard...',";
                echo "  showConfirmButton: false,";
                echo "  timer: 2000";
                echo "}).then(() => {";
                echo "  window.location.href = './start/studentdashboard.php';";
                echo "});";
                echo "</script>";
                exit();
            } elseif ($row['role'] == 'Faculty') {
                $userID = $row['login_id'];
                $_SESSION['user_id'] = $userID;
                $_SESSION['user_facuid'] = $row['uid'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['success_msg'] = 'Login successful!';

                // Redirect to Faculty Dashboard (You need to create this file)
                echo "<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>";
                echo "Swal.fire({";
                echo "  icon: 'success',";
                echo "  title: 'Login successful!',";
                echo "  text: 'Redirecting to Faculty Dashboard...',";
                echo "  showConfirmButton: false,";
                echo "  timer: 2000";
                echo "}).then(() => {";
                echo "  window.location.href = './start/facultydashboard.php';";
                echo "});";
                echo "</script>";
                exit();
            }
        } else {
            // password does not match or user not found
            $error = 'Incorrect Student ID or password!';

            // SweetAlert JS for login failure
            echo "<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>";
            echo "Swal.fire({";
            echo "  icon: 'error',";
            echo "  title: 'Login failed!',";
            echo "  text: '$error',";
            echo "});";
            echo "</script>";
        }
    }
    ?>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <img src="./assets/img/logo.png" alt="Logo">
                <h1 class="login-title">AISAT CENTRAL INK <span class="gradient-text">DAU</span></h1>
                <p class="login-subtitle">Empowering minds through excellence. Blending service and innovation to shape leaders of tomorrow.</p>
            </div>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="login_id">ID Number</label>
                    <input type="number" id="login_id" name="login_id" class="form-control" required placeholder="Enter ID">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Enter Password">
                </div>
                <button type="submit" name="login" value="Login" class="btn-primary">
                    Log In <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                </button>
            </form>
            <div class="form-footer">
                <p>Don't have an account? <a href="./start/registernew.php">Sign up Now</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
<?php
session_start();
require_once 'config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // Debug information
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($user) {
    //$isPasswordValid = password_verify($password, $user['password']);
    if ($password === $user['password']) {
      //$_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      header("Location: index.php");
      exit();
    }
  }
  $error = "Invalid username or password";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login - Inward Gatepass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
        }
        .header {
            background-color: #212529;
            color: #ffd700;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .social-login {
            text-align: center;
            margin-top: 20px;
        }
        .social-login a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #333;
            margin: 0 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .social-login a:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <h3 style='text-align: start'>MIGP</h3>
            <div>
                <h4>INDIAN ORDNANCE FACTORIES</h4>
                <h5>CORDITE FACTORY ARUVANKADU</h5>
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Inward Gate Pass</h2>
            <h5 class="text-center mb-4">Login</h5>
            
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label">User ID</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                    <a href="forgot-password.php" class="float-end">Forgot password?</a>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </form>
            
            <div class="social-login">
                <p class="text-center text-muted">Or sign up with</p>
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="google"><i class="fab fa-google"></i></a>
                <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="github"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    </div><footer class="footer">
    <div class="container">
      <div class="text-center">
        <p class="mb-0">© <?php echo date('Y'); ?> CORDITE FACTORY ARUVANKADU. All rights reserved.</p>
        <p class="mb-0">An ISO 9001:2015 Certified Organization</p>
      </div>
    </div>
  </footer>

    <!-- Add Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
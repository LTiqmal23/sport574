<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        /* Login Page */
        .login-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-wrapper {
            width: 420px;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px 40px;
        }

        .login-wrapper h1 {
            font-size: 36px;
            font-family: 'Poppins';
            text-align: center;
        }

        .login-wrapper .input-box {
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            height: 100%;
            width: 100%;
            background-color: #d9d9d9;
            border: none;
            outline: none;
            border-radius: 40px;
            font-size: 16px;
            color: #000000;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: #828282;
        }

        .login-wrapper .login-btn {
            width: 100%;
            height: 45px;
            background: #FF8A1E;
            border: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #000000;
            font-weight: 600;
        }

        .login-wrapper .register-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0px 15px;

        }

        .register-link p a {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff0000;
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ff0000;
            border-radius: 5px;
            background-color: rgba(255, 0, 0, 0.1);
            font-weight: bold;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="login-body">
    <div class="login-wrapper">
        <form action="loginCheck.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" required>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
            </div>



            <button class="login-btn" type="submit">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="signUp.html">Register</a></p>
            </div>

            <?php
            session_start();
            if (isset($_SESSION['error_message'])) {
                echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
        </form>
    </div>
</body>

</html>
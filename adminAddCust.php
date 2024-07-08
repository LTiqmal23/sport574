<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Register Page */
        .register-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-wrapper {
            width: 900px;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 25px 30px;
            display: flex;
            gap: 3em;
        }

        .register-info {
            width: 80%;
        }

        .register-info h1 {
            font-family: 'Inter Black';
        }

        .register-icon {
            height: 70vh;
        }

        .register-wrapper .input-box {
            width: 100%;
            height: 30px;
            margin: 30px 0;
        }

        .register-wrapper .input-box input {
            height: 100%;
            width: 100%;
            background-color: #d9d9d9;
            border: none;
            outline: none;
            border-radius: 15px;
            font-size: 16px;
            color: #000000;
            padding: 20px 45px 20px 20px;
        }


        .register-btn {
            font-family: 'Inter Black';
            color: #000000;
            text-decoration: none;
            background-color: #FF8A1E;
            border-radius: 15px;
            padding: 10px 20px 10px 20px;
            outline: none;
            border: none;
        }

        .register-link p a {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="register-body">
    <div class="register-wrapper">
        <div>
            <img class="register-icon" src="resource/registerIcon.png">
        </div>

        <div class="register-info">
            <h1>
                Welcome to
                <br>SportFusion
            </h1>

            <p>come on and join us!</p>
            <br>
            <form action="adminRegister.php" method="post">
                <div class="input-box">
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>

                <div class="input-box">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>

                <div class="input-box">
                    <input type="text" id="address" name="address" placeholder="Address" required>
                </div>

                <div class="input-box">
                    <input type="text" id="phone" name="phone" placeholder="Phone Number" required>
                </div>

                <div class="input-box">
                    <input type="text" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Confirm Password" required>
                </div>

                <button class="register-btn" type="submit">SIGN UP</button>
            </form><br>
        </div>
    </div>
</body>

</html>
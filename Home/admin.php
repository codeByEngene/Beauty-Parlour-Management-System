<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn Page</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #f56a00;
            font-size: 28px;
        }

        .login-box {
            width: 450px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 25px 40px 35px 40px;
            box-sizing: border-box;
        }

        .login-box h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #555;
            font-weight: normal;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 2px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #5c5fdf;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
        }

        .btn:hover {
            background: #4a4fcc;
        }

        .links {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .links a {
            text-decoration: none;
            color: #555;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

    <h1>SignIn Page</h1>

    <div class="login-box">
        <h3>Welcome back to BPMS AdminPanel !</h3>

        <form>
            <div class="input-group">
                <input type="text" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn">Sign In</button>
        </form>

        <div class="links">
            <a href="index.php">Back to Home</a>
            <br><br>
            <a href="#">forgot password?</a>
        </div>
    </div>

</body>
</html>
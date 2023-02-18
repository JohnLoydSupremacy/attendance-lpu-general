
<?php
session_start();
include("connection.php");
include("afunctions.php");
if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$id = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($id) && !empty($password))
		{

			//read from database
			$query = "select * from admin where username = '$id' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{
						$_SESSION['username'] = $user_data['username'];
						header("Location: Admin_Page.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}
        else
		{
			echo "wrong username or password!";
		}
	}
    $_SESSION;
?>
<!DOCTYPE html>
<HTML>
    <HEAD>
        <meta a charset ="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <title> Log in </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        .container{
            width: 100%;
            height: 100vh;
            background-image: linear-gradient(#a4242c,rgba(255,255,255,0.5)),url(background.jpg);
            background-position: center;
            background-size: cover;
            position: relative;
        }
        .center {
            display: block;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
        }
        .login {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
        }
        .login form {
            padding: 0 40px;
            box-sizing: border-box;
        }
        .login h2 {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #a4242c;
        }
        form .info {
            position: relative;
            border-bottom: 2px solid #adadad;
            margin: 30px 0;
        }
        .info input {
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 20px;
            border: none;
            background: none;
            outline: none;
        }
        .info label {
            position: absolute;
            top: 50%;
            left: 5px;
            color: #a3103c;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }
        .info span::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #a4242c; 
            transition: .5s;
        }
        .info input:focus ~ label,
        .info input:valid ~ label {
            top: -5px;
            color: #a4242c;
        }
        .info input:focus ~ span::before,
        .info input:valid ~ span::before {
            width: 100%;
        }
        .pwd {
            margin: -5px 0 20px 5px;
            color: #a6a6a6;
            cursor: pointer;
        }
        .pwd:hover {
            text-decoration: underline;
        }
        input[type="submit"] {
            width: 100%;
            height: 50px;
            border: 1px solid;
            background: #a4242c;
            border-radius: 25px;
            font-size: 20px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
        }
        input[type="submit"]:hover {
            border-color: #a4242c;
            transition: .5s;
        }
        .signup {
            margin: 30px 0;
            text-align: center;
            font-size: 16px;
            color: #666666;
        }
        .right {
            display: block;
            margin-left: 47%;
            margin-bottom: 10px;
            margin-top: px;
        }
        .exit {
            display: block;
            margin-left: 95%;
            margin-right: auto;
            margin-top: 10px;
        }
</style>
</HEAD>
<BODY>
    <div class = container>
        <div class="login">
            <img src="lpulogo.png" alt="logo" width="150" height="150" class="center">
            <h2 style="font-family: Bahnschrift;">Lyceum of the Philippines - Laguna</h2>
                <form method="post">
            <div class="info">
                <input type="text" name="username" required>
                <span></span>
                <label>Admin</label>
            </div>
            <div class="info">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <input type="submit" value="Log in">
            <div class="signup">
                <a href="Index.php"><img src="admin_icon.png " width="30" height="30" class="right"></a>
            </div>
                </form>
        </div> 
    </div>
</BODY>
</HTML>
    

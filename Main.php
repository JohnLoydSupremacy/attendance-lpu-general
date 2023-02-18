<?php 
session_start();

include("connection.php");
include("functions.php");
$user_data_studentnumber = check_login($con);
$user_data_password = check_login($con);
$user_data_name = check_login($con);
$user_data_department = check_login($con);


    if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else 
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        if(isset($_POST['submit1'])) 
        {
            $current_day = date('j');
            $query = "SELECT COUNT(*) as count FROM log WHERE student_number = '{$user_data_studentnumber['student_number']}' AND ipadd <> '{$ip_address}' AND t_out IS NULL";
            $result = mysqli_query($con, $query);
            $count = mysqli_fetch_assoc($result)['count'];
            if($count > 0) 
            {
                echo "You already have an active session on a different device.";
                die;
            } 
            else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE student_number = '{$user_data_studentnumber['student_number']}' AND t_out IS NULL")) > 0) 
            {
                echo "You already have an active session on this device.";
                die;
            }
            else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE ipadd = '{$ip_address}' AND student_number <> '{$user_data_studentnumber['student_number']}' AND t_out IS NULL")) > 0) 
            {
                echo "This device is being used by another student.";
                die;
            }
            else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE student_number = '{$user_data_studentnumber['student_number']}' AND ipadd <> '{$ip_address}' AND t_out IS NULL")) > 0) 
            {
                echo "You already have an active session on a different device.";
                die;
            }
            else 
            {
                $query = "INSERT INTO log (student_number, password, name, department, t_in, t_out, ipadd) 
                SELECT CONCAT(student_number,'{$current_day}') as student_number, password, name, department, 
                NOW() as t_in, NULL as t_out,'{$ip_address}' as ipadd
                FROM users 
                WHERE student_number = '{$user_data_studentnumber['student_number']}'
                AND NOT EXISTS (SELECT 1 FROM log WHERE ipadd = '{$ip_address}')";  
                header("Location: Main.php");
                mysqli_query($con, $query);
                die;
            }
        }
    if(isset($_POST['submit2'])) 
    {
        $current_day = date('j');
        $query = "UPDATE log SET t_out = NOW() WHERE ipadd = '{$ip_address}'";
        mysqli_query($con, $query);
        header("Location: Main.php");
        die;
    }   
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPU Laguna</title>
    <link rel="stylesheet" href="style2.css">
    <script src="https://kit.fontawesome.com/cc984e4696.js" crossorigin="anonymous"></script>
</head>
<body onload="startTime()">
    <div class="container">
        <div class="login">
        <img src="lpulogo.png" alt="logo" width="150" height="150" class="center">
        <h2 style="font-family: Bahnschrift;">Lyceum of the Philippines - Laguna</h2>
        <form method="post" action="Home.html">
            <div class="info">
                <span></span>
                <div id= "txt"></div>

<script>function display_ct7() 
{
    var x = new Date()
    var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
    hours = x.getHours( ) % 12;
    hours = hours ? hours : 12;
    hours=hours.toString().length==1? 0+hours.toString() : hours;

    var minutes=x.getMinutes().toString()
    minutes=minutes.length==1 ? 0+minutes : minutes;

    var seconds=x.getSeconds().toString()
    seconds=seconds.length==1 ? 0+seconds : seconds;

    var month=(x.getMonth() +1).toString();
    month=month.length==1 ? 0+month : month;

    var dt=x.getDate().toString();
    dt=dt.length==1 ? 0+dt : dt;

    var x1=month + "/" + dt + "/" + x.getFullYear(); 
    x1 = x1 + " - " +  hours + ":" +  minutes + ":" +  seconds + " " + ampm;
    document.getElementById('ct7').innerHTML = x1;
    display_c7();
}
 function display_c7(){
var refresh=1000;
mytime=setTimeout('display_ct7()',refresh)
}
display_c7()
</script>
<div style="text-align: center;">
    <span id='ct7' style="font-family:'Bahnschrift';font-size:x-large"></span>
</div>
                <h3>Hello, <?php echo $user_data_name['name']; ?></h3>
            </div>
            <form action="" method="POST">
                <button type="submit" name="submit1"formaction="#">Time In</button>
                <button type="submit" name="submit2"formaction="#">Time Out</button>
            </form>
        </div> 
    </div>
</body>
</html>
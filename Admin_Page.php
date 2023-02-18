<?php
session_start();

include("connection.php");
include("functions.php");
$user_data_studentnumber = check_login($con);
$user_data_password = check_login($con);
$user_data_name = check_login($con);
$user_data_department = check_login($con);
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
                    <div id="txt"></div>

                    <script>
                        function display_ct7() {
                            var x = new Date()
                            var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
                            hours = x.getHours() % 12;
                            hours = hours ? hours : 12;
                            hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

                            var minutes = x.getMinutes().toString()
                            minutes = minutes.length == 1 ? 0 + minutes : minutes;

                            var seconds = x.getSeconds().toString()
                            seconds = seconds.length == 1 ? 0 + seconds : seconds;

                            var month = (x.getMonth() + 1).toString();
                            month = month.length == 1 ? 0 + month : month;

                            var dt = x.getDate().toString();
                            dt = dt.length == 1 ? 0 + dt : dt;

                            var x1 = month + "/" + dt + "/" + x.getFullYear();
                            x1 = x1 + " - " + hours + ":" + minutes + ":" + seconds + " " + ampm;
                            document.getElementById('ct7').innerHTML = x1;
                            display_c7();
                        }

                        function display_c7() {
                            var refresh = 1000;
                            mytime = setTimeout('display_ct7()', refresh)
                        }
                        display_c7()
                    </script>
                    <div style="text-align: center;">
                        <span id='ct7' style="font-family:'Bahnschrift';font-size:x-large"></span>
                    </div>
                    <form action="" method="POST">
                        <button type="submit" name="export" formaction="export.php">Export Data</button>
                        <button type="submit" name="submit2" formaction="#">Add Student</button>
                    </form>
</body>

</html>
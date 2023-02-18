<?php
session_start();

include("connection.php");
include("functions.php");

$event_name = "";
$time_in = "";
$time_out = "";
$date = "";
$message = "";

date_default_timezone_set('Asia/Manila');

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip_address = $_SERVER['REMOTE_ADDR'];
}
if (isset($_POST['submit1'])) {
    $student_number = $_POST['student_number'];

    $query = "SELECT COUNT(*) as count FROM log WHERE student_number = '{$_POST["student_number"]}' AND DATE(t_in) = CURDATE() AND t_out = ''";
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];

    if ($count > 0) {
        $message = "You have already timed in for this event.";
    } else {
        $query = "INSERT INTO log (student_number, name, department, t_in, t_out, ipadd) 
                SELECT student_number, name, department, 
                NOW() as t_in, NULL as t_out,'{$ip_address}' as ipadd
                FROM users 
                WHERE student_number = '{$student_number}'";

        mysqli_query($con, $query);

        // If there is an active session on a previous day, but not on the current day, insert a new log entry
        if (mysqli_affected_rows($con) == 0 && mysqli_num_rows(mysqli_query($con, "SELECT * FROM log WHERE student_number = '{$student_number}' AND DATE(t_in) <> CURDATE() AND t_out IS NULL")) > 0) {
            mysqli_query($con, "INSERT INTO log (NULL, student_number, name, department, t_in, t_out, ipadd) 
                                SELECT student_number, name, department, 
                                NOW() as t_in, NULL as t_out,'{$ip_address}' as ipadd
                                FROM users 
                                WHERE student_number = '{$student_number}'");
        }

        $message = 'Successfully timed in.';
    }
}
if (isset($_POST['submit2'])) {
    $current_day = date('j');
    $student_number = $_POST['student_number'];
    $query = "SELECT * FROM log WHERE student_number = '{$student_number}' AND DATE(t_in) = CURDATE()";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        mysqli_query($con, "UPDATE log SET t_out = NOW() WHERE student_number = '{$student_number}' AND DATE(t_in) = CURDATE()");
        if (mysqli_affected_rows($con) > 0) {
            $message = 'Successfully timed out.';
        } else {
            $message = 'There was an error updating the database.';
        }
    } else {
        $message = 'There is no active session to time out for today.';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style2.css">
    <script src="https://kit.fontawesome.com/cc984e4696.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPU-Laguna Attendance</title>
</head>

<body onload="startTime()" class="bg-red-200">
    <div class="wrapper antialiased text-gray-900">
        <div>
            <img src="lpufoundationlogo_original.png"
                class="w-full object-fill object-center rounded-lg shadow-md bg-red-400">
            <div class="relative px-4 -mt-16">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h5 class="text-center mt-1 text-xl font-semibold leading-tight">Attendance for Foundation Week 2023
                    </h5>
                    <div id="txt" class="<?php
                                            if ($message == "Successfully timed in." || $message == "Successfully timed out.") {
                                                echo "text-green-500";
                                            } else {
                                                echo "text-red-500";
                                            }
                                            ?> text-center"><?php echo $message ?>
                    </div>

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
                    <div id="ct7" class="mt-1 font-semibold uppercase text-center"></div>
                    <div class="mt-4">
                        <span id='ct7' style="font-family:'Bahnschrift';font-size:x-large"></span>
                        <form action="" method="POST">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" name="student_number" type="text" placeholder="Student Number" required>
                            <br>
                            <br>
                            <input name="event_id_number" type="hidden" value="<?php echo $event_id ?>">
                            <div class="rounded-md shadow-sm flex items-center justify-center" role="group">
                                <button type="submit" name="submit1"
                                    class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-blue-500 rounded">
                                    Time in
                                </button>
                                <button
                                    class="bg-white-500 hover:bg-white-400 text-white font-bold py-2 px-4 border-b-4 border-none hover:border-white-500 rounded">
                                </button>
                                <button type="submit" name="submit2"
                                    class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-blue-500 rounded">
                                    Time out
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <span class="p-5 text-sm text-b lack-500 text-center dark:text-gray-400">Please be reminded that
            physical attendancewill be verified by the school through class representatives and
            faculty in charge.</span>

        <span class="p-5 text-sm text-gray-500 text-center dark:text-gray-400">Designed by COECS💻</span>
    </div>
</body>

</html>
<?php

function check_login($con)
{

    if (isset($_SESSION['student_number']))
    {
        $id = $_SESSION['student_number'];
        $query = "select * from users where student_number = '$id' limit 1 ";

        $result = mysqli_query($con,$query);
        if ($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }

    }
    header("Location: Login.php");
    die;
}

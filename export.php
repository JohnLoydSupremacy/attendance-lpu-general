<?php
include 'Connection.php';
$output = '';
$query = "SELECT * FROM log order by t_in";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $output .= '
  <table class="table" bordered="1">  
                   <tr>  
                        <th>NO.</th>  
                        <th>Student Number</th>  
                        <th>Name</th>  
                        <th>Department</th>  
                        <th>Time in</th>  
                        <th>Time out</th>  
                  
                   </tr>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $sl = ++$i;
        $output .= '
   <tr>  
                        <td>' . $sl . ' </td>
                        <td>' . $row["student_number"] . '</td>  
                        <td>' . $row["name"] . '</td>  
                        <td>' . $row["department"] . '</td>  
                        <td>' . $row["t_in"] . '</td>  
                        <td>' . $row["t_out"] . '</td>  
                   </tr>
  ';
    }
    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Attendance.xls');
    echo $output;
}

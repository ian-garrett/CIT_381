<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Worklog</title>
 <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  
  <body bgcolor="white">
  <div id="text">
  
  <hr>
  
  
<?php
  

$query = "SELECT group_concat(DISTINCT(concat(e.firstName,' ', e.lastName))) AS 'Employee',
w.week AS 'Ending Week',
a.ID AS 'Assignment Number',
w.totalHours AS 'Hours Worked',
w.BILLS_ID AS 'Bill Number'
FROM WORK_LOG w JOIN ASSIGNMENTS a ON w.ASSIGNMENTS_ID=a.ID
JOIN EMPLOYEES e ON e.ID=a.EMPLOYEES_ID
GROUP BY w.ASSIGNMENTS_ID;"
;

?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

echo "<table width ='100%' border='1'>
        <tr>
        <th>Employee</th>
        <th>Ending Week</th>
        <th>Assignment Number</th>
        <th>Hours Worked</th>
        <th>Bill Number</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['Employee'] . "</td>";
                echo "<td>" . $row['Ending Week'] . "</td>";
                echo "<td>" . $row['Assignment Number'] . "</td>";
                echo "<td>" . $row['Hours Worked'] . "</td>";
                echo "<td>" . $row['Bill Number'] . "</td>";
                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="workLog.php">Reset</a></button></span>	 
 
</body>
</html>
	  
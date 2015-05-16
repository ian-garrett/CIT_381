<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Employee's Work Histories</title>
 <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  
  <body bgcolor="white">
  <div id="text">
  
  <hr>
  
  
<?php
  
$state = $_POST['state'];

$state = mysqli_real_escape_string($conn, $state);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT group_concat(distinct((concat(e.firstName,' ', e.lastName)))) AS 'Employee',
IFNULL(COUNT(a.EMPLOYEES_ID), 0) AS 'Number of Assignments Worked On'
FROM WORK_LOG w JOIN ASSIGNMENTS a ON w.ASSIGNMENTS_ID=a.ID
RIGHT JOIN EMPLOYEES e ON e.ID=a.EMPLOYEES_ID
WHERE e.ID=";
$query = $query."'".$state."' GROUP BY e.ID;";

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
        <th># of assignments worked on</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['Employee'] . "</td>";
                echo "<td>" . $row['Number of Assignments Worked On'] . "</td>";

                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="employeeidWorkHistory.html">Reset</a></button></span>	 
 
</body>
</html>
	  
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Associated tasks and required skills for a project</title>
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

$query = "SELECT s.startDate AS 'START DATE', s.endDate AS 'END DATE', s.descript AS 'TASK DESCRIPTION', 
GROUP_CONCAT(z.descript) AS 'SKILL(S) NEEDED', 
GROUP_CONCAT(n.quantity) AS 'QUANTITY REQUIRED'
FROM PROJECT_SCHEDULES s JOIN PROJECTS p ON s.PROJECTS_ID=p.ID
JOIN TASK_needs_SKILLS n ON s.TASK_ID=n.TASK_ID
JOIN SKILLS z ON z.ID=n.SKILLS_ID
WHERE p.ID =";
$query = $query."'".$state."' GROUP BY s.TASK_ID;";

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
        <th>Start Date</th>
        <th>End Date</th>
        <th>Task Descriptions</th>
        <th>Skill(s) needed</th>
        <th>Quantity of Employees with skill(s)</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['START DATE'] . "</td>";
                echo "<td>" . $row['END DATE'] . "</td>";
                echo "<td>" . $row['TASK DESCRIPTION'] . "</td>";
                echo "<td>" . $row['SKILL(S) NEEDED'] . "</td>";
                echo "<td>" . $row['QUANTITY REQUIRED'] . "</td>";

                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="2.html">Reset</a></button></span>	 
 
</body>
</html>
	  
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Assignments associated with a Project ID</title>
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

$query = "SELECT x.descript, x.startDate AS 'ScheduledStartDate', x.endDate AS 'ScheduledEndDate',
group_concat(concat(' ',s.descript)) AS 'SkillsNeeded',
group_concat((concat(e.firstName,' ', e.lastName))) AS 'EmployeeswithSkill',
a.startDate AS 'ActualStartDate', a.endDate AS 'ActualEndDate'
FROM ASSIGNMENTS a JOIN TASK_needs_SKILLS z USING(TASK_ID)
JOIN SKILLS s ON a.SKILLS_ID=z.SKILLS_ID 
LEFT JOIN EMPLOYEES e on a.EMPLOYEES_ID=e.ID 
JOIN PROJECT_SCHEDULES x ON x.TASK_ID=z.TASK_ID
JOIN PROJECTS p ON p.ID=x.PROJECTS_ID
WHERE a.TASK_ID!=' ' AND s.ID=a.SKILLS_ID
AND p.id=";
$query = $query."'".$state."' GROUP BY a.TASK_ID;";

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
        <th>Scheduled StartDate</th>
        <th>Scheduled EndDate</th>
        <th>Skills Needed</th>
        <th>Employees with Skill</th>
        <th>Actual StartDate</th>
        <th>Actual EndDate</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['ScheduledStartDate'] . "</td>";
                echo "<td>" . $row['ScheduledEndDate'] . "</td>";
                echo "<td>" . $row['SkillsNeeded'] . "</td>";
                echo "<td>" . $row['EmployeeswithSkill'] . "</td>";
                echo "<td>" . $row['ActualStartDate'] . "</td>";
                echo "<td>" . $row['ActualEndDate'] . "</td>";

                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="3.html">Reset</a></button></span>	 
 
</body>
</html>
	  
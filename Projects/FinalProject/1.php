<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Skills and the Employees that have them</title>
 <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  
  <body bgcolor="white">
  <div id="text">
  
  <hr>
  
  
<?php
  

$query = "SELECT s.descript AS 'Skill', GROUP_CONCAT(concat(' ',(concat(e.firstName,' ', e.lastName)))) AS 'Employees'
FROM SKILLS s JOIN EMPLOYEES_have_SKILLS h ON s.ID=h.SKILLS_ID
JOIN EMPLOYEES e ON e.ID=h.EMPLOYEES_ID 
GROUP BY s.ID;";

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
        <th>Skills</th>
        <th>Employees with Skill</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['Skill'] . "</td>";
                echo "<td>" . $row['Employees'] . "</td>";
                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="1.php">Reset</a></button></span>	 
 
</body>
</html>
	  
<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Employees in the same Region as Customer</title>
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

$query = "SELECT
(concat(e.firstName,' ', e.lastName)) AS 'Employees within same region as customer',
group_concat(DISTINCT(s.descript)) AS 'Employees Skills'
FROM EMPLOYEES e,EMPLOYEES_have_SKILLS h, SKILLS s, CUSTOMERS c, PROJECTS p, EMPLOYEES_have_SKILLS x
WHERE h.SKILLS_ID=s.ID AND p.CUSTOMERS_ID=c.ID AND h.SKILLS_ID=s.ID AND x.EMPLOYEES_ID=e.ID
AND c.REGIONS_code=e.REGIONS_code AND x.SKILLS_ID=s.ID AND p.ID=";
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
        <th>Employees</th>
        <th>Skills</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['Employees within same region as customer'] . "</td>";
                echo "<td>" . $row['Employees Skills'] . "</td>";

                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="7.html">Reset</a></button></span>	 
 
</body>
</html>
	  
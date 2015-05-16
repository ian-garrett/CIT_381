<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<head>
  <title>Employees associated with Region</title>
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
concat(e.firstName,' ', e.lastName) AS 'Employees within Selected Region',
e.hireDate AS 'Date of Hire' 
FROM EMPLOYEES e
WHERE e.REGIONS_code=";
$query = $query."'".$state."' ;";

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
        <th>Hire Date</th>
        </tr>";

        //  $row = mysqli_fetch_row($query);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                echo "<tr>";
                echo "<td>" . $row['Employees within Selected Region'] . "</td>";
                echo "<td>" . $row['Date of Hire'] . "</td>";

                
               
        //  $row = mysqli_fetch_row($query);
                        }
        echo "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 <span><button><a href="index.html">Home</a></button> <button><a href="regionEmployeeHire1.html">Reset</a></button></span>	 
 
</body>
</html>
	  

<html>
<head>    <meta charset="utf-8" />
    <title>Our photograpers</title>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aaa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//retrieving all data from photographers table
$sql = "SELECT * FROM photograpers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["p-id"]. " <b> Name: ". $row["p-name"]. "-Age " . $row["p-age"] . "-Experience" .$row["p-exp"]."years". "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?> 
    
</body>
</html>
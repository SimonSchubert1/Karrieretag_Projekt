<?php
$dbHost = "localhost";
$dbUsername = "wordpress";
$dbPassword = "Pa$\$word1234";
$dbName = "test";

$dbTable = $_GET['dbTable'];

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

/*$result = $db->query("SELECT * FROM test ORDER BY id ASC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['id'];
        echo $row['name'];
    }
} else {
    echo "No test found...";
}*/

$query = $db->query("SELECT * FROM `" . $dbTable . "` ORDER BY id ASC");
if($query->num_rows > 0){
    $delimiter = ";";
    $filename = $dbTable. "_" . date('Y-m-d') . ".csv";

//Create a file pointer
    $f = fopen('php://memory', 'w');

//Set column headers
    $fields = array('ID', 'NAME');
    fputcsv($f, $fields, $delimiter);

    while($row = $query->fetch_assoc()){
        $lineData = array($row['id'], $row['name']);
        fputcsv($f, $lineData, $delimiter);
    }

    fseek($f,0);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

//output all remaining data on a file pointer

    fpassthru($f);
}
exit;
?>
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

$colnames = $db->query("SHOW COLUMNS FROM `" . $dbTable . "`");
$query = $db->query("SELECT * FROM `" . $dbTable . "` ORDER BY id ASC");
if($query->num_rows > 0) {
    $delimiter = ";";
    $filename = $dbTable . "_" . date('Y-m-d') . ".csv";

//Create a file pointer
    $f = fopen('php://memory', 'w');

//Set column headers
    $fields = array();
    while ($row = $colnames->fetch_row()){
        $fields[] = $row[0];
    }
    fputcsv($f, $fields, $delimiter);

    while ($row = $query->fetch_row()) {
        $lineData = array();
        for($i = 0; $i < count($row); $i++){
            $lineData[] = $row[$i];
        }
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
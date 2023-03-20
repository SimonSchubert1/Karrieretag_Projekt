<?php

//data of database
$dbHost = "localhost";
$dbUsername = "wordpress"; //nach belieben umändern
$dbPassword = "Pa$\$word1234"; //nach belieben umändern
$dbName = "test"; //nach belieben umändern

//table name
$dbTable = $_GET['dbTable'];

//connect to database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

//get the names of the columns
$colnames = $db->query("SHOW COLUMNS FROM `" . $dbTable . "`");

//get the data from the table
$query = $db->query("SELECT * FROM `" . $dbTable . "`");
if (($colnames->num_rows) > 0 && ($query->num_rows) > 0) {
        //Character that devides the fields in the .csv file
        $delimiter = ";";

        //file the data gets saved to
        $filename = $dbTable . "_" . date('Y-m-d') . ".csv";

        //Create a file pointer
        $f = fopen('php://memory', 'w');

        //Set column headers
        $fields = array();
        while ($row = $colnames->fetch_row()) {
            $fields[] = $row[0];
        }
        fputcsv($f, $fields, $delimiter);

        //set column fields
        while ($row = $query->fetch_row()) {
            $lineData = array();
            for ($i = 0; $i < count($row); $i++) {
                $lineData[] = $row[$i];
            }
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);

        //define header
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

//output all remaining data on a file pointer

        fpassthru($f);
}
exit;
?>
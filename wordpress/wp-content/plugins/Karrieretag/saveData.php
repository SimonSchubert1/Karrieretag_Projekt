<?php
$formnames = array();
foreach ($_POST as $key => $value) {
    if (strcmp($key, 'submitbtn')) {
        $formnames[] = $key;
    }
}
$dbHost = "localhost";
$dbUsername = "wordpress";
$dbPassword = "Pa$\$word1234";
$dbName = "test";

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

foreach ($formnames as $key) {
    $column = array();
    foreach ($this->find_forms_on_website_full_code() as $key2 => $value) {
        $comp = $this->get_form_name($value);
        if ($key == $comp) {
            foreach ($this->get_input_tag_names($value) as $key3 => $value2) {
                if (isset($_POST[$value2])) {
                    $column[$value2] = $_POST[$value2];
                }
            }
        }
    }
    $query = "INSERT INTO `" . $key . "` (";
    foreach ($column as $key4 => $value) {
        $query .= "`" . $key4 . "`, ";
    }
    $query = rtrim($query, ", "); // remove trailing comma
    $query .= ") VALUES (";
    foreach ($column as $key5 => $value) {
        $query .= "'" . $value . "', ";
    }
    $query = rtrim($query, ", "); // remove trailing comma
    $query .= ")";

    $stmt = mysqli_stmt_init($db);

    if( ! mysqli_stmt_prepare($stmt, $query)){
        die (mysqli_error ($db)) ;
    }
}
?>
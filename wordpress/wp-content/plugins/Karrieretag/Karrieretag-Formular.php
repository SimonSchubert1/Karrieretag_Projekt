<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Karrieretag - Formular</title>
</head>
<body>
</body>
</html>

<?php
function saveImage($file_name): string
{
    $currentYear = (int) date("y");
    $currentMonth = (int) date("m");
    if ($currentMonth <= 6){
    $date = $currentYear - 1 . $currentYear;
    }
    else{
        $date = $currentYear . $currentYear + 1;
}
    $target_dir = "../../uploads/Karrieretag" . $date . "/";
    //if the directory doesn't already exist, create it
    if(!file_exists($target_dir)){
        mkdir($target_dir, 0755, true);
    }
    $companyName = $_POST["Firmenname"];
    //get name of file + type
    $fileName = basename($_FILES[$file_name]["name"]);
    $split_filename = explode(".", $fileName);
    //get name of file without type
    $fileName = rtrim($fileName, $split_filename[sizeof($split_filename) - 1]);
    //build clean filename without special characters
    $clean_filename = preg_replace('/[^A-Za-z0-9]/', '', $fileName) . "." . $split_filename[sizeof($split_filename) - 1];
    $target_file = $target_dir . preg_replace('/[^A-Za-z0-9]/', '', $companyName) . date("y-m-d") . $clean_filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;
    $output = "<h3>" . htmlspecialchars(basename($_FILES[$file_name]["name"])) . ":</h3><ul>";

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$file_name]["tmp_name"]);
        if ($check !== false) {
            $output .= "<li>Datei ist ein Bild - " . $check["mime"] . ".</li>";
            $uploadOk = 1;
        } else {
            $output .= "Datei ist kein Bild.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $output .= "<li>Diese Datei existiert bereits.</li>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES[$file_name]["size"] > 500000) {
        $output .= "<li>Die Datei ist zu groß.</li>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $output .= "<li>Entschuldigung, nur JPG, JPEG, PNG & GIF Dateien werden aktzeptiert.</li>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0  by an error
    if ($uploadOk == 0) {
        $output .= "<li>Entschuldigung, die Datei wurde nich hochgeladen.</li>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES[$file_name]["tmp_name"], $target_file)) {
            $output .= "<li>Die Datei wurde hochgeladen.</li>";
        } else {
            $output .= "<li>Es ist ein fehler beim Hochladen der Datei aufgetreten.</li>";
        }
    }
    return $output . "</ul>";
}

echo saveImage("Firmenlogo");
echo saveImage("BildAnsprechpartner");
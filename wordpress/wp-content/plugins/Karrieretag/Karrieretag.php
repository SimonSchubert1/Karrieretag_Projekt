<?php
/*
 * Plugin Name: Karrieretag
 * Description: Handle the basics with this plugin.
 * Version: 1.10.3
 * Requires at least: 5.2
 * Requires PHP: 5.0
 */

echo '<link rel="stylesheet" type="text/css" href="../wp-content/plugins/Karrieretag/css/stylesheet.css">';
echo '<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">';

// if ABSPATH is not defined, exit
if (!defined('ABSPATH')) {
    die;
}

// define KarrieretagPlugin class
class KarrieretagPlugin
{
    // variables
    public $form_names = array();

    // constructor
    public function __construct()
    {
        // add custom menu page when admin menu is being prepared
        add_action('admin_menu', array($this, 'custom_menu_page'));
        // insert data into the database when WordPress initializes
        add_action('init', array($this, 'insert_data'));
    }

    // function called on activation of the plugin
    function activate()
    {
        $this->custom_menu_page();
        // flush rewrite rules
        flush_rewrite_rules();
    }

    // function called on deactivation of the plugin
    function deactivate()
    {
        // flush rewrite rules
        flush_rewrite_rules();
    }

    // add custom menu page
    function custom_menu_page()
    {
        // add new menu page to the WordPress dashboard
        add_menu_page('Karrieretag', 'Karrieretag', 'manage_options', 'Karrieretag', array($this, 'test_init'));
    }

    // function that initializes the custom menu page
    function test_init()
    {
        // call the make_menu_page() function
        $this->make_menu_page();
    }


    // function that creates the custom menu page


    function make_menu_page()
    {
        // display "AppleSucks" as a title
        echo "<span class='span'><h1 class='h1'>Karrieretag</h1></span>";
        echo "<container class='container'>";

        // create a form with the ID "Forms-to-check" and a post method
        echo "<form class='form' action='#' method='post' id='Forms-to-check'>";

        // loop through each form on the website
        for ($i = 0; $i < count($this->find_forms_on_website()); $i++) {
            // get the name of the form
            $form_name = $this->get_form_name($this->find_forms_on_website()[$i]);

            // create a checkbox for the form name
            if (isset($_POST["_" . $form_name . "_"])) {

                echo "<label class='check-label'><input class='checkbox' type='checkbox' name='$form_name'><div class='check-design'></div> " . "<div class='text'>" . $form_name . "</div>" . "<div class='wrapper'><div class='file-export'><a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=" . $form_name . "'>Export</a><i class='uil uil-arrow-up'></i></div></div></label>" . "<br>";
            } else {
                echo "<label class='check-label'><input class='checkbox' type='checkbox' name='$form_name'><div class='check-design'></div>" . "<div class='text'>" . $form_name . "</div>" . "<div class='wrapper'><div class='file-export'><a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=" . $form_name . "'>Export</a><i class='uil uil-arrow-up'></i></div></div></label>" . "<br>";
            }

            // add the form name to an array
            $this->form_names[] = $form_name;
        }

        // add a submit button to the form
        echo "<input id='sum_button_kar' type='submit' name='submitbtn'></form></container>";

        // if the submit button has been pressed
        if (isset($_POST['submitbtn'])) {
            // create an array of form names
            $formnames = array();
            foreach ($_POST as $key => $value) {
                if (strcmp($key, 'submitbtn')) {
                    $formnames[] = $key;
                }
            }

            //data of database
            $dbHost = "localhost";
            $dbUsername = "wordpress";
            $dbPassword = "Pa$\$word1234";
            $dbName = "test";

            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

            foreach ($formnames as $key) {
                $query = "CREATE TABLE IF NOT EXISTS `" . $key . "` (";
                foreach ($this->find_forms_on_website_full_code() as $key3 => $value2) {
                    $comp = $this->get_form_name($value2);
                    if ($key == $comp) {
                        foreach ($this->get_input_tag_names_and_type($value2) as $key2 => $value) {
                            $splitstring = explode(";", $value);
                            if ($splitstring[1] != "hidden") {
                                $query .= "`" . $splitstring[0] . "`" . " " . $this->suggest_mysql_datatype($splitstring[1]) . ", ";
                            }
                        }
                    }
                }

                $query .= "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

                if (mysqli_query($db, $query)) {
                    echo "<br> <b>Table created successfully</b>";
                } else {
                    echo "Error creating table: " . mysqli_error($db);
                }
            }
        }
    }

    // Define function to insert data into MySQL database
    function insert_data()
    {

        // Check if form was submitted using POST method and has a valid form name
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form-name'])) {
            // Define MySQL database credentials
            $dbHost = "localhost";
            $dbUsername = "wordpress";
            $dbPassword = "Pa$\$word1234";
            $dbName = "test";

            // Create MySQL connection object
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

            // Get the form name from the submitted form data
            $key = $_POST['form-name'];

            // Initialize array to store form input data
            $column = array();

            // Loop through all forms on website and find matching form by name
            foreach ($this->find_forms_on_website_full_code() as $key2 => $value) {
                $comp = $this->get_form_name($value);
                if ($key == $comp) {
                    // Loop through all input elements in the form and store their data
                    foreach ($this->get_input_tag_names_and_type($value) as $key3 => $value2) {
                        $splitstring = explode(";", $value2);
                        if (isset($_POST[$splitstring[0]]) && $splitstring[1] != "hidden") {
                            $column[$splitstring[0]] = $_POST[$splitstring[0]];
                        }
                    }
                }
            }

            // Generate MySQL INSERT query for the form data
            $query = "INSERT INTO `" . $key . "` (";
            foreach ($column as $key4 => $value) {
                $splitstring = explode(";", $key4);
                $query .= "`" . $splitstring[0] . "`, ";
            }
            $query = rtrim($query, ", "); // remove trailing comma
            $query .= ") VALUES (";
            foreach ($column as $key5 => $value) {
                $query .= "'" . $value . "', ";
            }
            $query = rtrim($query, ", "); // remove trailing comma
            $query .= ")";

            // Debug output to check the generated query
            echo $query;

            // Execute the INSERT query and display success or error message
            if (mysqli_query($db, $query)) {

            } else {
                echo "Error creating table: " . mysqli_error($db);
            }

            // Redirect user to the same page after form submission
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }
    }

    // Function to suggest MySQL datatype based on input type
    function suggest_mysql_datatype($input)
    {
        if ($input == "number") {
            return "INT(10)";
        } elseif ($input == "text") {
            return "VARCHAR(255)";
        } elseif ($input == "checkbox") {
            return "BOOLEAN";
        } else {
            return "VARCHAR(255)";
        }
    }


    // Define a function to find all forms on the website

        function find_forms_on_website()
        {

            $args = array(
                'post_type' => 'any',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );

            // Get all published posts
            $posts = get_posts($args);

            // Initialize an empty array to store all forms found on the website
            $forms = array();

            // Loop through each post and use regular expressions to find all form elements in its content
            foreach ($posts as $post) {
                preg_match_all('/<form.*<\/form>/siU', $post->post_content, $matches);
                foreach ($matches[0] as $match) {
                    $forms[] = $match;
                }
            }


            // Return an array of all form elements found on the website


            return $forms;
        }

        function find_forms_on_website_full_code()
        {
            $args = array(
                'post_type' => 'any',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );

            $posts = get_posts($args);

            $forms = array();

            foreach ($posts as $post) {
                preg_match_all('/<form.*<\/form>/siU', $post->post_content, $matches);
                foreach ($matches[0] as $match) {
                    $forms[] = $match;
                }
            }

            return $forms;
        }

        // Define a function to extract the name and type attributes of all input tags in a form
        function get_input_tag_names_and_type($form_html)
        {
            // Initialize an empty array to store the name and type attributes of all input tags in the form
            $input_tag_names = array();

            // Load the HTML form using the DOMDocument class
            $dom = new DOMDocument();
            @$dom->loadHTML($form_html); // suppress warnings about invalid HTML

            // Get all input elements in the form
            $input_tags = $dom->getElementsByTagName('input');

            // Loop through each input element and extract the name and type attributes
            foreach ($input_tags as $input) {
                $name = $input->getAttribute('name');
                $type = $input->getAttribute('type');
                if (!empty($name)) {
                    $input_tag_names[] = $name . ";" . $type;
                }
            }

            // Return an array of all name and type attributes of input tags in the form
            return $input_tag_names;
        }

        // Define a function to extract the name attribute of a form
        function get_form_name($form)
        {
            // Load the form HTML using the DOMDocument class
            $doc = new DOMDocument();
            @$doc->loadHTML($form); // suppress warnings about invalid HTML

            // Get the name attribute of the form
            $form_name = $doc->getElementsByTagName('form')->item(0)->getAttribute('name');
            return $form_name;
        }

}

// Check if the KarrieretagPlugin class exists
if( class_exists('KarrieretagPlugin' ) ) {
    // Instantiate the KarrieretagPlugin class
    $karrieretagPlugin = new KarrieretagPlugin();
}

// Register the activate() method of the KarrieretagPlugin class as the activation hook for this plugin
register_activation_hook(__FILE__, array($karrieretagPlugin, 'activate'));

// Register the deactivate() method of the KarrieretagPlugin class as the deactivation hook for this plugin
register_activation_hook(__FILE__, array($karrieretagPlugin, 'deactivate'));
?>

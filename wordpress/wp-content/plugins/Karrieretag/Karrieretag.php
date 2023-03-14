<?php
/*
    * Plugin Name: AppleSucks
    * Description: Handle the basics with this plugin.
    * Version: 1.10.3
    * Requires at least: 5.2
    * Requires PHP: 7.0
    */

if( ! defined( 'ABSPATH') ){
    die;
}

class KarrieretagPlugin{
    //variables

    public $form_names = array();

    //methods
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'custom_menu_page'));
    }

    function activate(){
        //function called on activation of the plugin
        $this->custom_menu_page();
        flush_rewrite_rules();
    }

    function deactivate(){
        //function called on deactivation of the plugin
        flush_rewrite_rules();
    }

    function uninstall(){
        //function called on uninstallation of the plugin
    }

    function custom_menu_page(){
        add_menu_page('AppleSucks',  'AppleSucks', 'manage_options', 'AppleSucks', array($this, 'test_init'));
    }

    function test_init(){
        $this->make_menu_page();
    }

    function make_menu_page()
    {
        echo "<h1>AppleSucks</h1>";
        echo "<form action='#' method='post' id='Forms-to-check'>";
        for ($i = 0; $i < count($this->find_forms_on_website()); $i++) {
            $form_name = $this->get_form_name($this->find_forms_on_website()[$i]);
            if (isset($_POST["_" . $form_name . "_"])) {
                echo "<input type='checkbox' name='$form_name' checked> " . $form_name . "<a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=".$form_name."'>Export</a>" . "<br>";
            } else {
                echo "<input type='checkbox' name='$form_name'> " . $form_name . "<a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=".$form_name."'>Export</a>" . "<br>";
            }

            $this->form_names[] = $form_name;
        }
        echo "<input type='submit' name='submitbtn'></form>";

        if(isset($_POST['submitbtn'])) {
            $formnames = array();
            foreach ($_POST as $key => $value) {
                if(strcmp($key, 'submitbtn')) {
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
                foreach($this->find_forms_on_website_full_code() as $key3 => $value2) {
                    $comp = $this->get_form_name($value2);
                    if($key == $comp) {
                        $this->change_action($key);
                        foreach ($this->get_input_tag_names_and_type($value2) as $key2 => $value) {
                            $splitstring = explode(";", $value);
                            $query .= "`" . $splitstring[0] . "`" . " " . $this->suggest_mysql_datatype($splitstring[1]) . ", ";
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

    function suggest_mysql_datatype($input) {
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

    function change_action($form_html){
        echo "<script> document.getElementById(" . $form_html . ").action = \"#\"; </script>";
    }

    function get_form_name_from_code($html) {
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $form = $dom->getElementsByTagName('form')->item(0);
        return $form->getAttribute('name');
    }

    function find_forms_on_website() {
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

    function find_forms_on_website_full_code() {
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

    function get_input_tag_names($form_html) {
        $input_tag_names = array();

        // Load the HTML form using the DOMDocument class
        $dom = new DOMDocument();
        @$dom->loadHTML($form_html);

        // Get all input elements in the form
        $input_tags = $dom->getElementsByTagName('input');

        // Loop through each input element and extract the name attribute
        foreach ($input_tags as $input) {
            $name = $input->getAttribute('name');
            $type = $input->getAttribute('type');
            if (!empty($name)) {
                $input_tag_names[] = $name;
            }
        }

        return $input_tag_names;
    }

    function get_input_tag_names_and_type($form_html) {
        $input_tag_names = array();

        // Load the HTML form using the DOMDocument class
        $dom = new DOMDocument();
        @$dom->loadHTML($form_html);

        // Get all input elements in the form
        $input_tags = $dom->getElementsByTagName('input');

        // Loop through each input element and extract the name attribute
        foreach ($input_tags as $input) {
            $name = $input->getAttribute('name');
            $type = $input->getAttribute('type');
            if (!empty($name)) {
                $input_tag_names[] = $name . ";" . $type;
            }
        }

        return $input_tag_names;
    }

    function get_form_name($form)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($form);
        $form_name = $doc->getElementsByTagName('form')->item(0)->getAttribute('name');
        return $form_name;
    }
}

if( class_exists('KarrieretagPlugin' ) ) {
    $karrieretagPlugin = new KarrieretagPlugin();
}

register_activation_hook(__FILE__, array($karrieretagPlugin, 'activate'));

register_activation_hook(__FILE__, array($karrieretagPlugin, 'deactivate'));
?>
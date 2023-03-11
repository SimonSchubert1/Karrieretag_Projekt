<?php
    /*
    * Plugin Name: AppleSucks
    * Description: Handle the basics with this plugin.
    * Version: 1.10.3
    * Requires at least: 5.2
    * Requires PHP: 7.2
    */
    add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

    function my_custom_dashboard_widgets() {
        wp_add_dashboard_widget('custom_help_widget', 'AppleSucks', 'custom_dashboard_help');
    }

    function custom_dashboard_help() {
        toString();
        write_in_database();
    }

    function define_forms(){
        $args = array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $posts = get_posts($args);

        $submissions = array();

        foreach ($posts as $post) {
            // Check if the post ID is in the specified form IDs
            if (in_array($post->ID, set_forms_for_Database())) {
                // Use regular expression to extract form submissions
                preg_match_all('/<form.*<\/form>/siU', $post->post_content, $matches);
                foreach ($matches[0] as $match) {
                    // Process and store the form submissions as needed
                    $submissions[] = process_form_submissions($match);
                }
            }
        }

        return $submissions;
    }

    function write_in_database(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'DataFromSubmissions';

        foreach (define_forms() as $data) {
            $wpdb->insert($table_name, $data);
        }

        /*$dsn = 'mysql:host=localhost;dbname=wordpress;charset=utf8mb4';
        $username = 'wordpress';
        $password = 'Pa$$word1234';
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        );
        $pdo = new PDO($dsn, $username, $password, $options);

// Prepare the SQL statement
        $stmt = $pdo->prepare('INSERT INTO mytable (column1, column2, column3) VALUES (:value1, :value2, :value3)');

// Bind the parameter values
        $value1 = 'some value';
        $value2 = 123;
        $value3 = date('Y-m-d H:i:s');
        $stmt->bindParam(':value1', $value1);
        $stmt->bindParam(':value2', $value2);
        $stmt->bindParam(':value3', $value3);

// Execute the SQL statement
        $stmt->execute();
        */
    }

    function set_forms_for_Database(){
        $forms = array();

        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                if($value == "on") {
                    $forms[] = $key;
                }
            }
        }

        return $forms;
    }

    function toString(){
        /*if (isset($_POST['submit'])) {
            $data = array();
            if(!empty($_POST)){
                foreach($_POST as $key => $value){
                    $data[$key] = $value;
                }
            }

            update_option('my_dashboard_widget_data', $data);
        }

        $data = get_option('my_dashboard_widget_data');*/

        echo "<form method='post'>";
        for($i = 0; $i < count(find_forms_on_website()); $i++){
            $form_name = get_form_name(find_forms_on_website()[$i]);
            echo "<input type='checkbox' name='.$form_name.'> " . $form_name . " <input type='button' value='putout'>" ."<br>";
        }
        echo "<input type='submit'></form>";
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

    function get_form(){

    }

    function get_form_name($form)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($form);
        $form_name = $doc->getElementsByTagName('form')->item(0)->getAttribute('name');
        return $form_name;
    }
?>
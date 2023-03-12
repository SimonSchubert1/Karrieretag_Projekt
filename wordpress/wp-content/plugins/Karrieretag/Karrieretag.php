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
        wp_add_dashboard_widget('custom_help_widget', 'AppleSucks', 'custom_widget');
    }

    function custom_widget() {
        toString();
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
        echo "<form method='post' id='Forms-to-check'>";
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

    function get_form_name($form)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($form);
        $form_name = $doc->getElementsByTagName('form')->item(0)->getAttribute('name');
        return $form_name;
    }
?>
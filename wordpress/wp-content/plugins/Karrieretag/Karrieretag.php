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
        global $wp_meta_boxes;

        wp_add_dashboard_widget('custom_help_widget', 'AppleSucks', 'custom_dashboard_help');
    }

    function custom_dashboard_help() {
        toString();
        //$array  = array('title' => 'contact', 'checked' => 'true');

        foreach ($_POST as $key => $value) {
            // Preprocess $key which holds name of input field
            // You can apply your logic to process value for an input $key here
            // From your example it looks like name is a number so special case can check within a condition for $key as number

            echo $key . " = " . $value;
        }

        echo $_POST["contact"];
    }

    function toString(){
        echo "<form name='myForm' method='post' acton=''>";
        for($i = 0; $i < count(find_forms_on_website()); $i++){
            $form_name = get_form_name(find_forms_on_website()[$i]);
            echo "<input type='checkbox' . $form_name . > " . $form_name . " <input type='button' value='putout'>" ."<br>";
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

    /*public function form($instance) {
    $title = isset($instance['title']) ? $instance['title'] : '';
    $checked = isset($instance['checked']) ? $instance['checked'] : false;
    $submitted = isset($_POST[$this->get_field_name('submitted')]) ? true : false;
    $data = isset($_POST[$this->get_field_name('data')]) ? $_POST[$this->get_field_name('data')] : '';

    ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('checked'); ?>"><?php _e('Checkbox:'); ?></label>
        <input id="<?php echo $this->get_field_id('checked'); ?>" name="<?php echo $this->get_field_name('checked'); ?>" type="checkbox" value="1" <?php checked($checked, true); ?>>
    </p>
    <p>
        <input type="hidden" name="<?php echo $this->get_field_name('submitted'); ?>" value="1" />
        <input type="text" name="<?php echo $this->get_field_name('data'); ?>" value="<?php echo esc_attr($data); ?>" />
        <input type="submit" value="<?php _e('Save'); ?>" class="button button-primary" />
    </p>
    <?php
    if ($submitted) {
        echo '<p>Submitted data: ' . $data . '</p>';
    }
}*/
?>
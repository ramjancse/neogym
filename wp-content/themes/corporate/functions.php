<?php

use const Avifinfo\NOT_FOUND;

if (!function_exists('mythemeFunction')) {
    function mythemeFunction()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));
    }
    load_theme_textdomain("neogymtextdomain", get_template_directory() . '/languages');
}
register_nav_menus(array(
    'top_menu' => __("Top Menue", "neogymtextdomain")
));

// Add custom class to <li> elements in the menu
if (!function_exists('neogymliclassadd')) {
    function neogymliclassadd($classes, $item, $args)
    {
        if (isset($args->add_li_class)) {
            $classes[] = $args->add_li_class;
        }
        if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
            $classes[] = 'active'; // Add 'active' class to the current menu item
        }
        return $classes;
    }
}
add_filter('nav_menu_css_class', 'neogymliclassadd', 10, 3);

// Add custom attributes to <a> elements in the menu
if (!function_exists('neogymaclassadd')) {
    function neogymaclassadd($atts, $item, $args)
    {
        if (isset($args->add_a_class)) {
            $atts['class'] = $args->add_a_class;
        }
        return $atts;
    }
}
add_filter('nav_menu_link_attributes', 'neogymaclassadd', 10, 3);

add_action('after_setup_theme', 'mythemeFunction');

if (!function_exists('neogym_service')) {
    function neogym_service()
    {
        register_post_type('service', array(
            'labels' => array(
                'name' => __('Services', 'neogymtextdomain'),
                'singular_name' => __('Service', 'neogymtextdomain'),
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
        ));
    }
}
add_action('init', 'neogym_service');

// Students

if (!function_exists('neogym_students')) {
    function neogym_students()
    {
        register_post_type('students', array(
            'labels' => array(
                'name' => __('Students', 'neogymtextdomain'),
                'singular_name' => __('Student', 'neogymtextdomain'),
                'add_new_item' => __('Add New Student', 'neogymtextdomain'),
                'not_found' => __('No Students Found', 'neogymtextdomain'),
                'not_found_in_trash' => __('No Students Found in Trash', 'neogymtextdomain'),
                'set_featured_image' => __('Add Student Image', 'neogymtextdomain'),
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('mystudentdepartment', 'post_tag'),
            'has_archive' => true,
        ));
    }
}
add_action('init', 'neogym_students');

// add texonomy for students

if (!function_exists('mystudentdepartment')) {
    function mystudentdepartment()
    {
        $labels = array(
            'name' => _x('students', 'neogymtextdomain'),
            'singular_name' => _x('student', 'neogymtextdomain'),
            'search_items' => __('Search students'),
            'all_items' => __('All Students'),
            'parent_item' => __('Parent Students'),
            'parent_item_colon' => __('Parent Students'),
            'add_new_item' => __('Add New Department'),
            'edit_item' => __('Edit Students'),
            'update_item' => __('Update Students'),
            'new_item_name' => __('New Student Name'),
            'menu_name' => __('Student Department'),
        );
        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'neogym_student'),
        );
        register_taxonomy('mystudentdepartment', ['students'], $args);
    }
}
add_action('init', 'mystudentdepartment');

//schort code
if (!function_exists('myword')) {
    function myword()
    {
        add_shortcode('bestword', 'mybestword');
        if (!function_exists('mybestword')) {
            function mybestword()
            {
                return "Hello from Short code";
            }
        }
    }
}

add_action('init', 'myword');

function addmission_form(){
    add_shortcode('addmission', 'addmission_form_html');

    function addmission_form_html(){
        $html = '<form action="" method="post">
        <input type="text" name="name" placeholder="Enter Your Name">
        <input type="email" name="email" placeholder="Enter Your Email">
        <input type="text" name="phone" placeholder="Enter Your Phone">
        <input type="submit" value="Submit">
        </form>';
        return $html;
    
    }
}


add_action('init', 'addmission_form');

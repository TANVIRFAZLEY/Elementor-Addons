<?php
function cptui_register_my_cpts_sermon() {

    /**
     * Post Type: Sermons.
     */

    $labels = [
        "name"          => __( "Sermons", "sermon" ),
        "singular_name" => __( "Sermon", "sermon" ),
        "all_items"     => __( "All Sermons", "sermon" ),
        "add_new_item"  => __( "Add New Sermon", "sermon" ),
        "add_new"       => __( "Add New Sermon", "sermon" ),
    ];

    $args = [
        "label"                 => __( "Sermons", "sermon" ),
        "labels"                => $labels,
        "description"           => "",
        "public"                => true,
        "publicly_queryable"    => true,
        "show_ui"               => true,
        "show_in_rest"          => true,
        "rest_base"             => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive"           => true,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "delete_with_user"      => false,
        "exclude_from_search"   => false,
        "capability_type"       => "post",
        "map_meta_cap"          => true,
        "hierarchical"          => false,
        "query_var"             => true,
        "menu_icon"             => "dashicons-video-alt2",

        "supports"              => ["title", "editor", "thumbnail"],
        //"taxonomies" => array("category"),
    ];

    register_post_type( "sermon", $args );
}

add_action( 'init', 'cptui_register_my_cpts_sermon' );

// custom taxonomy
function sermon_custom_taxonomy() {
    register_taxonomy( 'sermon_cat', 'sermon', array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'          => 'Sermon Categories',
            'singular_name' => 'Sermon category',
            'all_items'     => __( 'All Sermons' ),
            'add_new_item'  => __( 'Add New category' ),
            'menu_name'     => __( 'Sermon Categories' ),
        ),
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_in_rest'      => true,
        // Control the slugs used for this taxonomy
        'rewrite'           => array(
            'slug'         => 'sermon_cat',
            'with_front'   => false,
            'hierarchical' => true,
        ),
    ) );
}
add_action( 'init', 'sermon_custom_taxonomy' );
//permalink flush
register_activation_hook( __FILE__, 'sermon_rewrite_flush' );
function sermon_rewrite_flush() {
    cptui_register_my_cpts_sermon();
    flush_rewrite_rules();
}
<?php

function sermon_post_type_template( $single_template ) {
    global $post;

    if ( "sermon" == $post->post_type ) {
        $file_path = plugin_dir_path( __FILE__ ) . "templates/single-sermon.php";
        $single_template = $file_path;
    }
    return $single_template;

}
add_filter( 'single_template', 'sermon_post_type_template' );

function sermon_archive_template( $template ) {
// If the current url is an archive of any kind
    if ( is_archive() ) {
// Set this to the template file inside your plugin folder

        $template = plugin_dir_path( __FILE__ ) . "templates/archive-sermon.php";
    }
// Always return, even if we didn't change anything
    return $template;
}
add_filter( 'template_include', 'sermon_archive_template' );

function sermon_enqueue_scripts() {

    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap' );
    wp_enqueue_style( 'fontawesome-css', plugins_url( 'assets/css/fontawesome.min.css', __FILE__ ), '', '1.0' );
    wp_enqueue_style( 'bootstrap-css', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ), '', '1.0' );
    wp_enqueue_style( 'lity-css', plugins_url( 'assets/css/lity.min.css', __FILE__ ), '', '1.0' );
    wp_enqueue_style( 'mediaelements-css', plugins_url( 'assets/css/mediaelementplayer.min.css', __FILE__ ), '', '1.0' );
    wp_enqueue_style( 'sermon_main-css', plugins_url( 'assets/css/style.css', __FILE__ ), '', '1.0' );

    wp_enqueue_script( 'popper-js', plugins_url( 'assets/js/popper.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'bootstrap-js', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'lity-js', plugins_url( 'assets/js/lity.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'mediaelements-js', plugins_url( 'assets/js/mediaelement.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'sermon-js', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), '1.0', true );

}
add_action( 'wp_enqueue_scripts', 'sermon_enqueue_scripts' );

function sermon_single_add_new_image_size() {
    add_image_size( 'sermon_single_post_img', 940, 550, true ); //mobile
}
add_action( 'init', 'sermon_single_add_new_image_size' );
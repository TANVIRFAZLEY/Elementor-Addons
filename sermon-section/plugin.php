<?php

//Class Plugin
class SermonPlugin {

    //Instance
    private static $_instance = null;

    /**
     * Instance
     * Ensures only one instance of the class is loaded or can be loaded.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function widget_category( $elements_manager ) {
        $elements_manager->add_category(
            'sermon-category',
            [
                'title' => __( 'Sermon Categories', 'sermon-section' ),
                'icon'  => 'eicon-video-camera',
            ]
        );
    }

    /**
     * Include Widgets files
     * Load widgets files
     */
    private function include_widgets_files() {
        require_once __DIR__ . '/widgets/sermon-widget.php';
    }

    /**
     * Register Widgets
     * Register new Elementor widgets.
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();

        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \SermonWidgets() );
    }

    /**
     *  Plugin class constructor
     * Register plugin action hooks and filters
     */
    public function __construct() {

        // Register Widgets Category
        add_action( 'elementor/elements/categories_registered', [$this, 'widget_category'] );
        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets'] );
    }
}

// Instantiate Plugin Class
SermonPlugin::instance();
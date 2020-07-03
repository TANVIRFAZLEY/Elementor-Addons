<?php

    use Elementor\Widget_Base;

    //use \Sermon_Scheme_Color as Sermon_Color;

    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }
    // Exit if accessed directly

    class SermonWidgets extends Widget_Base {

        //widget id
        public function get_name() {
            return 'sermon-addons';
        }

        //widget id
        public function get_title() {
            return __( 'Sermon Post', 'sermon-section' );
        }

        //widget id
        public function get_icon() {
            return 'eicon-video-camera';
        }

        //widget id
        public function get_categories() {
            return ['sermon-category'];
        }

        //register_controls
        protected function _register_controls() {
            $typo_weight_options = [
                '' => __( 'Default', 'sermon-section' ),
            ];
            foreach ( array_merge( ['normal', 'bold'], range( 100, 900, 100 ) ) as $weight ) {
                $typo_weight_options[$weight] = ucfirst( $weight );
            }

            $this->start_controls_section(
                'section_layout',
                [
                    'label' => esc_html__( 'Layout', 'sermon-section' ),
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label'              => __( 'Columns', 'sermon-section' ),
                    'type'               => \Elementor\Controls_Manager::SELECT,
                    'default'            => '3',
                    'tablet_default'     => '2',
                    'mobile_default'     => '1',
                    'options'            => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                    ],
                    'prefix_class'       => 'elementor-grid%s-',
                    'frontend_available' => true,
                    'selectors'          => [
                        '{{WRAPPER}} .sermon-grid-container' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
                    ],
                ]
            );

            $this->add_control(
                'posts_per_page',
                [
                    'label'   => __( 'Posts Per Page', 'sermon-section' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 3,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name'         => 'post_thumbnail',
                    'exclude'      => ['custom'],
                    'default'      => 'full',
                    'prefix_class' => 'post-thumbnail-size-',
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label'   => __( 'Title HTML Tag', 'sermon-section' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default' => 'h3',
                ]
            );

            $this->add_control(
                'show_excerpt',
                [
                    'label'     => __( 'Excerpt', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'  => __( 'Show', 'sermon-section' ),
                    'label_off' => __( 'Hide', 'sermon-section' ),
                    'default'   => 'yes',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'excerpt_length',
                [
                    'label'     => __( 'Excerpt Length', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::NUMBER,
                    'default'   => 15,
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'content_align',
                [
                    'label'     => __( 'Alignment', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'   => [
                            'title' => __( 'Left', 'sermon-section' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'sermon-section' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'sermon-section' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .sermon' => 'text-align: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->end_controls_section();

            //query
            $this->start_controls_section(
                'section_query',
                [
                    'label' => __( 'Query', 'sermon-section' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            // Post categories
            $taxonomies = 'sermon_cat';
            $this->add_control(
                'post_categories',
                [
                    'label'       => __( 'Categories', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple'    => true,
                    'object_type' => $taxonomies,
                    'options'     => wp_list_pluck( get_terms( $taxonomies ), 'name', 'term_id' ),
                ]
            );

            $this->add_control(
                'advanced',
                [
                    'label' => __( 'Advanced', 'sermon-section' ),
                    'type'  => \Elementor\Controls_Manager::HEADING,
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label'   => __( 'Order By', 'sermon-section' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'post_date',
                    'options' => [
                        'post_date'  => __( 'Date', 'sermon-section' ),
                        'post_title' => __( 'Title', 'sermon-section' ),
                        'rand'       => __( 'Random', 'sermon-section' ),
                    ],
                ]
            );

            $this->add_control(
                'order',
                [
                    'label'   => __( 'Order', 'sermon-section' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'asc'  => __( 'ASC', 'sermon-section' ),
                        'desc' => __( 'DESC', 'sermon-section' ),
                    ],
                ]
            );

            $this->end_controls_section();

            /*
             ** Tab style
             */

            // Layout.
            $this->start_controls_section(
                'sermon_layout_style',
                [
                    'label' => __( 'Layout', 'sermon-section' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            // Columns margin.
            $this->add_control(
                'sermin_style_columns_margin',
                [
                    'label'     => __( 'Columns margin', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'default'   => [
                        'size' => 30,
                    ],
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

                    ],
                ]
            );

            // Row margin.
            $this->add_control(
                'sermin_style_rows_margin',
                [
                    'label'     => __( 'Rows margin', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'default'   => [
                        'size' => 30,
                    ],
                    'range'     => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );
            $this->end_controls_section();
            /*
             **Sermon Font Family
             */
            $this->start_controls_section(
                'sermon_typography',
                [
                    'label' => __( 'Sermon Typography & Color', 'sermon-section' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'sermon_font_familys',
                [
                    'label'       => __( 'Font Family', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::FONT,
                    'default'     => "'Libre Baskerville',sans-serif",
                    'description' => "Use serif font for better look like as ' Libre Baskerville '.",
                    'selectors'   => [
                        '{{WRAPPER}} .sermon-grid-container .entry-title, {{WRAPPER}} .sermon-grid-container p, {{WRAPPER}} .sermon-grid-container .sermon-author,{{WRAPPER}} .sermon-grid-container .time-date' => 'font-family: {{VALUE}}',
                    ],
                ]
            );
            /*
             **Sermon Title Typography
             */
            $this->add_control(
                'sermon_title_typography',
                [
                    'label'     => __( 'Title Typography', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',

                ]
            );

            $this->add_control(
                'sermon_title_font_size',
                [
                    'label'     => __( 'Font Size', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'default'   => [
                        'size' => 24,
                    ],
                    'range'     => [
                        'px' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon .entry-title h1, {{WRAPPER}} .sermon .entry-title h2, {{WRAPPER}} .sermon .entry-title h3, {{WRAPPER}} .sermon .entry-title h4, {{WRAPPER}} .sermon .entry-title h5, {{WRAPPER}} .sermon .entry-title h6' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_control(
                'sermon_title_font_weight',
                [
                    'label'     => __( 'Font Weight', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => '',
                    'options'   => $typo_weight_options,
                    'selectors' => [
                        '{{WRAPPER}} .sermon .entry-title h1, {{WRAPPER}} .sermon .entry-title h2, {{WRAPPER}} .sermon .entry-title h3, {{WRAPPER}} .sermon .entry-title h4, {{WRAPPER}} .sermon .entry-title h5, {{WRAPPER}} .sermon .entry-title h6' => 'font-weight: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_title_font_color',
                [
                    'label'       => __( 'Font Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #1c2647 '",
                    'default'     => '#1c2647',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon .entry-title a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_title_font_color_hover',
                [
                    'label'       => __( 'Hover Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #1c2647 '",
                    'default'     => '#1c2647',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon .entry-title a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'important_note_title',
                [
                    'label'           => __( 'Note', 'sermon-section' ),
                    'show_label'      => false,
                    'type'            => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>Note :</strong> Default font color and hover color " #1c2647 "', 'sermon-section' ),
                    'content_classes' => 'your-class',
                ]
            );
            /*
             *Sermon Metadata Typography
             */
            $this->add_control(
                'sermon_metadata_typography',
                [
                    'label'     => __( 'Metadata Typography', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'sermon_metadata_font_size',
                [
                    'label'     => __( 'Font Size', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'default'   => [
                        'size' => 14,
                    ],
                    'range'     => [
                        'px' => [
                            'min' => 10,
                            'max' => 30,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon-author, {{WRAPPER}} .time-date' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_metadata_font_weight',
                [
                    'label'     => __( 'Font Weight', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => '',
                    'options'   => $typo_weight_options,
                    'selectors' => [
                        '{{WRAPPER}} .sermon-author, {{WRAPPER}} .time-date' => 'font-weight: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_metadata_font_style',
                [
                    'label'     => __( 'Font Style', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => 'italic',
                    'options'   => [
                        'normal'  => __( 'Normal', 'sermon-section' ),
                        'italic'  => __( 'Italic', 'sermon-section' ),
                        'oblique' => __( 'Oblique', 'sermon-section' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon-author, {{WRAPPER}} .time-date' => 'font-style: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_metadata_font_color',
                [
                    'label'       => __( 'Font Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #1c2647 '",
                    'default'     => '#6a7a83',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon-author, {{WRAPPER}} .time-date' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_metadata_link_color',
                [
                    'label'       => __( 'Link Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #6a7a83 '",
                    'default'     => '#1c2647',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon-author a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'sermon_metadata_link_color_hover',
                [
                    'label'       => __( 'Hover Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #1c2647 '",
                    'default'     => '#1c2647',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon-author a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'important_note_meta',
                [
                    'label'           => __( 'Note', 'sermon-section' ),
                    'show_label'      => false,
                    'type'            => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>Note :</strong> Default font color " #6a7a83 " and link & hover color " #1c2647 "', 'sermon-section' ),
                    'content_classes' => 'your-class',
                ]
            );

            /*
             *Sermon Metadata Typography
             */
            $this->add_control(
                'sermon_excerpt_typography',
                [
                    'label'     => __( 'Excerpt Typography', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'sermon_excerpt_font_size',
                [
                    'label'     => __( 'Font Size', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'default'   => [
                        'size' => 15,
                    ],
                    'range'     => [
                        'px' => [
                            'min' => 10,
                            'max' => 30,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon .entry-content p' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'sermon_excerpt_font_weight',
                [
                    'label'     => __( 'Font Weight', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => '',
                    'options'   => $typo_weight_options,
                    'selectors' => [
                        '{{WRAPPER}} .sermon .entry-content p' => 'font-weight: {{VALUE}}',
                    ],
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'sermon_excerpt_font_style',
                [
                    'label'     => __( 'Font Style', 'sermon-section' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => 'normal',
                    'options'   => [
                        'normal'  => __( 'Normal', 'sermon-section' ),
                        'italic'  => __( 'Italic', 'sermon-section' ),
                        'oblique' => __( 'Oblique', 'sermon-section' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sermon .entry-content p' => 'font-style: {{VALUE}}',
                    ],
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'sermon_excerpt_font_color',
                [
                    'label'       => __( 'Font Color', 'sermon-section' ),
                    'type'        => \Elementor\Controls_Manager::COLOR,
                    'description' => "Default color ' #6a7a83 '",
                    'default'     => '#6a7a83',
                    'selectors'   => [
                        '{{WRAPPER}} .sermon .entry-content p' => 'color: {{VALUE}}',
                    ],
                    'condition'   => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'important_note_excerpt',
                [
                    'label'           => __( 'Note', 'sermon-section' ),
                    'show_label'      => false,
                    'type'            => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'             => __( '<strong>Note :</strong> Default font color " #6a7a83 "', 'sermon-section' ),
                    'content_classes' => 'your-class',
                    'condition'       => [
                        'show_excerpt' => 'yes',
                    ],
                ]

            );

            $this->end_controls_section(); //end metadata typography
        }

        //display
        protected function render() {
            $settings = $this->get_settings_for_display();
            $posts_per_page = ( !empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : 3 );
            $excerpt_length = ( !empty( $settings['excerpt_length'] ) ? $settings['excerpt_length'] : 15 );
            $title_tag = $settings['title_tag'];
            $post_thumbnail_size = $settings['post_thumbnail_size'];
            $show_excerpt = $settings['show_excerpt'];
            $orderby = $settings['orderby'];
            $order = $settings['order'];
            $post_categories = $settings['post_categories'];
            $args = array(
                'post_type'           => 'sermon',
                'posts_per_page'      => absint( $posts_per_page ),
                'post__not_in'        => get_option( 'sticky_posts' ),
                'ignore_sticky_posts' => true,
            );
            // Order by.
            if ( !empty( $orderby ) ) {
                $args['orderby'] = $settings['orderby'];
            }
            // Order .
            if ( !empty( $order ) ) {
                $args['order'] = $settings['order'];
            }
            //category post
            if ( !empty( $post_categories ) ) {
                $args['tax_query'][] = [
                    'taxonomy' => 'sermon_cat',
                    'field'    => 'term_id',
                    'terms'    => $post_categories,
                ];
            }
            $sermon_query = new WP_Query( $args );
            echo '<div class="sermon-grid-container">';
            if ( $sermon_query->have_posts() ) {
                while ( $sermon_query->have_posts() ) {
                    $sermon_query->the_post();
                    $post_title = get_the_title();
                    $post_link = get_the_permalink();
                    $author_url = get_author_posts_url( get_the_author_meta( "ID" ) );
                    $author_name = get_the_author();
                    $post_date = get_the_date( "F j, Y" );
                    //metabox value
                    $video_link = get_post_meta( get_the_ID(), 'sermon_video', true );
                    $audio_link = get_post_meta( get_the_ID(), 'sermon_audio_url', true );
                    $pdf_link = get_post_meta( get_the_ID(), 'sermon_pdf_url', true );
                ?>
<article class="sermon">
    <?php if ( has_post_thumbnail() ): ?>
    <div class="sermon-feature-img">
        <a class="post-image-class" href="<?php echo esc_url( $post_link ); ?>">
            <?php the_post_thumbnail( $post_thumbnail_size );?>
        </a>
    </div>
    <?php endif;?>
    <div class="sermon-media">
        <?php if ( !empty( $video_link ) ): ?>
        <a href="<?php echo esc_url( $video_link ); ?>" data-lity><i class="fa fa-video-camera"></i></a>
        <?php endif;?>
        <?php if ( !empty( $audio_link ) ): ?>
        <!-- hide show audio-wrap -->
        <a class="on-off" href="#0"><i class="fa fa-headphones"></i></a>
        <!-- audio-wrap -->
        <div class="audio-wrap">
            <audio preload="auto" id="player" src="<?php echo esc_url( $audio_link ); ?>" width="100%" height="41"
                controls="controls"></audio>
        </div>
        <?php endif;?>
        <?php if ( !empty( $pdf_link ) ): ?>
        <a href="<?php echo esc_url( $pdf_link ); ?>" download="post"><i class="fa fa-cloud"></i></a>
        <a target="_blank" href="<?php echo esc_url( $pdf_link ); ?>"><i class="fa fa-file"></i></a>
        <?php endif;?>
    </div>
    <hr class="sermon-post-hr">
    <div class="entry-title">
        <<?php echo $title_tag; ?>><a
                href="<?php echo esc_url( $post_link ); ?>"><?php echo esc_html( $post_title ); ?></a>
        </<?php echo $title_tag; ?>>
    </div>
    <div class="sermon-author">
        <?php _e( 'Speaker', 'sermon-section' );?>: <a
            href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
    </div>
    <span class="time-date"><?php echo esc_html( $post_date ); ?></span>
    <hr class="sermon-post-hr">
    <?php if ( 'yes' == $show_excerpt ): ?>
    <div class="entry-content">
        <p><?php echo wp_trim_words( get_the_content(), absint( $excerpt_length ), '' ); ?></p>
    </div>
    <?php endif;?>
</article>
<?php
    }
            }
            wp_reset_postdata();
            echo '</div>';
        }

        //display with js
        protected function _content_template() {

    }
}
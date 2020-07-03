<?php get_header();
    $video_link = get_post_meta( get_the_ID(), 'sermon_video', true );
    $audio_link = get_post_meta( get_the_ID(), 'sermon_audio_url', true );
    $pdf_link = get_post_meta( get_the_ID(), 'sermon_pdf_url', true );
?>

<div class="container sermon_archive">
    <div class="row">
        <div class="col-md-12">
            <div class="archive_sermon text-center">
                <h2><?php _e( 'Sermon Archive', 'sermon-section' );?></h2>
            </div>
            <div class="row">

                <?php

                    // WP_Query arguments
                    $args = array(
                        'post_type' => 'sermon',
                    );

                    // The Query
                    $sermon_query = new WP_Query( $args );

                    // The Loop
                    if ( $sermon_query->have_posts() ) {
                        while ( $sermon_query->have_posts() ) {
                            $sermon_query->the_post();
                        ?>
                <div class="col-md-4">
                    <div class="sermon-margin">
                        <article class="sermon">
                            <?php if ( has_post_thumbnail() ): ?>
                            <div>
                                <?php the_post_thumbnail( 'full' );?>
                            </div>
                            <?php endif;?>
                            <div class="sermon-media">
                                <?php if ( !empty( $video_link ) ): ?>
                                <a href="<?php echo esc_url( $video_link ); ?>" data-lity><i
                                        class="fa fa-video-camera"></i></a>
                                <?php endif;?>
                                <?php if ( !empty( $audio_link ) ): ?>
                                <!-- hide show audio-wrap -->
                                <a class="on-off" href="#0"><i class="fa fa-headphones"></i></a>
                                <!-- audio-wrap -->
                                <div class="audio-wrap">
                                    <audio preload="auto" id="player" src="<?php echo esc_url( $audio_link ); ?>"
                                        width="100%" height="41" controls="controls"></audio>
                                </div>
                                <?php endif;?>
                                <?php if ( !empty( $pdf_link ) ): ?>
                                <a href="<?php echo esc_url( $pdf_link ); ?>" download="post"><i
                                        class="fa fa-cloud"></i></a>
                                <a target="_blank" href="<?php echo esc_url( $pdf_link ); ?>"><i
                                        class="fa fa-file"></i></a>
                                <?php endif;?>
                            </div>
                            <hr class="sermon-post-hr">
                            <div class="entry-title">
                                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                            </div>
                            <div class="sermon-author">
                                <?php _e( 'Speaker', 'sermon-section' );?>: <a
                                    href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ); ?>"><?php the_author();?></a>
                            </div>
                            <span class="time-date"><?php echo esc_html( get_the_date( "F j, Y" ) ); ?></span>
                            <hr class="sermon-post-hr">
                            <div class="entry-content">
                                <p><?php echo wp_trim_words( get_the_content(), 20, '' ); ?></p>
                            </div>
                        </article>
                    </div>
                </div>

                <?php

                        }
                    }
                    // Restore original Post Data
                    wp_reset_postdata();

                ?>



            </div>
        </div>
    </div>
</div>
</div>
<?php get_footer();?>
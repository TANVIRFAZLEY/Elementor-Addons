<?php get_header();
the_post();
//metabox value
$video_link = get_post_meta(get_the_ID(), 'sermon_video', true);
$audio_link = get_post_meta(get_the_ID(), 'sermon_audio_url', true);
$pdf_link = get_post_meta(get_the_ID(), 'sermon_pdf_url', true);

?>

<div class="section-padding sermon_single_page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="single-sermon-title text-center">
                    <h2><?php the_title();?></h2>
                </div>
            </div>
            <div class=" col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <article class="sermon">
                            <span class="time-date"><?php echo esc_html(get_the_date("F j, Y")); ?></span>
                            <hr class="single-sermon-hr">
                            <div class="sermon-author">
                                <?php _e('Speaker', 'sermon-section');?>: <a
                                    href="<?php echo esc_url(get_author_posts_url(get_the_author_meta("ID"))); ?>"><?php the_author();?></a>
                            </div>
                            <?php if (has_post_thumbnail()): ?>
                            <div>
                                <?php the_post_thumbnail('sermon_single_post_img', ['class' => 'sermon-single-feature-img']);?>
                            </div>
                            <?php endif;?>
                            <div class="sermon-media single-sermon-media">
                                <?php if (!empty($video_link)): ?>
                                <a href="<?php echo esc_url($video_link); ?>" data-lity><i
                                        class="fa fa-video-camera"></i><?php _e('Watch', 'sermon-section');?></a>
                                <?php endif;?>

                                <?php if (!empty($audio_link)): ?>
                                <a id="on-off" class="on-off" href="#0"><i class="fa fa-headphones"></i><?php _e('lisent', 'sermon-section');?></a>
                                <div class="audio-wrap">
                                    <audio preload="auto" id="player" src="<?php echo esc_url($audio_link); ?>"
                                        width="100%" height="41" controls="controls"></audio>
                                </div>
                                <?php endif;?>

                                <?php if (!empty($pdf_link)): ?>
                                <a href="<?php echo esc_url($pdf_link); ?>" download="post"><i
                                        class="fa fa-cloud"></i><?php _e('download', 'sermon-section');?></a>
                                <?php endif;?>

                                <?php if (!empty($pdf_link)): ?>
                                <a target="_blank" href="<?php echo esc_url($pdf_link); ?>"><i
                                        class="fa fa-file"></i><?php _e('PDF', 'sermon-section');?></a>
                                <?php endif;?>
                            </div>
                            <div class="entry-content">
                                <?php the_content();?>
                            </div>
                            <hr class="sermon-post-hr">
                        </article>


                    </div>
                    <div class="col-md-6">
                        <?php

$philosophy_prev_post = get_previous_post();
$philosophy_next_post = get_next_post();
?>
                        <?php if ($philosophy_prev_post): ?>
                        <div class="sermon-post-nav">
                            <a href="<?php echo esc_url(get_the_permalink($philosophy_prev_post)); ?>">
                                <i class="fa fa-arrow-left"></i>
                                <span><?php _e('Previous sermon Link', 'sermon-section');?></span>
                                <?php echo esc_html(get_the_title($philosophy_prev_post)); ?>
                            </a>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="col-md-6">
                        <?php if ($philosophy_next_post): ?>
                        <div class="sermon-post-nav next text-right">
                            <a href="<?php echo esc_url(get_the_permalink($philosophy_next_post)); ?>">
                                <i class="fa fa-arrow-right"></i>
                                <span><?php _e('Next sermon Link', 'sermon-section');?></span>
                                <?php echo esc_html(get_the_title($philosophy_next_post)); ?>
                            </a>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="col-md-12">
                        <hr class="sermon-post-hr">
                        <div class="more-sermon">
                            <h3 class="more-sermon-title"><?php _e('More sermons', 'sermon-section');?></h3>
                            <div class="row">
                                <?php

// WP_Query arguments
$args = array(
	'post_type' => 'sermon',
	'posts_per_page' => 4,
);

// The Query
$sermon_query = new WP_Query($args);

// The Loop
if ($sermon_query->have_posts()) {
	while ($sermon_query->have_posts()) {
		$sermon_query->the_post();
		?>

                                <div class="col-md-3">
                                    <div class="more-single-sermon">
                                        <a href="<?php the_permalink();?>">
                                            <?php the_post_thumbnail('medium');?>
                                        </a>
                                        <span
                                            class="time-date"><?php echo esc_html(get_the_date("F j, Y")); ?></span>
                                        <h3 class="sermon-more-title"><a
                                                href="<?php the_permalink();?>"><?php the_title();?></a></h3>
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
        </div>
    </div>
</div>

<?php get_footer();?>
<?php
/*
Template Name: Événement
*/

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <div class="event">
            <div class="event-header">
                <div>
                    <h3>Événement</h3>
                    <h1><?php the_title(); ?></h1>
                    <h4><?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?></h4>
                </div>
                <div>
                    <a href="<?php echo get_post_meta( get_the_ID(), 'ticket_link', true ); ?>" target="_blank">
                        Billeterie
                    </a>
                </div>
            </div>
            <div class="event-content">
                <img src="<?php echo get_post_meta( get_the_ID(), 'slider_image', true ); ?>" />
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    endwhile;
else :
    // Aucun événement trouvé
    ?>
    <p>Aucun événement trouvé.</p>
    <?php
endif;

get_footer();
?>
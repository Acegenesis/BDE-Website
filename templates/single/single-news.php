<?php
/*
Template Name: News
*/

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <div class="event">
            <div class="event-header">
                <div>
                    <h3>News</h3>
                    <h1><?php the_title(); ?></h1>
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
    // Aucun news trouvé
    ?>
    <p>Aucune news trouvée.</p>
    <?php
endif;

get_footer();
?>
<?php
/*
Template Name: Événement
*/

get_header();

function get_post_title_by_id_and_type($post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === "associations") {
        return esc_html($post->post_title);
    }
    return '';
}

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <div class="event">
            <div class="event-header">
                <div>
                    <h3>Événement <?php echo get_post_title_by_id_and_type(get_post_meta( get_the_ID(), '_selected_assos', true ));?></h3>
                    <h1><?php the_title(); ?></h1>
                    <?php 
                        if (get_post_meta( get_the_ID(), 'event_date', true )):
                    ?>
                        <h4><?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?></h4>
                    <?php
                        else:
                    ?>
                        <h4>A venir<h4>
                    <?php   
                        endif;
                    ?>
                </div>
                <?php 
                    if (get_post_meta( get_the_ID(), 'ticket_link', true )):
                ?>
                <div>
                    <a href="<?php echo get_post_meta( get_the_ID(), 'ticket_link', true ); ?>" target="_blank">
                        Billeterie
                    </a>
                </div>
                <?php
                    endif;
                ?>
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
<?php
/*
Template Name: Liste des événements
*/

get_header();

// Récupérer les événements avec WP_Query
$event_per_page = 4; // Nombre d'événements par page
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type'      => 'events',
    'posts_per_page' => $event_per_page, // Nombre d'événements par page
    'paged'          => $paged, // Page actuelle
    'order'          => 'DESC', // Ordre décroissant (du plus récent au plus ancien)
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    ?>
    <h1>Liste des événements</h1>
    <div class="container">
        <?php
        while ( $query->have_posts() ) : $query->the_post();
            $event_url = get_permalink(); // URL de l'événement
            $event_id = get_the_ID();
            $slider_image = get_post_meta( $event_id, 'slider_image', true );
            $date = get_post_meta( $event_id, 'event_date', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php echo $event_url; ?>">
                    <?php if($date) : ?>
                    <h3><?php echo $date; ?></h3>
                    <?php endif; ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <img src="<?php echo $slider_image; ?>" alt="<?php the_title(); ?>" />
                    <div class="more">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                        </svg>
                    </div>
                </a>
            </article>
            <?php
        endwhile;
        if( $paged == $query->max_num_pages && $query->have_posts() % 2 != 0 ) :
            ?>
            <article>
            </article>
            <?php
            endif;
        ?>
    </div>
    <?php
    // Affichage de la pagination
    $big = 999999999;
    echo paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, $paged ),
        'total'     => $query->max_num_pages,
        'prev_text' => 'Précédent', // Texte pour le lien précédent
        'next_text' => 'Suivant', // Texte pour le lien suivant
        'mid_size'  => 1, // Nombre de liens à afficher de chaque côté de la page actuelle
        'type'      => 'list', // Type de format de pagination (ici une liste de balises <li>)
        'end_size'  => 1, // Nombre de liens à afficher aux extrémités
        'before_page_number' => '<span class="page-number">', // Balise avant le numéro de page
        'after_page_number' => '</span>', // Balise après le numéro de page
    ) );
    
    ?>
    <?php
    wp_reset_postdata(); // Réinitialiser la requête
else :
    // Aucun événement trouvé
    ?>
    <p>Aucun événement trouvé.</p>
    <?php
endif;

get_footer();
?>
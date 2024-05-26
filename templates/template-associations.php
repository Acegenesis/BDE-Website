<?php
/*
Template Name: Liste des associations
*/
get_header();
?>

<h1>Liste des associations</h1>
<div id="associations-container" class="container">
    <?php
    $paged = 1;
    // Initialisation de la requête pour afficher les premières associations
    $args = array(
        'post_type'      => 'associations',
        'posts_per_page' => 4, // Nombre d'associations par page
        'paged'          => $paged, // Page actuelle
        'order'          => 'DESC', // Ordre décroissant (de la plus récente a la plus ancienne)
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    $slider_image = get_post_meta(get_the_ID(), 'logo_image', true);
                    if ($slider_image) :
                    ?>
                        <img src="<?php echo esc_url($slider_image); ?>" alt="<?php the_title(); ?>" />
                    <?php endif; ?>
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
        if( $paged == $query->max_num_pages && $query->found_posts % 2 != 0 ) :
            ?>
            <article class="alone">
            </article>
        <?php
        endif;
        wp_reset_postdata();
    else :
        // Aucune association trouvé
        echo '<p>Aucune association trouvé.</p>';
    endif;
    if( $query->max_num_pages > 1 ) : ?>
        <button id="load-more-associations">Voir Plus</button>
    <?php endif; ?>
</div>
<script>
jQuery(document).ready(function($){
    var page = 1; // Numéro de page initial
    var maxPage = <?php echo $query->max_num_pages; ?>;

    $('#load-more-associations').click(function(){
        page++; // Incrémenter le numéro de page

        // Requête AJAX pour charger les associations suivants
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_more_associations', // Action WordPress
                page: page, // Numéro de page à charger
            },
            success: function(response) {
                if (response != '' && page < maxPage) {
                    $('#associations-container').append(response); // Ajouter les associations chargés à la fin du conteneur
                } else {
                    $('#associations-container').append(response); // Ajouter les associations chargés à la fin du conteneur
                    $('#load_more_associations').remove(); // Cacher le bouton Voir Plus
                }
            }
        });
    });
});
</script>
<?php
get_footer();
?>

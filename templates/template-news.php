<?php
/*
Template Name: Liste des news
*/
get_header();
?>

<h1>Liste des news</h1>
<div id="news-container" class="container">
    <?php
    $paged = 1;
    // Initialisation de la requête pour afficher les premières news
    $args = array(
        'post_type'      => 'news',
        'posts_per_page' => 4, // Nombre de news par page
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
                    $slider_image = get_post_meta(get_the_ID(), 'slider_image', true);
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
            <article>
            </article>
        <?php
        endif;
        wp_reset_postdata();
    else :
        // Aucune association trouvé
        echo '<p>Aucune news trouvé.</p>';
    endif;
    if( $query->max_num_pages > 1 ) : ?>
        <button id="load-more-news">Voir Plus</button>
    <?php endif; ?>
</div>
<script>
jQuery(document).ready(function($){
    var page = 1; // Numéro de page initial
    var maxPage = <?php echo $query->max_num_pages; ?>;

    $('#load-more-news').click(function(){
        page++; // Incrémenter le numéro de page

        // Requête AJAX pour charger les news suivants
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_more_news', // Action WordPress
                page: page, // Numéro de page à charger
            },
            success: function(response) {
                if (response != '' && page < maxPage) {
                    $('#news-container').append(response); // Ajouter les news chargés à la fin du conteneur
                } else {
                    $('#news-container').append(response); // Ajouter les news chargés à la fin du conteneur
                    $('#load_more_news').remove(); // Cacher le bouton Voir Plus
                }
            }
        });
    });
});
</script>
<?php
get_footer();
?>

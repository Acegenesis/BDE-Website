<?php 
get_header();

if(is_home()) :
$args = array(
    'post_type' => 'events',
    'meta_query' => array(
        array(
            'key' => 'slider_home',
            'value' => 'on',
            'compare' => '=',
        ),
    ),
);
$query = new WP_Query( $args );
$total_posts = $query->found_posts;

$argsPartenaires = array(
    'post_type' => 'partenaires',
);
$queryPartenaires = new WP_Query( $argsPartenaires );

?>
<section class="sliderhero">
    <div>
        <h2><?php echo get_option('textslider'); ?></h2>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php 
                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
            ?>
            <div class="swiper-slide">
                <h3>Event</h3>
                <h2><?php echo the_title() ?></h2>
                <img src="<?php echo get_post_meta( get_the_ID(), 'slider_image', true ); ?>" alt="Image <?php echo the_title() ?>">
                <a href="<?php echo get_permalink() ?>" title="Post <?php echo the_title() ?>"></a>
            </div>
            <?php 
                endwhile;
                wp_reset_postdata();
                else :
                    // Aucun post trouvé
                endif;
            ?>
        </div>
        <div class="arrows">
            <div class="prev" id="prev">01</div>
            <div class="next"><?php echo ($total_posts < 10) ? '0' . $total_posts : $total_posts ?></div>
        </div>
    </div>
</section>
<?php
    // Récupérer les entrées dynamiques
    $dynamic_entries = get_option('dynamic_entries', []);

    if (!empty($dynamic_entries)) {
?>
    <section class="presentation">
        <h2>Presentation du bde</h2>
        <div class="container">
            <?php
                foreach ($dynamic_entries as $entry) {
                    ?>
                    <div class="dynamic-entry">
                        <h3><?php echo esc_html($entry['title']); ?></h3>
                        <p><?php echo esc_html($entry['description']); ?></p>
                    </div>
                    <?php
                }
            ?>
        </div>
    </section>
<?php } ?>
<section class="partenaire">
    <h2>Nos partenaires</h2>
    <div class="gridPartenaires">
            <?php 
                if ( $queryPartenaires->have_posts() ) :
                    while ( $queryPartenaires->have_posts() ) : $queryPartenaires->the_post();
            ?>
            <a <?php echo (get_post_meta( get_the_ID(), 'url', true )) ? 'href="' . get_post_meta( get_the_ID(), 'url', true ) . '" target="_blank"' : ""; ?> title="<?php echo the_title() ?>" class="cardPartenaire">
                <img src="<?php echo get_post_meta( get_the_ID(), 'logo_image', true ); ?>" alt="Logo <?php echo the_title() ?>">
                </a>
            <?php 
                endwhile;
                wp_reset_postdata();
                else :
                    // Aucun post trouvé
                endif;
            ?>
    </div>
</section>

<script>
const swiper = new Swiper('.swiper', {
  loop: true,
  navigation: {
    nextEl: '.next',
    prevEl: '.prev',
  },
  direction: "vertical",
});

swiper.on('slideChange', function () {
    var activeIndex = swiper.realIndex + 1;
    document.getElementById('prev').innerHTML = (activeIndex < 10) ? "0" + activeIndex : activeIndex;
});

document.querySelector('.prev').addEventListener('click', function () {
    var activeIndex = swiper.realIndex + 1;
    document.getElementById('prev').innerHTML = (activeIndex < 10) ? "0" + activeIndex : activeIndex;
});

document.querySelector('.next').addEventListener('click', function () {
    var activeIndex = swiper.realIndex + 1;
    document.getElementById('prev').innerHTML = (activeIndex < 10) ? "0" + activeIndex : activeIndex;
});
</script>

<?php 
endif;

get_footer(); ?>

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
        <h2>Construisons la vie de notre campus ensemble</h2>
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
    </div>
    <div class="arrows">
        <div class="prev" id="prev">01</div>
        <div class="next"><?php echo ($total_posts < 10) ? '0' . $total_posts : $total_posts ?></div>
    </div>
</section>
<section class="presentation">
    <h2>Presentation du bde</h2>
    <div class="container">
        <div>
            <h3>Qu'est-ce qu'un BDE ?</h3>
            <p>Le Bureau Des Élèves (BDE) est une association à but non-lucratif qui a pour but de donner un cadre légal à toutes les manifestations extra-scolaires sur le campus.</p>
        </div>
        <div>
            <h3>Quel est son rôle ?</h3>
            <p>Le rôle du BDE est de fournir un cadre légal à toute organisation des manifestations. Il s’occupe aussi d’organiser des évènements, mais surtout, il accompagne les apprenants dans leurs projets associatifs pour le campus !</p>
        </div>
        <div>
            <h3>Qui organise tout ça ?</h3>
            <p>Le BDE est dirigé par des apprenants bénévoles avec une volonté de donner vie au campus et renforcer le lien inter-promotions !</p>
        </div>
    </div>
</section>
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

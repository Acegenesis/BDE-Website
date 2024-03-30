<?php get_header(); ?>




<!--
<section>
    <div id="svg-container">
        <svg class="background" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs" viewBox="0 0 800 800">
            <defs>
                <filter id="bbblurry-filter" x="-100%" y="-100%" width="400%" height="400%" filterUnits="objectBoundingBox" primitiveUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feGaussianBlur stdDeviation="91" x="0%" y="0%" width="100%" height="100%" in="SourceGraphic" edgeMode="none" result="blur"></feGaussianBlur>
                </filter>
            </defs>
            <g filter="url(#bbblurry-filter)" id="ellipses-group">
                <ellipse rx="150" ry="150.5" cx="100" cy="400" fill="hsl(37, 99%, 67%)"></ellipse>
                <ellipse rx="200" ry="200" cx="600" cy="400" fill="hsl(316, 73%, 52%)"></ellipse>
                <ellipse rx="100" ry="100" cx="400" cy="700" fill="hsl(185, 100%, 57%)"></ellipse>
                <ellipse rx="300" ry="300" cx="1300" cy="100" fill="hsl(286, 100%, 68%)"></ellipse>
            </g>
        </svg>
    </div>
    <h2>Informations importantes :</h2>
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://scontent.cdninstagram.com/v/t39.30808-6/433584051_18044751340729571_7785991747414428127_n.jpg?stp=dst-jpg_e35&efg=eyJ2ZW5jb2RlX3RhZyI6ImltYWdlX3VybGdlbi4xNDQweDE0NDAuc2RyIn0&_nc_ht=scontent.cdninstagram.com&_nc_cat=111&_nc_ohc=967JFEuOjJsAX_azlTt&edm=APs17CUAAAAA&ccb=7-5&ig_cache_key=MzMyODU5NzY4NzY5NDM1NjcyOA%3D%3D.2-ccb7-5&oh=00_AfA_FMD5d8zi0FWG9ZQQT2yc4oOsTHk5IEurI258rCi6dw&oe=6607BC88&_nc_sid=10d13b" alt="Image 1">
                <h2>LE GALA</h2>
            </div>
            <div class="swiper-slide">
                <img src="https://scontent.cdninstagram.com/v/t39.30808-6/425990902_18040524475729571_2889776676951050495_n.jpg?stp=dst-jpg_e35_s720x720&efg=eyJ2ZW5jb2RlX3RhZyI6ImltYWdlX3VybGdlbi4xMTA3eDEwODYuc2RyIn0&_nc_ht=scontent.cdninstagram.com&_nc_cat=111&_nc_ohc=4yH39CYpUAMAX8N-Xjl&edm=APs17CUAAAAA&ccb=7-5&ig_cache_key=MzI5Njc0MjEwNjcwNDgwNDk0Nw%3D%3D.2-ccb7-5&oh=00_AfDfig7E8xzHiU_EW96BvF6ZNPM9Q-EznNQGS5JZcSU-KA&oe=66077047&_nc_sid=10d13b" alt="Image 2">
                <h2>LE WAS</h2>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

<script>
const swiper = new Swiper('.swiper', {
  loop: true,
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

window.addEventListener('load', function() {
    updateViewBox();
    moveEllipses();    
});

window.addEventListener('resize', function() {
    updateViewBox();
});

function updateViewBox() {
    var svg = document.querySelector('.background');
    var svgContainer = document.getElementById('svg-container');
    var pageWidth = svgContainer.offsetWidth; // Obtenez la largeur de la page
    var pageHeight = svgContainer.offsetHeight; // Obtenez la hauteur de la page
    // Mettre à jour la viewBox du SVG avec la largeur de la page
    svg.setAttribute('viewBox', '0 0 ' + pageWidth + ' ' + pageHeight);
}

function moveEllipses() {
    var ellipses = document.querySelectorAll('#ellipses-group ellipse');
    console.log(ellipses);
    ellipses.forEach(function(ellipse) {
        animateEllipse(ellipse);
    });
}

function animateEllipse(ellipse) {
    var svgContainer = document.getElementById('svg-container');

    var maxX = svgContainer.offsetWidth; // Largeur du viewBox
    var maxY = svgContainer.offsetHeight; // Hauteur du viewBox

    var speed = 5; // Vitesse de déplacement
    var angle = Math.random() * Math.PI * 2; // Angle initial aléatoire

    var dx = Math.cos(angle) * speed; // Déplacement en x
    var dy = Math.sin(angle) * speed; // Déplacement en y

    setInterval(function() {
        var getx = ellipse.getAttribute('cx');
        var gety = ellipse.getAttribute('cy');

        var x = parseFloat(getx);
        var y = parseFloat(gety);

        if (x + dx > maxX || x + dx < 0) {
            angle = Math.PI - angle + Math.random() * Math.PI; // Inverser l'angle avec un angle aléatoire
            dx = Math.cos(angle) * speed;
        }
        if (y + dy > maxY || y + dy < 0) {
            angle = -angle + Math.random() * Math.PI; // Inverser l'angle avec un angle aléatoire
            dy = Math.sin(angle) * speed;
        }

        x += dx;
        y += dy;

        ellipse.setAttribute('cx', x);
        ellipse.setAttribute('cy', y);
    }, 70);
}
</script>
-->
<?php get_footer(); ?>

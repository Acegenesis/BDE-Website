</main>
<footer>
    <nav id="navFooter">
        <div class="presentation">
            <h2><?php bloginfo('description'); ?></h2>
            <h1><?php bloginfo('name'); ?></h1>
        </div>
        <ul>
            <?php
                wp_nav_menu( array(
                'theme_location' => 'header-menu',
                'menu_id'        => 'header-menu',
                'walker'         => new Custom_Walker_Nav_Menu(),
                'container'      => false,
                'items_wrap'     => '%3$s',
                ) );
            ?>
        </ul>
    </nav>
    <div id="footerBottom">
        <p>&copy; <?php echo date('Y'); ?> - Tous droits réservés</p>
        <ul>
            <?php
                wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'menu_id'        => 'footer-menu',
                'walker'         => new Custom_Walker_Nav_Menu(),
                'container'      => false,
                'items_wrap'     => '%3$s',
                ) );
            ?>
        </ul>
    </div>
</footer>
</body>
</html>
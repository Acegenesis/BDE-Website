<?php
function my_theme_customizer_page_home() {
    ?>
    <div class="container-fluid">
        <div class="card" style="padding: 0!important; max-width:none!important;">
            <div class="card-header">
                <h1><?php _e('Personnalisation de la page home', 'textdomain'); ?></h1>
            </div>
            <div class="card-body">
                <form method="post" action="options.php">
                    <?php
                        settings_fields('theme-customizer-group');
                        do_settings_sections('theme-customizer');
                    ?>
                    <div class="form-group">
                        <label for="blogname" class="card-title"><?php _e('Titre du site', 'textdomain'); ?></label>
                        <input type="text" name="blogname" value="<?php echo esc_attr(get_option('blogname')); ?>" class="form-control" id="blogname" />
                    </div>
                    <div class="text-right">
                        <button type="reset" class="btn btn-danger">Annuler</button>
                        <button type="submit" class="btn btn-success">Sauvegarder les changements</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <?php
}
?>

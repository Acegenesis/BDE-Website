<?php
function my_theme_customizer_page() {
    ?>
    <div class="container-fluid">
        <div class="card" style="padding: 0!important; max-width:none!important;">
            <div class="card-header">
                <h1><?php _e('Personnalisation générale du thème', 'textdomain'); ?></h1>
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
                    <div class="form-group">
                        <label for="blogdescription" class="card-title"><?php _e('Description du site', 'textdomain'); ?></label>
                        <input type="text" name="blogdescription" value="<?php echo esc_attr(get_option('blogdescription')); ?>" class="form-control" id="blogdescription" />
                    </div>
                    <div class="form-group">
                        <label for="main_logo" class="card-title"><?php _e('Logo principal', 'textdomain'); ?></label>
                        <div class="input-group">
                            <input type="text" name="main_logo" id="main_logo" class="form-control" value="<?php echo esc_attr(get_option('main_logo')); ?>" />
                            <div class="input-group-append">
                                <button type="button" id="upload_main_logo_button" class="btn btn-primary"><?php _e('Uploader une image', 'textdomain'); ?></button>
                            </div>
                        </div>
                        <div style="border-radius: 5px; background: rgba(210,210,210,0.9); width:100%; display:flex; align-items:center; justify-content:center; margin-top: 20px">
                            <?php if (get_option('main_logo')): ?>
                                <img src="<?php echo esc_url(get_option('main_logo')); ?>" alt="<?php _e('Logo principal', 'textdomain'); ?>" style="max-width: 300px; display: block;" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="secondary_logo" class="card-title"><?php _e('Logo secondaire', 'textdomain'); ?></label>
                        <div class="input-group">
                            <input type="text" name="secondary_logo" id="secondary_logo" class="form-control" value="<?php echo esc_attr(get_option('secondary_logo')); ?>" />
                            <div class="input-group-append">
                                <button type="button" id="upload_secondary_logo_button" class="btn btn-primary"><?php _e('Uploader une image', 'textdomain'); ?></button>
                            </div>
                        </div>
                        <div style="border-radius: 5px; background: rgba(210,210,210,0.9); width:100%; display:flex; align-items:center; justify-content:center; margin-top: 20px">
                            <?php if (get_option('secondary_logo')): ?>
                                <img src="<?php echo esc_url(get_option('secondary_logo')); ?>" alt="<?php _e('Logo secondaire', 'textdomain'); ?>" style="max-width: 300px; display: block;" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="reset" class="btn btn-danger">Annuler</button>
                        <button type="submit" class="btn btn-success">Sauvegarder les changements</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <script>
        jQuery(document).ready(function($){
            var mediaUploaderMain, mediaUploaderSecondary;

            $('#upload_main_logo_button').click(function(e) {
                e.preventDefault();
                if (mediaUploaderMain) {
                    mediaUploaderMain.open();
                    return;
                }
                mediaUploaderMain = wp.media.frames.file_frame = wp.media({
                    title: '<?php _e("Choisir une image", "textdomain"); ?>',
                    button: {
                        text: '<?php _e("Utiliser cette image", "textdomain"); ?>'
                    }, 
                    multiple: false
                });
                mediaUploaderMain.on('select', function() {
                    var attachment = mediaUploaderMain.state().get('selection').first().toJSON();
                    $('#main_logo').val(attachment.url);
                });
                mediaUploaderMain.open();
            });

            $('#upload_secondary_logo_button').click(function(e) {
                e.preventDefault();
                if (mediaUploaderSecondary) {
                    mediaUploaderSecondary.open();
                    return;
                }
                mediaUploaderSecondary = wp.media.frames.file_frame = wp.media({
                    title: '<?php _e("Choisir une image", "textdomain"); ?>',
                    button: {
                        text: '<?php _e("Utiliser cette image", "textdomain"); ?>'
                    }, 
                    multiple: false
                });
                mediaUploaderSecondary.on('select', function() {
                    var attachment = mediaUploaderSecondary.state().get('selection').first().toJSON();
                    $('#secondary_logo').val(attachment.url);
                });
                mediaUploaderSecondary.open();
            });
        });
    </script>
    <?php
}
?>

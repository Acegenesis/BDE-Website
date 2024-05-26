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
                        settings_fields('home-customizer-group');
                        do_settings_sections('theme-customizer');
                    ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h2>Slider options</h2>
                            <div class="form-group">
                                <label for="textslider" class="card-title"><?php _e('Texte slider', 'textdomain'); ?></label>
                                <input type="text" name="textslider" value="<?php echo esc_attr(get_option('textslider')); ?>" class="form-control" id="textslider" />
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h2>Présentation</h2>
                            <div id="dynamic-entries">
                                <?php
                                $dynamic_entries = get_option('dynamic_entries', []);
                                if (!empty($dynamic_entries)) {
                                    foreach ($dynamic_entries as $index => $entry) {
                                        ?>
                                        <div class="dynamic-entry">
                                            <div class="form-group">
                                                <label for="dynamic_entries[<?php echo $index; ?>][title]"><?php _e('Titre', 'textdomain'); ?></label>
                                                <input type="text" name="dynamic_entries[<?php echo $index; ?>][title]" value="<?php echo esc_attr($entry['title']); ?>" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="dynamic_entries[<?php echo $index; ?>][description]"><?php _e('Description', 'textdomain'); ?></label>
                                                <textarea name="dynamic_entries[<?php echo $index; ?>][description]" class="form-control"><?php echo esc_textarea($entry['description']); ?></textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-entry"><?php _e('Supprimer', 'textdomain'); ?></button>
                                            <hr>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <button type="button" class="btn btn-primary" id="add-entry"><?php _e('Ajouter une entrée', 'textdomain'); ?></button>
                        </li>
                    </ul>
                    <div class="text-right">
                        <button type="reset" class="btn btn-danger"><?php _e('Annuler', 'textdomain'); ?></button>
                        <button type="submit" class="btn btn-success"><?php _e('Sauvegarder les changements', 'textdomain'); ?></button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <script>
        jQuery(document).ready(function($) {
            var entryIndex = <?php echo !empty($dynamic_entries) ? count($dynamic_entries) : 0; ?>;

            $('#add-entry').click(function() {
                var entryHtml = '<div class="dynamic-entry">' +
                    '<div class="form-group">' +
                        '<label for="dynamic_entries[' + entryIndex + '][title]"><?php _e("Titre", "textdomain"); ?></label>' +
                        '<input type="text" name="dynamic_entries[' + entryIndex + '][title]" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="dynamic_entries[' + entryIndex + '][description]"><?php _e("Description", "textdomain"); ?></label>' +
                        '<textarea name="dynamic_entries[' + entryIndex + '][description]" class="form-control"></textarea>' +
                    '</div>' +
                    '<button type="button" class="btn btn-danger remove-entry"><?php _e("Supprimer", "textdomain"); ?></button>' +
                    '<hr>' +
                '</div>';

                $('#dynamic-entries').append(entryHtml);
                entryIndex++;
            });

            $(document).on('click', '.remove-entry', function() {
                $(this).closest('.dynamic-entry').remove();
            });
        });
    </script>
    <?php
}
?>

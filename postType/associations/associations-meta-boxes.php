<?php
// Ajout de Meta Boxes pour les détails des associations
function add_associations_metaboxes() {
    // Meta box principale pour les détails des associations
    add_meta_box(
        'associations_details',
        'Détails de l\'association',
        'associations_details_callback',
        'associations',
        'normal', // Container principal
        'high' // Priorité élevée
    );

    // Meta box pour la prévisualisation de l'image du logo
    add_meta_box(
        'associations_logo_preview',
        'Preview du logo',
        'associations_logo_preview_callback',
        'associations',
        'side', // Container sur le côté
        'default' // Priorité par défaut
    );
}
add_action('add_meta_boxes', 'add_associations_metaboxes');

// Callback pour afficher la méta box des détails des associations
function associations_details_callback($post) {
    // Récupération des valeurs des métadonnées
    $logo_image = get_post_meta($post->ID, 'logo_image', true);
    $president = get_post_meta($post->ID, 'president', true);
    $vice_president = get_post_meta($post->ID, 'vice_president', true);
    ?>
    <div class="form-group">
        <label for="logo_image">Image du logo :</label>
        <div class="input-group">
            <input type="text" name="logo_image" id="logo_image" class="form-control" value="<?php echo esc_attr($logo_image); ?>" />
            <div class="input-group-append">
                <button type="button" id="upload_logo_button" class="btn btn-primary">Uploader une image</button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="president">Président :</label>
        <input type="text" name="president" id="president" class="form-control" value="<?php echo esc_attr($president); ?>" />
    </div>
    <div class="form-group">
        <label for="vice_president">Vice-président :</label>
        <input type="text" name="vice_president" id="vice_president" class="form-control" value="<?php echo esc_attr($vice_president); ?>" />
    </div>
    <script>
        jQuery(document).ready(function($){
            $('#upload_logo_button').click(function() {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#logo_image').val(attachment.url);
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open();
                return false;
            });
        });
    </script>
    <?php
}

// Callback pour afficher la méta box de prévisualisation du logo
function associations_logo_preview_callback($post) {
    $logo_image = get_post_meta($post->ID, 'logo_image', true);
    ?>
    <div id="logo_container" class="mt-3">
        <?php if ($logo_image) : ?>
            <img src="<?php echo esc_url($logo_image); ?>" class="img-fluid" style="height: auto; object-fit:cover;" />
        <?php endif; ?>
    </div>
    <?php
}

// Sauvegarde des métadonnées des associations
function save_associations_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['logo_image'])) {
        update_post_meta($post_id, 'logo_image', esc_url($_POST['logo_image']));
    }
    if (isset($_POST['president'])) {
        update_post_meta($post_id, 'president', sanitize_text_field($_POST['president']));
    }
    if (isset($_POST['vice_president'])) {
        update_post_meta($post_id, 'vice_president', sanitize_text_field($_POST['vice_president']));
    }
}
add_action('save_post', 'save_associations_metaboxes');
?>

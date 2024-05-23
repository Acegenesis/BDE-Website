<?php
// Ajout de Meta Boxes pour les détails des news
function add_news_metaboxes() {
    // Meta box principale pour les détails des news
    add_meta_box(
        'news_details',
        'Paramètres généraux',
        'news_details_callback',
        'news',
        'normal', // Container principal
        'high' // Priorité élevée
    );

    // Meta box pour la prévisualisation de l'image
    add_meta_box(
        'news_image_preview',
        'Preview de l\'image',
        'news_image_preview_callback',
        'news',
        'side', // Container sur le côté
        'default' // Priorité par défaut
    );
}
add_action('add_meta_boxes', 'add_news_metaboxes', 10);

// Callback pour afficher la méta box des détails des news
function news_details_callback($post) {
    // Récupération des valeurs des métadonnées
    $slider_image = get_post_meta($post->ID, 'slider_image', true);
    ?>
    <div class="form-group">
        <label for="slider_image">Image du slider :</label>
        <div class="input-group">
            <input type="text" name="slider_image" id="slider_image" class="form-control" value="<?php echo esc_attr($slider_image); ?>" />
            <div class="input-group-append">
                <button type="button" id="upload_image_button" class="btn btn-primary">Uploader une image</button>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($){
            $('#upload_image_button').click(function() {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#slider_image').val(attachment.url);
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open();
                return false;
            });
        });
    </script>
    <?php
}

// Callback pour afficher la méta box de prévisualisation de l'image
function news_image_preview_callback($post) {
    $slider_image = get_post_meta($post->ID, 'slider_image', true);
    ?>
    <div id="image_container" class="mt-3">
        <?php if ($slider_image) : ?>
            <img src="<?php echo esc_url($slider_image); ?>" class="img-fluid" style="height: auto; object-fit: cover" />
        <?php endif; ?>
    </div>
    <?php
}

// Sauvegarde des métadonnées des news
function save_news_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['slider_image'])) {
        update_post_meta($post_id, 'slider_image', esc_url($_POST['slider_image']));
    }
}
add_action('save_post', 'save_news_metaboxes');
?>

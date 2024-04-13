<?php
// Ajout de Meta Boxes pour les détails des événements
function add_news_metaboxes() {
    add_meta_box(
        'news_details',
        'Détails de la news',
        'news_details_callback',
        'news',
        'normal', // Container principal
        'high' // Priorité élevée
    );

}
add_action( 'add_meta_boxes_news', 'add_news_metaboxes', 10 );

function news_details_callback() {
    global $post;
    // Récupération des valeurs des métadonnées
    $slider_image = get_post_meta( $post->ID, 'slider_image', true );
    ?>
    <p>Image du slider : <input type="text" name="slider_image" id="slider_image" value="<?php echo esc_attr( $slider_image ); ?>" />
        <input type="button" id="upload_image_button" class="button" value="Uploader une image" />
    </p>
    <div id="image_container">
        <?php if ($slider_image) : ?>
            <img src="<?php echo esc_url($slider_image); ?>" style="max-width: 300px; height: auto;" />
        <?php endif; ?>
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

// Sauvegarde des métadonnées des événements
function save_news_metaboxes( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['slider_image'] ) ) {
        update_post_meta( $post_id, 'slider_image', esc_url( $_POST['slider_image'] ) );
    }
}
add_action( 'save_post', 'save_news_metaboxes' );
?>
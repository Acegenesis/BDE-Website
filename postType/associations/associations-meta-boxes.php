<?php
// Ajout de Meta Boxes pour les détails des associations
function add_associations_metaboxes() {
    add_meta_box(
        'associations_details',
        'Détails de l\'association',
        'associations_details_callback',
        'associations',
        'normal', // Container principal
        'high' // Priorité élevée
    );
}
add_action( 'add_meta_boxes_associations', 'add_associations_metaboxes' );

function associations_details_callback() {
    global $post;
    // Récupération des valeurs des métadonnées
    $logo_image = get_post_meta( $post->ID, 'logo_image', true );
    $president = get_post_meta( $post->ID, 'president', true );
    $vice_president = get_post_meta( $post->ID, 'vice_president', true );
    ?>
    <p>Image du logo : <input type="text" name="logo_image" id="logo_image" value="<?php echo esc_attr( $logo_image ); ?>" />
        <input type="button" id="upload_logo_button" class="button" value="Uploader une image" />
    </p>
    <div id="logo_container">
        <?php if ($logo_image) : ?>
            <img src="<?php echo esc_url($logo_image); ?>" style="max-width: 300px; height: auto;" />
        <?php endif; ?>
    </div>
    <p>Président : <input type="text" name="president" value="<?php echo esc_attr( $president ); ?>" /></p>
    <p>Vice-président : <input type="text" name="vice_president" value="<?php echo esc_attr( $vice_president ); ?>" /></p>
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

// Sauvegarde des métadonnées des associations
function save_associations_metaboxes( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['logo_image'] ) ) {
        update_post_meta( $post_id, 'logo_image', esc_url( $_POST['logo_image'] ) );
    }
    if ( isset( $_POST['president'] ) ) {
        update_post_meta( $post_id, 'president', sanitize_text_field( $_POST['president'] ) );
    }
    if ( isset( $_POST['vice_president'] ) ) {
        update_post_meta( $post_id, 'vice_president', sanitize_text_field( $_POST['vice_president'] ) );
    }
}
add_action( 'save_post', 'save_associations_metaboxes' );

?>
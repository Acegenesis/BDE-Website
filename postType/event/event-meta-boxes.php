<?php
// Ajout de Meta Boxes pour les détails des événements
function add_event_metaboxes() {
    add_meta_box(
        'event_details',
        'Détails de l\'événement',
        'event_details_callback',
        'events',
        'normal', // Container principal
        'high' // Priorité élevée
    );
}
add_action( 'add_meta_boxes_events', 'add_event_metaboxes', 10 );

// Affichage de la méta-boxe et de la case à cocher
function event_details_callback() {
    global $post;
    $event_date = get_post_meta( $post->ID, 'event_date', true );
    $ticket_link = get_post_meta( $post->ID, 'ticket_link', true );
    $slider_image = get_post_meta( $post->ID, 'slider_image', true );
    $slider_home = get_post_meta( $post->ID, 'slider_home', true);
    ?>
    <p>Date de l'événement : <input type="date" name="event_date" value="<?php echo esc_attr( $event_date ); ?>" /></p>
    <p>Lien vers la billetterie : <input type="text" name="ticket_link" value="<?php echo esc_url( $ticket_link ); ?>" /></p>
    <p>Image du slider : <input type="text" name="slider_image" id="slider_image" value="<?php echo esc_attr( $slider_image ); ?>" />
        <input type="button" id="upload_image_button" class="button" value="Uploader une image" />
    </p>
    <div id="image_container">
        <?php if ($slider_image) : ?>
            <img src="<?php echo esc_url($slider_image); ?>" style="max-width: 300px; height: auto;" />
        <?php endif; ?>
    </div>
    <p>Slider Home : <input type="checkbox" name="slider_home" <?php checked( $slider_home, 'on' ); ?> /></p>
    
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
function save_event_metaboxes( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['event_date'] ) ) {
        update_post_meta( $post_id, 'event_date', sanitize_text_field( $_POST['event_date'] ) );
    }
    if ( isset( $_POST['ticket_link'] ) ) {
        update_post_meta( $post_id, 'ticket_link', esc_url( $_POST['ticket_link'] ) );
    }
    if ( isset( $_POST['slider_image'] ) ) {
        update_post_meta( $post_id, 'slider_image', esc_url( $_POST['slider_image'] ) );
    }
    // Enregistrement de la valeur de la case à cocher
    if ( isset( $_POST['slider_home'] ) ) {
        update_post_meta( $post_id, 'slider_home', $_POST['slider_home'] );
    } else {
        update_post_meta( $post_id, 'slider_home', 'off' );
    }
}
add_action( 'save_post', 'save_event_metaboxes' );
?>
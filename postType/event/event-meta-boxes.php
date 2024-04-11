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
    
    add_action( 'post_submitbox_misc_actions', 'event_scheduled_publish_callback' );
}
add_action( 'add_meta_boxes_events', 'add_event_metaboxes', 10 );

function event_details_callback() {
    global $post;
    // Récupération des valeurs des métadonnées
    $event_date = get_post_meta( $post->ID, 'event_date', true );
    $ticket_link = get_post_meta( $post->ID, 'ticket_link', true );
    $slider_image = get_post_meta( $post->ID, 'slider_image', true );
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

function event_scheduled_publish_callback() {
    global $post;
    // Récupération de la date de publication différée
    $scheduled_publish_date = get_post_meta( $post->ID, 'scheduled_publish_date', true );
    ?>
    <div class="misc-pub-section misc-pub-scheduled-publish">
        <label for="scheduled_publish_date">Date de publication différée :</label>
        <input type="datetime-local" name="scheduled_publish_date" id="scheduled_publish_date" value="<?php echo esc_attr( $scheduled_publish_date ); ?>" />
    </div>
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
    if ( isset( $_POST['scheduled_publish_date'] ) ) {
        update_post_meta( $post_id, 'scheduled_publish_date', sanitize_text_field( $_POST['scheduled_publish_date'] ) );
        $scheduled_publish_date = strtotime( $_POST['scheduled_publish_date'] );
        wp_schedule_single_event( $scheduled_publish_date, 'publish_future_post', array( $post_id ) );
    }
}
add_action( 'save_post', 'save_event_metaboxes' );
?>
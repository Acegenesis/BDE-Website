<?php
// Ajout de Meta Boxes pour les détails des événements
function add_event_metaboxes() {
    // Container principal pour le lien du ticket et l'image
    add_meta_box(
        'event_ticket_image',
        'Paramètres avancés',
        'event_ticket_image_callback',
        'events',
        'normal', // Container principal
        'high' // Priorité élevée
    );

    // Containers sur le côté
    // Container pour la date et le slider
    add_meta_box(
        'event_date_slider',
        'Date et Slider',
        'event_date_slider_callback',
        'events',
        'side', // Container sur le côté
        'default' // Priorité par défaut
    );

    // Container pour la preview de l'image
    add_meta_box(
        'event_image_preview',
        'Preview de l\'image',
        'event_image_preview_callback',
        'events',
        'side', // Container sur le côté
        'default' // Priorité par défaut
    );
}
add_action('add_meta_boxes', 'add_event_metaboxes');

// Callback pour le container du lien du ticket et de l'image
function event_ticket_image_callback($post) {
    $ticket_link = get_post_meta($post->ID, 'ticket_link', true);
    $slider_image = get_post_meta($post->ID, 'slider_image', true);
    $selected_assos = get_post_meta($post->ID, '_selected_assos', true);
    $assos_posts = get_posts(array(
        'post_type' => 'associations',
        'numberposts' => -1
    ));
    ?>
    <div class="form-group">
        <label for="selected_assos">Sélectionnez une association qui organise l'évènement :</label>
        <select name="selected_assos" id="selected_assos" class="form-control">
            <option value="">Aucune</option>
            <?php foreach ($assos_posts as $assos_post) : ?>
                <option value="<?php echo esc_attr($assos_post->ID); ?>" <?php selected($selected_assos, $assos_post->ID); ?>>
                    <?php echo esc_html($assos_post->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="ticket_link">Lien vers la billetterie :</label>
        <input type="text" name="ticket_link" class="form-control" value="<?php echo esc_url($ticket_link); ?>" />
    </div>
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

// Callback pour le container de la date et du slider
function event_date_slider_callback($post) {
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $slider_home = get_post_meta($post->ID, 'slider_home', true);
    ?>
    <div class="form-group">
        <label for="event_date">Date de l'événement :</label>
        <input type="date" name="event_date" class="form-control" value="<?php echo esc_attr($event_date); ?>" />
    </div>
    <div class="form-group" style="display: flex;align-items:center;">
        <input class="form-check-input" type="checkbox" name="slider_home" class="form-check-input" id="slider_home" <?php checked($slider_home, 'on'); ?> style="margin-top: 2px"/>
        <label class="form-check-label" for="slider_home" style="padding-left: 30px">Slider Home</label>
    </div>
    <?php
}

// Callback pour le container de la preview de l'image
function event_image_preview_callback($post) {
    $slider_image = get_post_meta($post->ID, 'slider_image', true);
    ?>
    <div id="image_container" class="mt-3">
        <?php if ($slider_image) : ?>
            <img src="<?php echo esc_url($slider_image); ?>" class="img-fluid" style="height: auto; object-fit: cover;" />
        <?php endif; ?>
    </div>
    <?php
}

// Sauvegarde des métadonnées des événements
function save_event_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    // Mettre à jour les autres métadonnées
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
    }
    if (isset($_POST['ticket_link'])) {
        update_post_meta($post_id, 'ticket_link', esc_url($_POST['ticket_link']));
    }
    if (isset($_POST['slider_image'])) {
        update_post_meta($post_id, 'slider_image', esc_url($_POST['slider_image']));
    }
    if (isset($_POST['slider_home'])) {
        update_post_meta($post_id, 'slider_home', $_POST['slider_home']);
    }
    if (isset($_POST['selected_assos'])) {
        update_post_meta($post_id, '_selected_assos', sanitize_text_field($_POST['selected_assos']));
    }    
    else {
        update_post_meta($post_id, 'slider_home', 'off');
    }
}
add_action('save_post', 'save_event_metaboxes');
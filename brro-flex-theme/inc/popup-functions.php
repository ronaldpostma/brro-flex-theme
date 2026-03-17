<?php
//
// ******************************************************************************************************************************************************************** Home
//
// Index of Functions
//
// 1. brro_project_popup_content
//      - Returns the HTML for the project popup content.
// 2. brro_ajax_project_popup
//      - Handles the AJAX request for the project popup.


// Project popup content
function brro_project_popup_content($project_id, $gallery_orientation = '') {
    $project_id = absint($project_id);
    if (!$project_id) {
        return '<p>Onjuist project.</p>';
    }

    $project_client   = get_field('project_client', $project_id);
    $project_text     = get_field('project_text_wysiwyg', $project_id); // returns HTML with <p>
    $project_gallery  = get_field('project_gallery', $project_id); // ACF gallery array
    $project_background_color = get_field('project_popup_bg', $project_id);
	$project_embeds   = get_field('project_embeds', $project_id); // ACF repeater (rows with 'embed' oEmbed)
	$project_embeds_output = [];

    $gallery_class = '';
    if (!empty($gallery_orientation)) {
        $gallery_class = sanitize_html_class($gallery_orientation);
    }

    ob_start();
    ?>
    <div class="project-popup-inner flex row-wrap justify-between items-start">
        <div class="project-text">
            <?php if (!empty($project_client)) : ?>
                <h2 class="project-client acumin size-20-30"><span class="medium">Klant:</span><span class="bold"> <?php echo esc_html($project_client); ?></span></h2>
            <?php endif; ?>
            <?php if (!empty($project_text)) : ?>
                <div class="acumin size-20-30 medium"><?php echo wp_kses_post($project_text); ?></div>
            <?php endif; ?>
        </div>
	<?php
		$has_images = is_array($project_gallery) && !empty($project_gallery);
		$has_embeds = is_array($project_embeds) && !empty($project_embeds);
		if ($has_images || $has_embeds) :
	?>
		<div class="project-gallery<?php echo $gallery_class ? ' ' . esc_attr($gallery_class) : ''; ?>">
			<?php
				// First output embeds (before images)
				if ($has_embeds) {
					$allowed_embed_tags = wp_kses_allowed_html('post');
					$allowed_embed_tags['iframe'] = [
						'src' => true,
						'width' => true,
						'height' => true,
						'frameborder' => true,
						'allow' => true,
						'allowfullscreen' => true,
						'title' => true,
						'loading' => true,
						'referrerpolicy' => true,
					];
					foreach ($project_embeds as $embed_row) {
						$raw = isset($embed_row['embed']) ? $embed_row['embed'] : '';
						if (empty($raw)) { continue; }
						$embed_html = '';
						if (is_string($raw) && strpos($raw, '<') !== false) {
							$embed_html = $raw; // already HTML from ACF oEmbed
						} elseif (is_string($raw)) {
							$embed_maybe = wp_oembed_get($raw);
							$embed_html = $embed_maybe ? $embed_maybe : '';
						}
						if (!empty($embed_html)) {
							echo '<div class="project-embed radius-20">' . wp_kses($embed_html, $allowed_embed_tags) . '</div>';
						}
					}
				}

				// Then output images
				if ($has_images) {
					foreach ($project_gallery as $img) {
						$url = is_array($img) && !empty($img['url']) ? $img['url'] : (is_int($img) ? wp_get_attachment_image_url($img, 'large') : '');
						$alt = is_array($img) && !empty($img['alt']) ? $img['alt'] : '';
						if (!$url) { continue; }
						?>
						<img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" />
						<?php
					}
				}
			?>
		</div>
	<?php endif; ?>
    </div>
    <?php // Set project background color if set
    if (!empty($project_background_color)) : ?>
    <style>
        :root {
            --project-background-color: <?php echo esc_html($project_background_color); ?>;
        }
    </style>
    <?php endif; ?>
    <button class="project-popup-close" aria-label="Sluiten" type="button">
        <span class="svg-wrap" aria-hidden="true"><svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.06055 1.06055L41.0605 41.0605" stroke="black" stroke-width="3"/><path d="M41.0605 1.06055L1.06055 41.0605" stroke="#010101" stroke-width="3"/></svg></span>
    </button>
    <?php
    return trim(ob_get_clean());
}
//
// AJAX request for the project popup
function brro_ajax_project_popup() {
    if (!check_ajax_referer('brro_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'ongeldige aanvraag'], 400);
    }
    $project_id = isset($_POST['project_id']) ? absint($_POST['project_id']) : 0;
    $gallery_orientation = isset($_POST['gallery_orientation']) ? sanitize_text_field(wp_unslash($_POST['gallery_orientation'])) : '';
    if (!$project_id) {
        wp_send_json_error(['message' => 'geen project'], 400);
    }

    $html = brro_project_popup_content($project_id, $gallery_orientation);
    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_brro_project_popup', 'brro_ajax_project_popup');
add_action('wp_ajax_nopriv_brro_project_popup', 'brro_ajax_project_popup');
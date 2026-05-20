<?php
/**
 * Global theme functions — small cross-cutting helpers only.
 *
 * Put here:
 *   - Short helpers used in many templates (e.g. bracket-link parsing, shared kses helpers)
 *   - Small `add_action` / `add_filter` hooks that are not tied to one feature file
 *
 * Do NOT put here — create a new inc/{concern}.php when logic belongs to one feature
 * (e.g. swiper-init.php). Front-page / search helpers use their own inc/ files.
 * ACF layout markup belongs in template-parts/, not here.
 *
 * Index of Functions:
 *   (add entries here as you add helpers)
 *
 * @package Brro_Flex_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

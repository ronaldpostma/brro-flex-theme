<?php
/**
 * The footer template
 *
 * @package Brro_Flex_Theme
 */
?>
</main>

<footer>
    <?php
    // Load main footer content if it exists.
    $main_footer = get_template_directory() . '/templates/main-footer.php';
    if ( file_exists( $main_footer ) ) {
        include $main_footer;
    }
    // No silent fallback content. Footer markup is project-specific.
    ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>

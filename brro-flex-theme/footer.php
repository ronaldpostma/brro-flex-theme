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
    // Load main footer content if it exists
    $main_footer = get_template_directory() . '/templates/main-footer.php';
    if (file_exists($main_footer)) {
        include $main_footer;
    } else {
        // Default footer content (fallback)
        ?>
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
        <?php
    }
    ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
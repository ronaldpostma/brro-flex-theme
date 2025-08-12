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
    // Load custom footer content if it exists
    $custom_footer = get_template_directory() . '/templates/footer.php';
    if (file_exists($custom_footer)) {
        include $custom_footer;
    } else {
        // Default footer content
        ?>
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
        <?php
    }
    ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
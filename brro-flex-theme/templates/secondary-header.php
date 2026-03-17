<?php
/**
 * The project specific main header template, already wrapped in <header> tag
 *
 * @package Brro_Flex_Theme
 */
?>

<div id="back" class="flex row-wrap justify-between items-center">
    <a class="acumin medium size-20-30 white hover-lime" href="<?php echo home_url( '/' ); ?>"><span><&nbsp;</span><span class="info-underline">terug</span></a>
</div>

<div class="header-bottom-wrapper">
    <?php echo brro_secondary_navigation_menu(); ?>
</div>
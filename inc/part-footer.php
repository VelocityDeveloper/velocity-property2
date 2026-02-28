<footer class="site-footer" id="colophon">
    <div class="bg-color-theme py-4">
        <?php
        $footer_container = velocitytheme_option('justg_container_type', 'container');
        if (is_front_page() || is_page_template('page-home.php')) {
            $footer_container = 'container';
        }
        ?>
        <div class="<?php echo esc_attr($footer_container); ?> footer-widget py-5">
            <div class="row mt-3 velocity-widget">
                <?php
                if (is_active_sidebar('footer-widget-1')) {
                    echo '<div class="col-md-4 widget-footer">';
                    dynamic_sidebar('footer-widget-1');
                    echo '</div>';
                }
                if (is_active_sidebar('footer-widget-2')) {
                    echo '<div class="col-md-4 widget-footer">';
                    dynamic_sidebar('footer-widget-2');
                    echo '</div>';
                }
                if (is_active_sidebar('footer-widget-3')) {
                    echo '<div class="col-md-4 widget-footer">';
                    dynamic_sidebar('footer-widget-3');
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <!-- .footer-widget -->
    </div>

    <div class="site-info text-center bg-dark text-light py-3">
        <small>
            Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
        </small>
        <br>
        <small class="opacity-25">
            Design by <a class="text-light" href="https://velocitydeveloper.com/" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
        </small>
    </div>
    <!-- .site-info -->
</footer>

<footer class="site-footer" id="colophon">
    <div class="bg-color-theme">
        <div class="container footer-widget py-5">
            <div class="row m-0 velocity-widget">
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

    <div class="site-info text-center bg-dark text-light p-2">
        <small>
            Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
        </small>
        <br>
        <small class="opacity-25" style="font-size: .7rem;">
            Design by <a class="text-light" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
        </small>
    </div>
    <!-- .site-info -->
</footer>
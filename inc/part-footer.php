<footer class="site-footer container text-center px-2 px-md-0" id="colophon">
    <div class="site-info shadow border-light border border-top-0 px-3 py-2 py-md-4">

    <div class="row text-left text-start velocity-widget">
        <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
            <div class="col-md">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php } ?>
        <?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
            <div class="col-md">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
        <?php } ?>
        <?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
            <div class="col-md">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
        <?php } ?>
    </div>

        <small class="text-secondary">
            Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
        </small>
        <br>
        <small class="opacity-25" style="font-size: .7rem;">
            Design by <a class="text-muted" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
        </small>
    </div>
    <!-- .site-info -->
</footer>
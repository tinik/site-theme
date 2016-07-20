    <!-- Footer -->
    <footer class="footer">
        <div class="row">
            <div class="small-12 medium-8 large-8 columns"><?php
                get_template_part('partials/footer-feed');
                if(is_active_sidebar('widgets_footer')):
                    dynamic_sidebar('widgets_footer');
                endif;
            ?></div>
            <div class="small-12 medium-4 large-4 columns"><?php
                get_template_part('partials/footer-social');
                get_template_part('partials/footer-copyright');
            ?></div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
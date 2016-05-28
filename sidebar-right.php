<?php if(is_active_sidebar('widgets_sidebar')): ?>
    <!-- Sidebar -->
    <aside class="large-3 columns hide-for-small hide-for-medium">
        <div id="sidebar-widget-area">
            <?php dynamic_sidebar('widgets_sidebar'); ?>
        </div>
    </aside>
    <!-- End Sidebar -->
<?php endif; ?>
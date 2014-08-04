        </div><!-- end content -->

</div> <!-- -->
</div>

  <footer class="footer">
    <!-- <hr class="soften"> -->

<!--
    <div class="navbar navbar-bottom">
      <div class="navbar-inner">
        <div class="container-fluid">
          <?php echo public_nav_main(array(__('Home') => url(''), __('Browse Items') => url('items'), __('Browse Collections') => url('collections'))); ?>

        </div>
      </div>
    </div>
-->

    <p class="pull-right"><a href="#">Back to top</a></p>
    <?php echo get_theme_option('Footer Text'); ?>
    <?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = option('copyright')): ?>
      <p><?php echo $copyright; ?></p>
    <?php endif; ?>

    <?php fire_plugin_hook('footer'); ?>
  </footer><!-- end footer -->

</div><!-- end container -->

<script type="text/javascript">
    jQuery(document).ready(function(){
        Omeka.showAdvancedForm();
               Omeka.dropDown();
    });
</script>

<!-- Le javascript -->
<!-- Placed at the end of the document so the pages load faster -->
<?php queue_js_file(array(
                     'bootstrap-transition',
                     'bootstrap-alert',
                     'bootstrap-modal',
                     'bootstrap-dropdown',
                     'bootstrap-scrollspy',
                     'bootstrap-tab',
                     'bootstrap-tooltip',
                     'bootstrap-popover',
                     'bootstrap-button',
                     'bootstrap-collapse',
                     'bootstrap-carousel',
                     'bootstrap-typeahead' )); ?>
<!-- JavaScripts -->

<?php echo head_js(); ?>

</body>
</html>

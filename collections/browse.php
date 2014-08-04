<?php
$pageTitle = __('Browse Collections');
echo head(array('title'=>$pageTitle,'bodyid'=>'collections','bodyclass' => 'browse'));
?>
  <div class="row">
    <div class="col-md-7">
      <div class="page-header">
        <h1><?php echo $pageTitle; ?></h1>
      </div>
    </div>
    <div class="col-md-5">
      <div class="pagination"><?php echo pagination_links(); ?></div>
    </div>
  </div>

    <?php foreach (loop('collections') as $collection): ?>
      <div class="row">
        <div class="col-md-4">

        <h3><?php echo link_to_collection(); ?></h3>
        </div>

        <div class="col-md-5">
            <h4><?php echo __('Description'); ?></h4>
            <p><?php echo metadata($collection, array('Dublin Core', 'Description'), array('snippet'=>350)); ?></p>
        </div>

        <?php if(metadata($collection, array('Dublin Core','Contributor'))): ?>
        <div class="element">
            <h3><?php echo __('Collector(s)'); ?></h3>
            <?php echo metadata($collection, array('Dublin Core', 'Contributor'), array('delimiter'=>', ')); ?>
        </div>
        <?php endif; ?>

        <div class="col-md-3">
        <?php echo link_to_items_in_collection(__('View the items in %s', metadata('collection',array('Dublin Core', 'Title'))), array('class' => "btn btn-primary btn-large")); ?>


        <?php echo fire_plugin_hook('append_to_collections_browse_each'); ?>
        </div>

      </div>
    <?php endforeach; ?>

    <?php echo fire_plugin_hook('append_to_collections_browse'); ?>
  </div>
</div><!-- end primary -->

<?php echo foot(); ?>

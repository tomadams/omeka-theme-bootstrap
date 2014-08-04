<?php $title = metadata('collection',array('Dublin Core', 'Title')); echo head(array('title' => $title, 'bodyid'=>'collections', 'bodyclass' => 'show')); ?>

<div class="row">
    <div class="col-md-8">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>

        <?php echo metadata('collection', array('Dublin Core', 'Description')); ?>
      </div>
    </div>
    <div class="col-md-4">

    <?php echo link_to_items_in_collection(__('View the items in %s', metadata('collection', array('Dublin Core', 'Title'))), array('class' => "btn btn-primary btn-large")); ?>

    <?php fire_plugin_hook('public_collections_show', array('view'=>$this)); ?>

    </div>
    </div>

    <?php if (metadata('collection', array('Dublin Core', 'Contributor'))): ?>
    <div id="collectors" class="element">
        <h2><?php echo __('Collector(s)'); ?></h2>
        <div class="element-text">
            <ul>
                <li><?php echo metadata('collection', array('Dublin Core', 'Contributor'), array('delimiter'=>'</li><li>')); ?></li>
            </ul>
        </div>
    </div><!-- end collectors -->
    <?php endif; ?>
<h3>People, Organizations & Subjects <small>limited to the <?php echo metadata('collection',array('Dublin Core', 'Title')); ?> collection</small></h3>

<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tag-a" data-toggle="tab">A</a></li>
    <li><a href="#tag-b" data-toggle="tab">B</a></li>
    <li><a href="#tag-c" data-toggle="tab">C</a></li>
    <li><a href="#tag-d" data-toggle="tab">D</a></li>
    <li><a href="#tag-e" data-toggle="tab">E</a></li>
    <li><a href="#tag-f" data-toggle="tab">F</a></li>
    <li><a href="#tag-g" data-toggle="tab">G</a></li>
    <li><a href="#tag-h" data-toggle="tab">H</a></li>
    <li><a href="#tag-i" data-toggle="tab">I</a></li>
    <li><a href="#tag-j" data-toggle="tab">J</a></li>
    <li><a href="#tag-k" data-toggle="tab">K</a></li>
    <li><a href="#tag-l" data-toggle="tab">L</a></li>
    <li><a href="#tag-m" data-toggle="tab">M</a></li>
    <li><a href="#tag-n" data-toggle="tab">N</a></li>
    <li><a href="#tag-o" data-toggle="tab">O</a></li>
    <li><a href="#tag-p" data-toggle="tab">P</a></li>
    <li><a href="#tag-q" data-toggle="tab">Q</a></li>
    <li><a href="#tag-r" data-toggle="tab">R</a></li>
    <li><a href="#tag-s" data-toggle="tab">S</a></li>
    <li><a href="#tag-t" data-toggle="tab">T</a></li>
    <li><a href="#tag-u" data-toggle="tab">U</a></li>
    <li><a href="#tag-v" data-toggle="tab">V</a></li>
    <li><a href="#tag-w" data-toggle="tab">W</a></li>
    <li><a href="#tag-x" data-toggle="tab">X</a></li>
    <li><a href="#tag-y" data-toggle="tab">Y</a></li>
    <li><a href="#tag-z" data-toggle="tab">Z</a></li>
  </ul>
  <div class="tab-content">
<!--    <php $tagsx = bootstrap_get_tags_for_items_in_collection(array('sort' => 'alpha'),4000); > -->
    <?php $tags = bootstrap_get_tags_for_items_in_collection(); ?>
    <?php echo bootstrap_tag_string($tags,url('items/browse/tag/')); ?>
  </div>



</div>
  </div>
</div><!-- end primary -->

<?php echo foot(); ?>

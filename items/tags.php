<?php
$pageTitle = __('People, Organizations &amp; Subjects');
echo head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass'=>'tags'));
?>

  <div class="col-md-12">

    <h3><?php echo $pageTitle; ?> (<?php echo get_db()->getTable('Tag')->count(); ?>) <small>Across all Collections</small></h3>

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
    <?php $tags = get_records('Tag',array('sort_field' => 'name','sort_dir' => 'a','type' => 'item', 'public' => true),25000); ?>
    <?php echo bootstrap_tag_string($tags,url('items/browse/tag/')); ?>
  </div>
</div><!-- end primary -->
</div>

<?php echo foot(); ?>

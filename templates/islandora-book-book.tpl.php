<?php
/**
 * @file
 * Template file to style output.
 */

$imgpath = "http://digital.lib.niu.edu/islandora/object/{$object->id}/datastream/TN";
$element = array(
  '#tag' => 'meta',
  '#attributes' => array(
    'property' => 'og:image',
    'content' => $imgpath,
  ),
);
drupal_add_html_head($element, 'og_image');

?>

<div class="islandora-book-object islandora">
<?php if(isset($viewer)): ?>
  <div id="book-viewer">
    <?php print $viewer; ?>
  </div>
<?php endif; ?>
</div>

<row>
  <div class="col-lg-8 col-md-8 col-sm-8">
    <?php print $metadata; ?>
  </div>
  <div id="services" class="col-lg-4 col-md-4 col-sm-4">
    <h2 class="block-title">Share</h2>
    <?php $block = module_invoke('addthis', 'block_view', 'addthis_block'); ?>
    <?php print render($block['content']); ?>
  </div>
  <?php
    $blockObject = block_load('islandora_blocks', 'citation');
    $block = _block_get_renderable_array(_block_render_blocks(array($blockObject)));
    $output = drupal_render($block);
    print $output
  ?>
  <?php if(!empty($editions)): ?>
  <div id="editions" class="col-lg-4 col-md-4 col-sm-4">
    <h2 class="block-title">Browse Related Editions</h2>
    <?php print($editions); ?>
  </div>
  <?php endif; ?>
</row>
  <div class="col-lg-8 col-md-8 col-sm-8">
    <?php if ($parent_collections): ?>
      <div>
        <h2 class="block-title"><?php print t('In collections'); ?></h2>
        <ul>
          <?php foreach ($parent_collections as $collection): ?>
        <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>

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

<div class="islandora-newspaper-issue clearfix">
  <span class="islandora-newspaper-issue-navigator">
    <?php print theme('islandora_newspaper_issue_navigator', array('object' => $object)); ?>
  </span>
  <?php if (isset($viewer_id) && $viewer_id != "none"): ?>
    <div id="book-viewer">
      <?php print $viewer; ?>
    </div>
  <?php else: ?>
    <?php print theme('islandora_objects', array('objects' => $pages)); ?>
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
    <div id="download" class="col-lg-4 col-md-4 col-sm-4">
      <h2 class="block-title">Download</h2>
      <ul>
      <?php if(isset($object['PDF'])): ?>
        <li>
          <a href='<?php print "/islandora/object/{$object->id}/datastream/PDF"; ?>'>PDF (<?php print human_filesize($object['PDF']->size); ?>)</a>
        </li>
      <?php endif; ?>
      <?php if(isset($object['OCR'])): ?>
        <li>
         <a href='<?php print "/islandora/object/{$object->id}/datastream/OCR"; ?>'>Full Text (<?php print human_filesize($object['OCR']->size); ?>)</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</row>

<?php

/**
 * @file
 * This is the template file for the object page for newspaper
 *
 * Available variables:
 * - $islandora_content: A rendered vertical tabbed newspapper issue browser.
 * - $parent_collections: An array containing parent collection IslandoraFedoraObject(s).
 * - $description: Rendered metadata descripton for the object.
 * - $metadata: Rendered metadata display for the binary object.
 *
 * @see template_preprocess_islandora_newspaper()
 */
?>
<div class="islandora-newspaper-object islandora">
  <div class="islandora-newspaper-content-wrapper clearfix">
    <?php if ($islandora_content): ?>
      <div class="islandora-newspaper-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  </div>
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

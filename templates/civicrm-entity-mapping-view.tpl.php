<div class="civicrm-entity-salesforce-mapping">
  <h2><?php print $title?> Mapping</h2>
  <div class ="status-block">
    <div><span class="label">Queue Enabled:</span><span><?php print $enabled ?></span></div>
    <div><span class="label">Queue Table installed:</span><span><?php print $installed ?></span></div>
    <div><span class="label">Total items:</span><span><?php print $total_count ?></span></div>
    <div><span class="label">Total items synced:</span><span><?php print $synced_count ?></span></div>
    <div><span class="label">Items waiting to sync:</span><span><?php print $sync_count ?></span></div>
  </div>
  <div class="mapping-content">
    <?php print render($content) ?>
  </div>
  <?php if( !empty($view) ):?>
    <div class="mapping-view">
      <?php print $view; ?>
    </div>
  <?php endif; ?>
</div>
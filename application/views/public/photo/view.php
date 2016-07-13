<main class="clearfix">
  <?php
    if ($msg) {
      echo
        '<div class="alert alert-warning">
          <strong>Warning!</strong> '.$msg.'
        </div>';
    }
  ?>
  <?= $detail?>
</main>

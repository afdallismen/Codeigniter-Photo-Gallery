<main class="clearfix">
  <?php
    if ($msg) {
      echo
        '<div class="alert alert-info">
          <strong>Info!</strong> '.$msg.'
        </div>';
    }
  ?>

  <?= $gallery?>

  <?= $pagination?>

</main>

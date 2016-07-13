<div class="clearfix">
  <?php foreach ($photos as $photo): ?>
    <div class="col-xs-6 col-md-2">
      <a href="<?= site_url('view/' . $photo['id'])?>" class="thumbnail">
        <img src="<?= base_url($photo['link'])?>" alt="<?= $photo['name']?>"/>
      </a>
    </div>
  <?php endforeach ?>
</div>
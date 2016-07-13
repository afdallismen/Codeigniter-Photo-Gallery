<div class="panel panel-default">
  <div class="panel-body">
    <div class="col-xs-4">
      <section>
        <h3>Name :</h3>
        <p><?= $photo['name']?></p>
      </section>
      <section>
        <h3>Description :</h3>
        <p><?= $photo['description']?></p>
      </section>
      <section>
        <h3>Date :</h3>
        <p><?= $photo['date']?></p>
      </section>
      <section>
        <h3>Location</h3>
        <p><?= $photo['location']?></p>
      </section>
      <?= form_open('public_page/download_image')?>
        <input type="hidden" name="image_link" value="<?= $photo['link']?>"/>
        <input type="submit" class="btn-primary" value="Download This Image"/>
      </form>
    </div>
    <div class="thumbnail pull-right">
      <img src="<?= base_url($photo['link'])?>" alt="<?= $photo['name']?>"/>
    </div>
  </div>
</div>
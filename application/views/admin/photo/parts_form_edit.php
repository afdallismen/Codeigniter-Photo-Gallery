<div class="panel panel-default">
  <div class="panel-body">
    <?php
      if ($msg) {
        echo
          '<div class="alert alert-info">
            <strong>Info!</strong> '.$msg.'
          </div>';
      }
    ?>

    <?= form_open('admin/edit/' . $photo['id'])?>
      <input type="hidden" name="id" value="<?= $photo['id']?>"/>

      <div class="thumbnail clearfix">
        <img src="<?= base_url($photo['link'])?>"/>
        <input type="hidden" name="link" value="<?= $photo['link']?>"/>
        <input type="hidden" name="link_thumb" value="<?= $photo['link_thumb']?>"/>
      </div>

      <div class="form-group">
        <label for="name">Name</label>
        <input
          type="text"
          name="name"
          class="form-control"
          placeholder="Photo name"
          value="<?= $photo['name']?>"
        />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          type="text"
          name="description"
          class="form-control"
          placeholder="Describe this photo"
        ><?= $photo['description']?></textarea>
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <div class="input-group date" data-provide="datepicker">
          <input
            type="text"
            name="date"
            class="form-control"
            value="<?= $photo['date']?>"
          >
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="Location">Location</label>
        <input
          type="text"
          name="location"
          class="form-control"
          placeholder="Where this photo taken"
          value="<?= $photo['location']?>"
        />
      </div>

      <input type="submit" class="btn btn-default" value="Submit" />
    </form>

  </div>
</div>
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

    <?= form_open_multipart('admin/upload')?>

      <div class="form-group">
        <label for="photo">Photo</label>
        <input type="file" name="photo"/>
        <p class="help-block">
          Currently just support .jpg, .png and .gif extension with file size
          not exceed 5 MB.
        </p>
      </div>

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" placeholder="Photo name" />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          type="text"
          name="description"
          class="form-control"
          placeholder="Describe this photo"></textarea>
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <div class="input-group date" data-provide="datepicker">
          <input
            type="text"
            name="date"
            class="form-control"
            placeholder="When this photo taken"
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
        />
      </div>

      <input type="submit" class="btn btn-default" value="Upload" />
    </form>

  </div>
</div>
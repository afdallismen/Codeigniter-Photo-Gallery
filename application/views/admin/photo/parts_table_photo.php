<!-- Ordering form -->
<?= form_open('admin/index', 'method="get" class="form-inline"')?>

  <div class="form-group">
    <label for="order_field">Order By</label>
    <select name="order_field" class="form-control">
      <option value="id">No</option>

      <option
        value="name"
        <?= ($this->session->userdata('order_field') == 'name'? 'selected' : '')?>
      >Name</option>

      <option
        value="date"
        <?= ($this->session->userdata('order_field') == 'date'? 'selected' : '')?>
      >Date</option>

      <option
        value="location"
        <?= ($this->session->userdata('order_field') == 'location'? 'selected' : '')?>
      >Location</option>
    </select>
  </div>

  <div class="form-group">
    <label for="order">Order</label>
    <select name="order" class="form-control">
      <option
        value="asc"
        <?= ($this->session->userdata('order') == 'asc'? 'selected' : '')?>
      >Ascending</option>
      <option value="desc"
        <?= ($this->session->userdata('order') == 'desc'? 'selected' : '')?>
      >Descending</option>
    </select>
  </div>

  <input type="submit" value="Go"/>

</form>
<!-- End ordering form -->
<br />

<!-- Table to display all photo -->
<table class="table table-bordered">

  <tr>
    <th>No</th>
    <th>Name</th>
    <th>Date</th>
    <th>Location</th>
    <th>Image</th>
    <th colspan="2">Action</th>
  </tr>

  <?php foreach ($photos as $key => $photo): ?>
  <tr>
    <td><?= ++$key?></td>
    <td><?= $photo['name']?></td>
    <td><?= $photo['date']?></td>
    <td><?= $photo['location']?></td>
    <td>
      <img
        src="<?= base_url($photo['link_thumb'])?>"
        alt="<?= $photo['name']?>"
      />
    </td>
    <td><?= anchor('admin/edit/' . $photo['id'], 'Edit')?></td>
    <td>
      <button
        type="button"
        data-id="<?= $photo['id']?>"
        class="delete-button btn btn-link"
        data-toggle="modal"
        data-target="#deleteModal"
      >Delete</button>
    </td>
  </tr>
  <?php endforeach ?>

</table>
<!-- End table -->

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <button
          type="button"
          class="close"
          data-dismiss="modal"
        >&times;</button>
        <h4 class="modal-title">Delete confirmation</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete this photo ?</p>
      </div>
      <div class="modal-footer">
        <a
          class="btn btn-default"
          id="delete_link"
          href="<?= site_url('admin/delete/')?>"
        >Yes</a>
        <button
          type="button"
          class="btn btn-default"
          data-dismiss="modal"
        >Cancel</button>
      </div>
    </div>
    <!-- End modal content -->

  </div>
</div>
<!-- End delete modal -->

<!-- Somehow need to load jquery for bellow script to work -->
<script src="<?php echo base_url('asset/jquery.min.js');?>"></script>

<!-- Passing data-id to modal -->
<script>
  $(document).on("click", ".delete-button", function () {
    var photoId = $(this).data('id');
    var href = $(".modal-footer #delete_link").attr("href");
    $(".modal-footer #delete_link").attr("href", href + "/" + photoId);
   // As pointed out in comments,
   // it is superfluous to have to manually call the modal.
   // $('#addBookDialog').modal('show');
  });
</script>
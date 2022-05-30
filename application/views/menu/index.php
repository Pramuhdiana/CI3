<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <!-- menampilkan validasi eror pada form addMenu -->
  <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
  <?= $this->session->flashdata('message'); ?>

  <div class="row">
    <div class="col-lg">
      <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- variabel i untuk melooping nomor -->
          <?php $i = 1 ?>
          <!-- menampilkan data pada databse menu -->
          <?php foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?= $i; ?></th>
              <td><?= $m['menu']; ?></td>
              <td>
                <a href="<?= base_url('menu'); ?>/<?= $m['id']; ?>" data-toggle="modal" data-target="#editMenuModal" class="badge badge-pill badge-success">Edit</a>
                <a href="<?= base_url('menu'); ?>/delete/<?= $m['id']; ?>" class="badge badge-pill badge-danger">Delete</a>
              </td>
            </tr>
            <?php $i++ ?>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




<!-- Modal add menu-->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- bodynya memakai form -->
      <form action="<?= base_url('menu'); ?>" method="POST">
        <!-- actionnya mengarah ke controller menu -->
        <div class="modal-body">
          <!-- isi content body form -->
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal edit menu-->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Edit Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- bodynya memakai form -->
      <form action="<?= base_url('menu/edit'); ?>" method="POST">
        <!-- actionnya mengarah ke controller menu -->
        <div class="modal-body">
          <!-- isi content body form -->
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
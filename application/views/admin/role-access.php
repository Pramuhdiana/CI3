<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- menampilkan validasi eror pada form addRole -->
    <?= $this->session->flashdata('message'); ?>

    <h5>Role : <?= $role['role']; ?> </h5>
    <div class="row">
        <div class="col-lg">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- variabel i untuk melooping nomor -->
                    <?php $i = 1 ?>
                    <!-- menampilkan data pada databse role -->
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['menu']; ?></td>
                            <td>
                                <!-- helper check_access mengirim 2 parameter ke method check_access di pram_helper -->
                                <!-- data-role dan data-menu untuk menyimpan id agar bisa di proses di jquery "footer" -->
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="<?= $i; ?>" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                    <label class="custom-control-label" for="<?= $i; ?>">Toggle Access Activated</label>
                                </div>
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
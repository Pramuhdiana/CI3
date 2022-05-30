<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <!-- menampilkan pesan -->
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- $title menampilkan kalimat yang di simpan di $data 'title'; -->
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
                <!-- cara menampilkan gambar yang fi simpan di folder assets->img->profile-> 
            nama filenya di ambil di database kolom image -->
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <!-- menampilkan nama,email,data_created di database yang sebelumnya
                di simpan di $data'user' -->
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text">Email : <?= $user['email']; ?></p>
                    <p class="card-text">Since : <?= date('d F Y', $user['date_created']); ?></p>
                    <?php
                    if ($user['role_id'] == 1) {
                        $role = "Administrator";
                    } else {
                        $role = "Member";
                    }
                    ?><br>
                    <p class="card-text"><small class="text-muted">Level : <?= $role; ?></small></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
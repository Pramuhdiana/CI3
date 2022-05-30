<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="col-lg-16">
                <?= $this->session->flashdata('message'); ?>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password">
                    <?= form_error('currentPassword', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class=" form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user" id="newPassword1" name="newPassword1" placeholder="New Password">
                        <?= form_error('newPassword1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user" id="newPassword2" name="newPassword2" placeholder="Repeat Password">
                        <?= form_error('newPassword2', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>




</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
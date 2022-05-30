  <!-- Footer -->
  <footer class="sticky-footer bg-white">
      <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website <?= date('Y'); ?></span>
          </div>
      </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
              <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
              </div>
          </div>
      </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

  <script>
      //script memanupulasi kolom image agar tampil nama filenya
      $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
      /*Jquery cari class custom file -> ketika di ganti jalankan fungsi
      nama file yang barunya simpan di inputan */


      //script jquery untuk file role_access
      //tangkap yang classnya custom-control-input
      $('.custom-control-input').on('click', function() {
          //saat di klik lalu jalankan fungsi berikut
          //mengambil data yang ada di class custom control input
          const menuId = $(this).data('menu');
          const roleId = $(this).data('role');

          //menjalankan ajaxnya agar saat di klik langsung di proses
          $.ajax({
              //arahkan urlnya ke admin/changeaccess
              url: "<?= base_url('admin/changeaccess'); ?>",
              //typenya post
              type: 'post',
              //mengirim datanya 2 dengan objek
              data: {
                  menuId: menuId,
                  roleId: roleId
              },
              //jika sukses jalankan fungsi dibawah ini
              success: function() {
                  document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
              }

          });

      });
  </script>

  </body>

  </html>
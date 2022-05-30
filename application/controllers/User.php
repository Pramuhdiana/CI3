<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // cara memanggil fungsi helper yang dibuat sendiri
    }

    public function index()
    {

        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        /* $data['user'] =
         $this->db->get_where('user',  ['email' =>          //ini mencari data di database tabel user kolom email
         $this->session->userdata['email']])->row_array();  //ini mengambil data yang di simpen di session
        */
        $data['title'] = "My Profile";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data); //menampilkan halaman user -> method index
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Edit Profile";

        //set rule
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            //ambil data yang di input pada form
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            //kondisi jika ada yang upload
            if ($upload_image) {
                //cek dahulu jenis,ukuran,dan tempat penyimpanan filenya
                $config['upload_path'] = FCPATH .  '/assets/img/profile/'; //tempat untuk menyimpan file
                $config['allowed_types'] = 'gif|jpg|png|jpeg'; //file harus bertype gif/jpg/png
                $config['Max_size'] = '2048'; //file tidak boleh lebih dari 2mb
                //ketika sudah di cek jalankan librarynya
                $this->load->library('upload', $config);
                //ketika semua syarat sudah terpenuhi langsung di upload
                if ($this->upload->do_upload('image')) {
                    //agar menghapus file yang sebelumnya supaya tidak menumpuk
                    $old_image = $data['user']['image'];
                    //cek apakah gambar old_image default bukan
                    if ($old_image != 'default.jpg') {
                        //jika gambar sebelumnya bukan default.jpg maka akan di hapus di folder
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    //simpan nama file baru ke variabel
                    $new_image = $this->upload->data('file_name');
                    //lalu set nama file baru ke database
                    $this->db->set('image', $upload_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            //menjalankan query
            //query edit 1 baris haha
            $this->db->update('user', ['name' => $name], ['email' => $email]);

            //menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Your profile has been updated!
            </div>');
            redirect('user'); //memindahkan ke halaman utama atau login
        }
    }

    public function changepassword()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //set rule
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newPassword1', 'New Password', 'required|trim|min_length[3]|matches[newPassword2]');
        $this->form_validation->set_rules('newPassword2', 'Repeat Password', 'required|trim|min_length[3]|matches[newPassword1]');

        if ($this->form_validation->run() == false) {
            //set tampilan awal
            $data['title'] = "Change Password";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            //jika falidasi lolos
            $current_password = $this->input->post('currentPassword'); //menangkap data pada inputan form
            $new_password = $this->input->post('newPassword1'); //menangkap data inpitan di new password
            if (!password_verify($current_password, $data['user']['password'])) {
                //kondisi jika password current tidak sama dengan yang ada di database
                //pengecekan memakai verify
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Wrong current Password!
          </div>');
                redirect('user/changepassword');
            } else {
                if ($new_password == $current_password) {
                    //kondisi jika password lama dan yang baru sama
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    New password cannot be the same as current password!
                    </div>');
                    redirect('user/changepassword');
                } else {
                    //kondisi password sudah benar (melewati semua persyaratan)
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT); //mengacak password saat di simpan di database

                    //memasukan kedatabase
                    $this->db->set('password', $password_hash); //ganti password dengan isi variabel $password_hash
                    $this->db->where('email', $this->session->userdata('email')); //email sama dengan session email yang login
                    $this->db->update('user'); //table database user
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password changed!
                  </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}

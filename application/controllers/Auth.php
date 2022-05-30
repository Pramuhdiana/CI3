<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    //form validation
    public function __construct()
    {
        parent::__construct(); //jika memakai construct harus memanggil parentnya
        $this->load->library('form_validation'); //load library form_validation


    }

    public function index() //method default
    {
        //kondisi agar saat sudah login tidak bisa mengakses halaman login lewat url
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        //set rules login
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        //kondisi
        if ($this->form_validation->run() == false) {
            //true
            $data['title'] = "Login Pages";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login'); //memanggil folder views -> auth -> login.php
            $this->load->view('templates/auth_footer');
        } else {
            //validasi success
            $this->_login(); // _login method private ditandai dengan _

        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user',  ['email' => $email])->row_array();
        /*mengecek apakah email yang di input dari form ada di database
            'email' => nama kolom didatabase yang ingin di cek
            $email => tempat menyimpan inputan di form login
            row_array => agar dapat 1 informasi 1 barir atau 1 id
        */

        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                /*jika nama kolom is_active di database == 1 berarti aktif
                'is_active' => nama kolom di databese*/

                //cek passwordnya sama dengan yang di database tidak
                if (password_verify($password, $user['password'])) {
                    //jika password sudah benar

                    //nge set session email dan role_id jika sudah login 
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    //sesudah semua tervalidasi sebelum di pindahkan ke halaman yang di inginkan
                    //cek dulu role atau levelnya agar bisa di sesuaikan 
                    if ($user['role_id'] == 1) {
                        //jika level admin atau 1 maka dipindahkan ke halaman admin
                        redirect('admin');
                    } else {
                        //jika level member atau 2 atau selain 1 maka dipindahkan ke halaman member
                        redirect('user'); // halaman member
                    }
                } else {
                    //jika passwordnya gagal
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password!
                  </div>');
                    redirect('auth');
                }
            } else {
                //jika usernya belum aktif menampilkan pesan error
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This email has not been activated!
              </div>');
                redirect('auth');
            }
        } else {
            //user tidak ada
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!
          </div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        //set rules registration
        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            //kondisi jika required tidak terpenuhi maka menampilkan pesan
            'required' => 'Nama Wajib di isi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]); //is_unique[nama tabel database.nama kolom database]
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'required' => 'Password Wajib di isi',
            'matches' => 'Password dont match!',
            'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        //kondisi
        if ($this->form_validation->run() == false) {
            //true atau kalo gagal
            $data['title'] = "Registration Pages";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration'); //memanggil folder views -> auth -> registration.php
            $this->load->view('templates/auth_footer');
        } else {
            //false atau kalo sukses
            //cara menyiapkan data sebelum masuk ke database
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                //password_hash untuk mengenskripsi & PASSWORD_DEFAULT agar keamanannya dipilihkan oleh CI yang paling terbaik
                'role_id' => 2, //defaultnya 2 karena setiap registrasi levelnya member
                'is_active' => 1, //1 agar langsung active
                'date_created' => time()
            ];
            //input ke database dengan form register
            $this->db->insert('user', $data);
            //user = nama tabel database  
            //$data nama parameter yang menyiapkan data 
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your account has been created. Please login
          </div>');
            //message nama untuk tempat menyimpan pesan
            redirect('auth'); //jika sudah berhasil di arah kan ke halaman awal

        }
    }

    //method untuk logout
    public function logout()
    {
        //membersihkan session dan mengembalikannya ke halaman login
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        //session yang dimiliki ada 2 jadi harus menghapus dua2nya

        //menampilkan pesan
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logged out!
      </div>');
        redirect('auth'); //memindahkan ke halaman utama atau login
    }

    public function blocked()
    {

        $this->load->view('auth/blocked');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // cara memanggil fungsi helper yang dibuat sendiri
        $this->load->model('m_data');
    }

    public function index()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // query database user_menu untuk looping menu di menu/index.php
        $data['menu'] = $this->db->get('user_menu')->result_array(); //result_array menggambil karena banyak

        //set Rules untuk form
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        // $autoload['libraries'] = array('email', 'session', 'database', 'form_validation');
        //sebelum menggunakan form_validation mnasukan dulu pada libraries autoload.php pada folder config
        //validasi form addMenu
        if ($this->form_validation->run() == false) {
            $data['title'] = "Menu Management";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            //jika form_validasi lolos dari rules maka lakukan fungsi dibawah ini
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            /* data masukan ke database tabel user_menu,kolom menu di isi dengan data sesuai apa yang di ketik */

            //menampilkan pesan 
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Nem menu ddded!
          </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array(); //result_array menggambil karena banyak

        //query data yang sudah di join menggunakan model
        $this->load->model('Menu_model', 'menu'); //load modelnya
        //Menu_model nama file di model || menu adalah aliasnya agar tidak terlalu panjang
        $data['subMenu'] = $this->menu->getSubMenu();

        //set Rules untuk form
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {

            $data['title'] = "Submenu Management";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            //menampung data yang di input
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            //memasukan data yang di input ke database
            $this->db->insert('user_sub_menu', $data);
            //tampilkan pesan berhasil
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New submenu added!
          </div>');
            redirect('menu/submenu');
        }
    }

    public function edit()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // query database user_menu untuk looping menu di menu/index.php
        $data['menu'] = $this->db->get('user_menu')->result_array(); //result_array menggambil karena banyak

        //set Rules untuk form
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        // $autoload['libraries'] = array('email', 'session', 'database', 'form_validation');
        //sebelum menggunakan form_validation mnasukan dulu pada libraries autoload.php pada folder config
        //validasi form addMenu
        if ($this->form_validation->run() == false) {
            $data['title'] = "Menu Management";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            //jika form_validasi lolos dari rules maka lakukan fungsi dibawah ini
            $this->db->edit('user_menu', ['menu' => $this->input->post('menu')]);
            /* data masukan ke database tabel user_menu,kolom menu di isi dengan data sesuai apa yang di ketik */

            //menampilkan pesan 
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Edit Success!
           </div>');
            redirect('menu');
        }
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        $this->m_data->hapus_data($where, 'user_menu');
        redirect('menu');
    }
}

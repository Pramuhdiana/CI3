<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
        $data['title'] = "Dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data); //menampilkan halaman user -> method index
        $this->load->view('templates/footer');
    }

    //method untuk Role
    public function role()
    {

        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //query data
        $data['role'] = $this->db->get('user_role')->result_array();

        //set Rules
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {

            $data['title'] = "Role";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data); //menampilkan halaman user -> method index
            $this->load->view('templates/footer');
        } else {
            $data = ['role' => $this->input->post('role')];
            $this->db->insert('user_role', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New role added!
          </div>');
            redirect('admin/role');
        }
    }

    //method untuk role access menerima parameter yang dikirim yaitu $role_id
    public function roleAccess($role_id)
    {

        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //query yang menampilkan data id yang dikirim oleh parameter
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        //query semua data menu
        $this->db->where('id !=', 1); //coding agar tidak menampilkan id 1 /admin
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $data['title'] = "Role Access";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data); //menampilkan halaman user -> method index
        $this->load->view('templates/footer');
    }

    //method khusus ajax jquery
    public function changeAccess()
    {
        //menyimpan data yang dikirim oleh ajax
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        //menyiapkan data untuk dimasukan ke query/database
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        //query berdasarkan data di atas
        $result = $this->db->get_where('user_access_menu', $data);

        //jika result tidak ada di table data base
        if ($result->num_rows() < 1) {
            //maka insert datanya
            $this->db->insert('user_access_menu', $data);
        } else {
            //sebaliknya jika ada hapus datanya
            $this->db->delete('user_access_menu', $data);
        }

        //tampilkan pesan
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Access Changed!
      </div>');
    }

    public function users()
    {
        //mengambil data yang di simpan di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Users";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/users', $data); //menampilkan halaman user -> method index
        $this->load->view('templates/footer');
    }
}

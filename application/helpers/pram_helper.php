<?php
function is_logged_in()
{
    //di helper tidak bisa menggunakan $this
    $ci = get_instance(); //syarat wajib memasukan instansiasi ke variabel

    //kondisi
    //jika tidak ada session email maka akan di pindahkan ke halaman auth (halaman login)
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        //menyimpan session role_id yang login ke variabel
        $role_id = $ci->session->userdata('role_id');
        //menyimpan url menu mana yang sedang di akses saat login ke variabel
        $menu = $ci->uri->segment(1);
        /*contoh penggunaan segment
        http://example.com/index.php/news/local/metro/crime_is
        1 news
        2 local
        3 metro
        4 crime_is
        */
        //query table user_menu
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menuId = $queryMenu['id']; //menyimpan id menu yang sedang login 
        //query table user_access_menu
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menuId
        ]);

        if ($userAccess->num_rows() < 1) {
            //jika useracces yang login jumlah barisnya kurang dari 1 maka
            redirect('auth/blocked');
        }
    }
}

//function check_access menerima 2 parameter yaitu
//role_id dan menu_id
function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    //query database table user_access_menu masukan ke variabel
    $result = $ci->db->get_where('user_access_menu', [
        /*cek role_id yang di database sama dengan role_id yang ada di parameter
          cek juga menu id yang ada di database sama dengan menu id yang di kirim  */
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($result->num_rows() > 0) {
        //jika pengecekan result ada sesuai dengan data di database maka kembalikan nilai ke parameter "checked ='checked'"
        return "checked='checked'";
    }
}

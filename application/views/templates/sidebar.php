   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
           <div class="sidebar-brand-icon">
               <i class="fas fa-user-secret"></i>
           </div>
           <div class="sidebar-brand-text mx-1">Project Admin</div>
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider">

       <!-- QUERY MENU-->
       <!-- cara join 2 atau lebih tabel pada database dengan sql -->
       <!-- SELECT column-names
        FROM table-name1 
        JOIN table-name2 ON column-name1 = column-name2
        WHERE condition -->
       <?php
        //menyimpan data session role_id yang login ke variabel $role_id
        $role_id = $this->session->userdata('role_id');
        //    join tabel user_menu dan user_access_menu
        $queryMenu = "  SELECT `user_menu`.`id`, `menu` 
        /* memilih kolom id dan menu di tabel user_menu */
                        FROM `user_menu` JOIN `user_access_menu` 
        /* dari tabel user_menu di joinkan dengan tabel user_acces_menu */
                        ON `user_menu`.`id` = `user_access_menu`.`menu_id` 
        /* mengunci primary key dari user_menu dengan foren key 
        primary key user_menu = id
        foren key user_access_menu = menu_id */
                        WHERE `user_access_menu`.`role_id` = $role_id 
        /* kondisinya di tabel user access menu role_idnya sama dengan data role_id 
        yang ada di session (atau yang sedang login) 
        `user_access_menu`.`role_id` = data yang ada di database
        $role_id = data yang ada di session saat login */
                        ORDER BY `user_access_menu`.`menu_id` ASC
        /*mengurutkan berdasarkan menu_idnya ASC dari yang terkecil */
                        ";

        //memanggil querynya, result_array karena banyak
        $menu = $this->db->query($queryMenu)->result_array();
        //$menu sudah menampung apa yang di butuhkan

        ?>

       <!-- looping menu yang ada di table database -->
       <?php foreach ($menu as $m) : ?>
           <!-- Heading -->
           <div class="sidebar-heading">
               <!-- before = Administrator -->
               <?= $m['menu']; ?>
               <!--  menampilkan data dari table user_menu kolom menu -->
           </div>

           <!-- cara looping sub-menu sesuai menu yang ada di database -->
           <?php
            //    menyimpan data id di table user_menu ke variabel
            $menuId = $m['id'];
            //    membuat querynya terlebih dahulu
            $querySubMenu = "SELECT * FROM `user_sub_menu` /*memilih table user_sub_menu */
                            WHERE `menu_id` = $menuId /*untuk mengambil kolom menu_id di table user_sub_menu */
                            AND `is_active` = 1 /*dan kondisin sub-menunya masih active */
           ";

            //memasukan query kedalam result agar gbisa di tampilkan
            $subMenu = $this->db->query($querySubMenu)->result_array(); //kumpulan sub-menu berdasarkan Menu di user_menu
            ?>

           <!-- eksekusi untuk me-loopingnya -->
           <?php foreach ($subMenu as $sm) : ?>



               <!-- ketika judul sidebar sama dengan judul yang ada di database  -->
               <?php if ($title == $sm['title']) : ?>
                   <!-- true
            sidebar active -->
                   <li class="nav-item active">
                   <?php else : ?>
                       <!-- false sidebar nonactive-->
                   <li class="nav-item">
                   <?php endif; ?>


                   <!-- Sub-Menu -->
                   <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                       <!-- $sm-url = menampilkan data di table user_sub_menu kolom url -->
                       <i class="<?= $sm['icon']; ?>"></i>
                       <!-- $sm-icon = menampilkan data di table user_sub_menu kolom icon -->
                       <span><?= $sm['title']; ?></span>
                   </a>
                   <!-- $sm-title = menampilkan data di table user_sub_menu kolom title -->
                   </li>
               <?php endforeach;  ?>


               <!-- Divider -->
               <hr class="sidebar-divider mt-3">
           <?php endforeach; ?>



           <!-- Sidebar Toggler (Sidebar) -->
           <div class="text-center d-none d-md-inline">
               <button class="rounded-circle border-0" id="sidebarToggle"></button>
           </div>

   </ul>
   <!-- End of Sidebar -->
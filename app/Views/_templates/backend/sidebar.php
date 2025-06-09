<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-sidebar-alt sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                <div class="sidebar-brand-icon">
                    <img src="<?= UPLOAD_PATH . 'sites/'.$setting['site_logo']; ?>" alt="<?= $setting['site_name']; ?>" class="rounded-circle">
                </div>
                <div class="sidebar-brand-text mx-3">
                    <?= $setting['site_name_alt']; ?>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <?php
            if(!empty($mainmenu)) :
                foreach ($mainmenu as $value) : 
                if(!empty($submenu)) {
                    $index = array_search($value['menu_group'], array_column($submenu, 'menu_group'));
                } else {
                    $index = false;
                }
                if($index === false) {
            ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('blackhole/'.$value['menu_slug']) ?>">
                    <i class="<?= $value['menu_icon']; ?> mx-2"></i>
                    <span><?= $value['menu_label'] ?></span></a>
            </li>
            
            <?php } else { ?>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?= slug($value['menu_label']); ?>"
                    aria-expanded="true" aria-controls="<?= $value['menu_slug']; ?>">
                    <i class="<?= $value['menu_icon']; ?> mx-2"></i>
                    <span><?= $value['menu_label'] ?></span>
                </a>
                <div id="<?= slug($value['menu_label']); ?>" class="collapse" aria-labelledby="<?= $value['menu_label'] ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php 
                            foreach ($submenu as $sm) :
                            if($value['menu_group'] == $sm['menu_group']) :
                        ?>
                        <a class="collapse-item" href="<?= base_url('blackhole/'.$sm['menu_slug']); ?>"><i class="<?= $sm['menu_icon']; ?> mr-2"></i><?= $sm['menu_label'] ?></a>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
            </li>
            <?php } endforeach; endif;?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 bg-primary" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
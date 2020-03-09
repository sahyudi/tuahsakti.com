<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('home') ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-fw fa-cog"></i>
                <!-- <span class="badge badge-warning navbar-badge">15</span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- <span class="dropdown-item dropdown-header"></span> -->


                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-fw fa-user-cog mr-2"></i> Setting Profile
                    <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                    <i class="fas fa-fw fa-sign-out-alt mr-2"></i> Sign Out
                    <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
                </a>
                <!-- <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-th-large"></i></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('home') ?>" class="brand-link">
        <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TuahSakti</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $this->session->userdata('email') ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php $menu = $this->db->get_where('menus', ['parent_id' => 0])->result(); ?>
                <?php foreach ($menu as $key => $value) { ?>
                    <?php if ($value->link == '#' || $value->link == '') {  ?>
                        <!-- <li class="nav-item has-treeview menu-open"> -->
                        <li class="nav-item has-treeview">
                            <!-- <a href="#" class="nav-link active"> -->
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-fw <?= $value->icon ?>"></i>
                                <p>
                                    <?= $value->title ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $list = $this->db->get_where('menus', ['parent_id' => $value->id])->result();
                                foreach ($list as $sub => $list_menu) {
                                ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($list_menu->link) ?>" class="nav-link <?= ($list_menu->link == $active) ? 'active' : '' ?>">
                                            <i class="far <?= ($list_menu->icon) ? $list_menu->icon : 'fa-circle' ?>  fa-circle nav-icon"></i>
                                            <p><?= $list_menu->title ?></p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="<?= base_url($value->link) ?>" class="nav-link <?= ($value->link == $active) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-fw <?= $value->icon ?>"></i>
                                <p>
                                    <?= $value->title ?>
                                    <!-- <span class="right badge badge-danger">New</span> -->
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <li class="nav-header">LOGOUT</li>
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link active">
                        <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
                        <p class="text">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
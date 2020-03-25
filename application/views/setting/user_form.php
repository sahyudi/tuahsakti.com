<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form action="<?= base_url('setting/create_user') ?>" method="post">
                                    <div class="input-group">
                                        <select type="text" name="group" id="group" class="form-control form-control-sm select2" placeholder="Full name" value="<?= set_value('group') ?>">
                                            <option value=""></option>
                                            <?php foreach ($groups as $key => $value) { ?>
                                                <option value="<?= $value->id ?>" <?= (set_value('group') == $value->id) ? 'selected' : '' ?>><?= $value->group_name ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-users"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_error('group', '<small class="text-danger">', '</small>'); ?>
                                    <div class="input-group mt-3">
                                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Full name" value="<?= set_value('name') ?>">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                                    <div class="input-group mt-3">
                                        <input type="text" name="email" id="email" class="form-control form-control-sm" value="<?= set_value('email') ?>" placeholder="Email">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                    <div class="input-group mt-3">
                                        <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                                    <div class="input-group mt-3">
                                        <input type="password" name="password2" id="password2" class="form-control form-control-sm" placeholder="Retype password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="button" onclick="button_back()" class="btn btn-danger btn-sm">Back</button>
                                            <button type="submit" class="btn btn-primary btn-sm float-right">Register</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<!-- /.content-wrapper -->
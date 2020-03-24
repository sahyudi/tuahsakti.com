<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Privelage</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Privelage</li>
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
                <?= $this->session->flashdata('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Role Access</h3>
                    </div>
                    <!-- /.card-header -->
                    <form method="POST" action="<?= base_url('setting/update_privelage') ?>">
                        <input type="hidden" name="group_id" id="group_id" value="<?= $group_id ?>">
                        <div class="card-body">
                            <table class="table table-striped table-bordered tree">
                                <!-- Loop menu -->
                                <?php foreach ($menu as $key => $value) { ?>
                                    <?php if ($value->parent_id == 0) { ?>
                                        <tr>
                                            <td><input type="checkbox" name="menu[]" id="checkbox-<?= $value->id; ?>" value="<?= $value->id; ?>" <?= check_menu($group_id, $value->id) ?>> <?= $value->title; ?></td>
                                        </tr>
                                        <!-- Loop submenu -->
                                        <?php foreach ($menu as $key => $submenu) { ?>
                                            <?php if ($submenu->parent_id == $value->id) { ?>
                                                <tr class="m-3" style="margin-left:10%;">
                                                    <td><input class="ml-5" type="checkbox" id="checkbox-<?= $submenu->id; ?>" name="menu[]" value="<?= $submenu->id ?>" <?= check_menu($group_id, $submenu->id) ?>> <?= $submenu->title; ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="button_back()" class="btn btn-danger btn-sm float-left">Back</button>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Save Changes</button>
                        </div>
                    </form>
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
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });

    function confirm_delete() {
        return confirm('Apakah anda yakin akan mengahapus menu ini ?');
    }

    function clear_form() {
        $('#form-menu')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // $('#form-menu')[0].reset();
        $.ajax({
            url: "<?= base_url() . 'setting/get_menu/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#parent').val(data.parent_id);
                $('#title').val(data.title);
                $('#link').val(data.link);
                $('#icon').val(data.icon);
            }
        });
    });
</script>
<!-- /.content-wrapper -->
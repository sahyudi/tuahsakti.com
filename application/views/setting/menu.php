<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vendor</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol> -->
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
                        <h3 class="card-title">List Vedor</h3>
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-menu"><i class="fas fa-fw fa-plus"></i> Add Menu</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Parent ID</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu as $key => $value) { ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= get_parent_menu($value->parent_id) ?></td>
                                        <td><?= $value->title ?></td>
                                        <td><?= $value->link ?></td>
                                        <td><?= $value->icon ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('setting/deleteMenu/') . $value->id ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete()"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-menu" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

<div class="modal fade" id="modal-menu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('setting/add_menu') ?>" id="form-menu" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Parent Menu</label>
                        <select name="parent" id="parent" class="form-control select2">
                            <option value="0" selected>Parent ID</option>
                            <?php foreach ($parent as $key => $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->title ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="title menu">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Url Menu</label>
                        <input type="text" name="link" id="link" class="form-control" placeholder="Url ..">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Icon Menu</label>
                        <input name="icon" id="icon" class="form-control" placeholder="Icon Menu ...">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
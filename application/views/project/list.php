<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Project</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Project</h3>
                        <a href="<?= base_url('project/create_project') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-plus"></i> Add Project</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-penjualan" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Project No</th>
                                        <th>Nama</th>
                                        <th>Jenis Proyek</th>
                                        <th>Anggaran</th>
                                        <th>Pengeluaran</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sub_total = 0 ?>
                                    <?php foreach ($proyek as $key => $value) { ?>
                                        <?php $detail_pengeluaran = cek_pengeluaran_project($value->id); ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->proyek_no ?></td>
                                            <td><?= $value->nama_proyek ?></td>
                                            <td class="text-center"><?= ($value->jenis == 1) ? '<span class="badge badge-success">Internal</span>' : '<span class="badge badge-primary">External</span>' ?></td>
                                            <td class="text-right"><?= number_format($value->anggaran, 0) ?></td>
                                            <td class="text-right"><?= number_format($detail_pengeluaran, 0) ?></td>
                                            <td class="text-center"><?= cek_status($value->status) ?></td>
                                            <td><?= $value->deskripsi ?></td>
                                            <td class="text-right">
                                                <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-proyek" class="btn btn-xs btn-success btn-edit" title="Edit Data"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                                <a href="<?= base_url('project/delete_proyek/') . $value->id ?>" onclick="return confirm_delete()" class="btn btn-danger btn-xs"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="<?= base_url('project/info_detail/') . $value->id ?>" class="btn btn-info btn-xs"><i class="fas fa-fw fa-info"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end main content -->
</div>

<div class="modal fade" id="modal-proyek">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Project Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('project/update_project') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nomor Project</label>
                            <input type="text" class="form-control" id="proyek_no" name="proyek_no" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nama Project</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Anggaran</label>
                            <input type="text" name="anggaran" id="anggaran" class="form-control form-control-sm text-right" placeholder="Anggaran" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" cols="3" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Jenis Project</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="1">Internal</option>
                                <option value="2">External</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Status Project</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="0">On Progress</option>
                                <option value="1">Done</option>
                                <option value="2">Cancel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $("#table-penjualan").DataTable();
        $(":input").inputmask();
    });

    function reset_form() {
        $('#form-material')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'project/get_data_project/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#tanggal').val(data.tanggal);
                $('#proyek_no').val(data.proyek_no);
                $('#nama_proyek').val(data.nama_proyek);
                $('#anggaran').val(data.anggaran);
                $('#deskripsi').val(data.deskripsi);
                $('#jenis').val(data.jenis);
                $('#status').val(data.status);
            }
        });
    });
</script>
<!-- /.content-wrapper -->
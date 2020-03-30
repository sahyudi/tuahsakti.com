<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form Pengajuan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Form Pengajuan</li>
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
                        <h3 class="card-title">Form Pengajuan</h3>
                    </div>
                    <form action="<?= base_url('accounting/simpan_pengajuan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 float-right">
                                    <label for="">Nomor</label>
                                    <input type="text" class="form-control" name="nomor" id="nomor" value="" style="background-color: white;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tujuan">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="1" class="form-control"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <hr class="devider">
                                </div>
                                <div class="form-group col-md-12">
                                    <table class="table" id="table-item">
                                        <thead>
                                            <tr class="text-center text-bold">
                                                <th>Item</th>
                                                <th width="20%">Total</th>
                                                <th>Keterangan</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" id="jumlah-baris" value="1">
                                        <tbody>
                                            <tr class="material" id="material-0">
                                                <td>
                                                    <input type="text" class="form-control form-control-sm form-item" id="item-0" name="item[]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm form-sub_total text-right" onkeyup="hitung_total()" name="sub_total[]" id="sub_total-0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                                </td>
                                                <td>
                                                    <textarea name="ket_detail" id="ket_detail" class="form-control form-control-sm form-ket_detail"></textarea>
                                                </td>
                                                <td class="for-button">
                                                    <button class="btn btn-info btn-sm" onclick="addItem()" type="button"><i class="fas fa-fw fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right">Total</th>
                                                <th class="text-right" id="total"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('accounting/pengajuan') ?>" class="btn btn-danger btn-sm float-left">Back <i class="fas fa-fw fa-save"></i></a>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Submit <i class="fas fa-fw fa-save"></i></button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#example1").DataTable();
        $(":input").inputmask();
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');
    }

    function reset_form() {
        $('#form-item')[0].reset();
    }

    function hitung_total() {
        var total = 0;
        $('[name="sub_total[]"]').each(function(i, value) {
            total = parseInt(total) + parseInt($(value).val().replace(/\,/g, ''));
        });

        $('#total').html(`Rp. ${addCommas_general(total)}`);
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'accounting/get_item/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
            }
        });
    });

    function hapus(params) {
        $('#material-' + params).remove('');
        hitung_total()
    }

    function addItem() {
        $('.select2').select2('destroy');
        const rangeId = $('#jumlah-baris').val()
        const item = $('#material-0').first().clone();
        $('#table-item tbody').append(item);
        const id = 'material-' + rangeId;
        item.attr('id', id);
        $('#' + id + ' .form-item').attr({
            'id': 'item-' + rangeId,
        }).val('');
        $('#' + id + ' .form-ket_detail').attr({
            'id': 'ket_detail-' + rangeId,
        }).val('');
        $('#' + id + ' .form-sub_total').attr({
            'id': 'sub_total-' + rangeId,
            'onkeyup': 'hitung_total()'
        }).val(0);
        $('#' + id + ' button').remove();

        var btn = '<button type="button" onclick="hapus(' + rangeId + ')" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>';
        $('#' + id + ' .for-button').append(btn);
        $('#jumlah-baris').val(parseInt(parseInt(rangeId) + 1));
        $('.select2').select2();
        $(":input").inputmask();
    }
</script>
<!-- /.content-wrapper -->
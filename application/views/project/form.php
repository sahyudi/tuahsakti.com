<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form Project</h1>
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
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Form Project</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="<?= base_url('project/save_project') ?>" id="form-project" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Mulai</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" placeholder="No nota" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama Proyek">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Anggaran (Rp.)</label>
                                    <input type="text" class="form-control form-control-sm text-right" id="anggaran" name="anggaran" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" placeholder="Rp">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Deskripsi</label>
                                    <textarea name="deksripsi" id="deksripsi" class="form-control form-control-sm" rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Status Project</label> <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_project" id="inlineRadio1" value="1" checked>
                                        <label class="form-check-label" for="inlineRadio1">Internal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_project" id="inlineRadio2" value="2">
                                        <label class="form-check-label" for="inlineRadio2">External</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6"></div>
                                <div class="form-group col-md-6">
                                    <label for="">Item List &nbsp;&nbsp;&nbsp;
                                        <a href="#" data-toggle="modal" title="Tambah Material Baru" data-target="#modal-material" class="btn btn-primary btn-xs"><i class="fas fa-fw fa-plus"></i></a>
                                    </label>
                                    <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2">
                                        <option value=""></option>
                                    </select>
                                </div>


                            </div>

                            <hr>
                            <h5>List Material</h5>
                            <div class="row">
                                <table id="table-belanja" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 20%;">Item / Satuan</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Quantity</th>
                                            <th>Sub Total</th>
                                            <th style="width: 25%;">Ket Item</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" id="jumlah-baris" value="1">
                                        <tr id="remove-null">
                                            <td colspan="7" class="text-center">Item Belum dipilih</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">TOTAL</td>
                                            <td class="text-right">Rp. <span id="total"></span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tunai</label>
                                        <input type="text" name="tunai" id="tunai" class="form-control form-control-sm text-right" onkeyup="hitung_tunai()" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kredit</label>
                                        <input type="text" name="kredit" id="kredit" class="form-control form-control-sm text-right" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" readonly>
                                    </div>
                                    <div class="form-group" id="ket_kredit" style="display: none;">
                                        <label for="">Keterangan</label>
                                        <textarea name="ket_hutang" id="ket_hutang" class="form-control form-control-smss"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('project') ?>" class="btn btn-danger btn-sm float-left">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-material">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Material Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama material">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control form-control-sm" placeholder="Satuan">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" cols="3" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Harga Beli</label>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control form-control-sm text-right" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Harga Jual</label>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control form-control-sm text-right" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Upah Laut</label>
                            <input type="text" name="upah_laut" id="upah_laut" class="form-control form-control-sm text-right" placeholder="Upah Laut" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Upah Darat</label>
                            <input type="text" name="upah_darat" id="upah_darat" class="form-control form-control-sm text-right" placeholder="Upah Darat" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.setDefaults({
            submitHandler: function() {
                this
                $.ajax({
                    url: "<?= base_url('project/simpan_material'); ?>",
                    type: 'POST',
                    data: $('#form-material').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        get_item();
                        $('#modal-material').modal('hide');
                        $('#form-material')[0].reset();
                    }
                });
            }
        });
        $('#form-material').validate({
            rules: {
                nama: {
                    required: true
                },
                satuan: {
                    required: true
                },
                harga_beli: {
                    required: true
                },
                harga_jual: {
                    required: true
                },
                upah_laut: {
                    required: true
                },
                upah_darat: {
                    required: true
                },
            },
            messages: {
                nama: {
                    required: "Please enter a nama.."
                },
                satuan: {
                    required: "Please enter a satuan.."
                },
                harga_jual: {
                    required: "Please enter a harga jual"
                },
                harga_beli: {
                    required: "Please enter a harga beli"
                },
                upah_laut: {
                    required: "Please enter a upah laut"
                },
                upah_darat: {
                    required: "Please enter a upah darat"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    $(document).ready(function() {
        get_item();
        $(":input").inputmask();
    });

    function cek_item_input() {
        const item_select = [];

        $('[name="item[]"]').each(function(i, value) {
            item_select[i] = $(value).val();
        });
        if (item_select.length < 1) {
            alert('Silakan pilih item terlebih dahulu');
            return false;
        } else {
            return confirm('Apakah anda yakin akan menyimpan data ?');
        }
    }

    function get_item() {
        const item_select = [];
        $('[name="item[]"]').each(function(i, value) {
            item_select[i] = $(value).val();
        });


        $.ajax({
            url: "<?= base_url('pos/get_item_list'); ?>",
            type: 'POST',
            data: {
                id: item_select
            },
            dataType: 'json',
            success: function(data) {
                $('#item-select').empty();
                $('.select2').select2('destroy');
                var item = '<option value=""></option>';

                $.each(data, function(i, val) {
                    item += `<option value="${val.id}">${val.nama}</option>`;
                });
                $('#item-select').append(item);
                $('.select2').select2();
            }
        });
    }

    function hitung_sub_total(id) {
        var sub_total = 0;
        const qty_awal = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga-' + id).val().replace(/\,/g, ''));
        const harga_beli = parseInt($('#harga_beli-' + id).val().replace(/\,/g, ''));
        if (qty_awal < 1 || qty_awal == 'NaN') {
            var qty = 1;
        } else {
            var qty = qty_awal;
        }
        sub_total = qty * harga;
        if (sub_total > 0) {
            $('#sub_total-' + id).val(addCommas(sub_total));
        } else {
            $('#sub_total-' + id).val(0);
        }

        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }
        // $('#qty-' + id).val(addCommas(qty));
        // $('#harga-' + id).val(addCommas(return_harga));
        // $('#harga_beli-' + id).val(addCommas(harga_beli));
        hitungtotal();
    }

    function hitung_tunai() {
        const total = parseInt($('#total').html().replace(/\,/g, ''));
        const tunai = $('#tunai').val().replace(/\,/g, '');

        console.log(tunai);
        const grand_total = parseInt(tunai) - total;
        console.log(grand_total);
        $('#kredit').val(grand_total);
        if (grand_total < 0) {
            $('#ket_kredit').css('display', 'block');
        } else {
            $('#ket_kredit').css('display', 'none');
        }
        // $('#tunai').val(addCommas(tunai));
    }

    function hitungtotal() {
        const rangeId = $('#jumlah-baris').val();
        var sumHarga = 0;

        for (let index = 1; index < parseInt(rangeId); index++) {
            if ($('#sub_total-' + index).length != 0) {
                var SubTotal = $('#sub_total-' + index).val();
                if (SubTotal == null || SubTotal == '') {
                    SubTotal = 0;
                }
                sumHarga += parseInt(SubTotal.replace(/\,/g, ''));
            }
        }
        $('#total').html(addCommas(sumHarga));
    }

    function addItem() {
        var id = $('#item-select').val();
        const rangeId = $('#jumlah-baris').val();
        $.ajax({
            url: "<?= base_url('project/get_item/') ?>" + id,
            type: "post",
            dataType: 'JSON',
            success: function(data) {
                $('#remove-null').remove();
                let item = `
                                <tr class="material" id="material-${rangeId}">
                                    <td>
                                        <input type="hidden" class="form-control form-control-sm form-item" id="item-${rangeId}" name="item[]" value="${id}">
                                        ${data.nama} (${data.satuan})
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-harga_beli text-right" name="harga_beli[]" id="harga_beli-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="${addCommas(data.harga_beli)}" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-harga text-right" name="harga[]" id="harga-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="${data.harga_jual}" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}"  onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="1" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" value="0" readonly>
                                    </td>
                                    <td>
                                        <textarea type="text" class="form-control form-control-sm form-ket_item text-right" name="ket_item[]" id="ket_item-${rangeId}"></textarea>
                                    </td>
                                    <td class="for-button text-center">
                                        <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger "><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            `;
                $('#table-belanja tbody').append(item);
                $('#item-select').val('');
                $('#jumlah-baris').val(parseInt(rangeId) + parseInt(1));
                get_item();
                hitung_sub_total(rangeId);
                $(":input").inputmask();
            }
        });


    }

    function hapus(params) {
        var id = 'material-' + params;
        $('#' + id).remove('');
        if ($('.material').length < 1) {
            $('#remove-null').remove();
            const nul = `<tr id="remove-null"><td colspan="8" class="text-center">Item Belum dipilih</td></tr>`;
            $('#table-belanja tbody').append(nul);
        }
        get_item();
    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('input[type="checkbox"]:checked').click(function() {
        var val = $(this).val();
        if (val == 'darat') {
            $('#laut').removeAttr('checked')
        } else {
            $('#darat').removeAttr('checked')
        }
    })
</script>
<!-- /.content-wrapper -->
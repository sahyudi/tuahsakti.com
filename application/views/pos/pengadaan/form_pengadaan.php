<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Pengadaan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                    </div>
                </div>
                <form action="<?= base_url('pos/simpan_pengadaan') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" placeholder="No nota" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Surat Jalan</label>
                                <input type="text" class="form-control form-control-sm" name="surat_jalan" id="surat_jalan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Item List</label>
                                <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2" onchange="addItem()">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <h5>List Item</h5>
                        <div class="row">
                            <table class="table" id="table-material">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 45%;">Item / Satuan</th>
                                        <th>Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" id="jumlah-baris" value="1">
                                    <tr id="remove-null">
                                        <td colspan="6" class="text-center">Item Belum dipilih</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button onclick="button_back()" type="button" class="btn btn-danger btn-sm float-left">Back</button>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<!-- end main content -->
</div>

<script type="text/javascript">
    $(function() {
        $('.select2').select2({
            'placeholder': 'Select one',
            theme: 'boostrap4',
        });
        get_item();
        $(":input").inputmask();
    });

    function addItem() {
        var id = $('#item-select').val();
        const rangeId = $('#jumlah-baris').val();
        $.ajax({
            url: "<?= base_url('pos/get_item_pengadaan/') ?>" + id,
            type: "post",
            dataType: 'JSON',
            success: function(data) {
                $('#remove-null').remove();
                let item = `
                            <tr class="material" id="material-${rangeId}">
                                <td>
                                    <input type="hidden" class="form-control form-control-sm form-item" id="item-${rangeId}" name="item[]" value="${id}">
                                    ${data.nama} / ${data.satuan}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" value="1" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>                                
                                <td class="for-button">
                                    <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                </td>
                            </tr>
                            `;
                $('#table-material tbody').append(item);
                $('#item-select').val('');
                $('#jumlah-baris').val(parseInt(rangeId) + parseInt(1));
                get_item();
                $(":input").inputmask();
            }
        });


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



    function getItem(id, urutan) {
        //     $.ajax({
        //         url: "<?= base_url('pengadaan/get_satuan/') ?>" + id.value,
        //         type: "post",
        //         dataType: 'JSON',
        //         success: function(data) {
        //             $('#satuan-' + urutan).html(data.satuan);
        //         }
        //     });
    }

    function hitung_tunai() {
        const total = parseInt($('#total').html().replace(/\,/g, ''));
        const tunai = $('#tunai').val().replace(/\,/g, '');
        if (tunai > total) {
            var tunai_baru = total;
        } else {
            var tunai_baru = tunai;
        }
        $('#kredit').val(addCommas(total - parseInt(tunai_baru)));
        $('#tunai').val(addCommas(tunai_baru));
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
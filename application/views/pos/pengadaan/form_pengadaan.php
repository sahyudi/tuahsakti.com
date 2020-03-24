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
                                    <tr class="material" id="material-0">
                                        <td>
                                            <select onchange="getItem(this,0)" class="form-control form-control-sm select2 form-item" id="item-0" name="item[]">
                                                <option value=""></option>
                                                <?php foreach ($material as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->nama . " / " . $value->satuan ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-0" onkeyup="hitung_sub_total(0)" value="0">
                                        </td>
                                        <td class="for-button">
                                            <button type="button" class="btn btn-info btn-sm btn-add" onclick="addItem()"><i class="fa fa-plus"></i></button>
                                        </td>
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
    });

    function addItem() {
        $('.select2').select2('destroy');
        const rangeId = $('#jumlah-baris').val()
        const item = $('#material-0').first().clone();
        $('#table-material tbody').append(item);
        const id = 'material-' + rangeId;
        item.attr('id', id);
        $('#' + id + ' .form-item').attr({
            'id': 'item-' + rangeId,
            'onchange': "getItem(this," + rangeId + ")"
        });
        $('#' + id + ' .form-qty').attr({
            'id': 'qty-' + rangeId,
            'onkeyup': 'hitung_sub_total(' + rangeId + ')'
        }).val(0);
        $('#' + id + ' button').remove();

        var btn = '<button href="#" onclick="hapus(' + rangeId + ')" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>';
        $('#' + id + ' .for-button').append(btn);
        $('#jumlah-baris').val(parseInt(parseInt(rangeId) + 1));
        //$(".select2").select2("destroy").select2();
        $(".select2").select2();
    }

    function hapus(params) {
        var id = 'material-' + params;
        $('#' + id).remove('');
    }


    function hitung_sub_total(id) {
        var sisaStock = 0;
        const qty = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga_beli-' + id).val().replace(/\,/g, ''));

        sisaStock = qty * harga;
        if (sisaStock > 0) {
            $('#sub_total-' + id).val(addCommas(sisaStock));
        } else {
            $('#sub_total-' + id).val(0);
        }
        if (qty > 0) {
            return_qty = qty;
        } else {
            return_qty = 0;
        }
        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }
        $('#qty-' + id).val(addCommas(return_qty));
        $('#harga_beli-' + id).val(addCommas(return_harga));
        hitungtotal();
    }

    function hitungtotal() {
        const rangeId = $('#jumlah-baris').val();
        var sumHarga = 0;

        for (let index = 0; index < parseInt(rangeId); index++) {
            if ($('#sub_total-' + index).length != 0) {
                var SubTotal = $('#sub_total-' + index).val();
                if (SubTotal == null || SubTotal == '') {
                    SubTotal = 0;
                }
                sumHarga += parseInt(SubTotal.replace(/\,/g, ''));
            }
        }
        $('#total').html(addCommas(sumHarga));
        const kredit = sumHarga - $('#tunai').val().replace(/\,/g, '');
        $('#kredit').val(addCommas(kredit))
        // console.log(sumHarga);
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
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Material</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                    </div>
                </div>
                <form action="<?= base_url('pos/simpan_item_master') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama material">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control form-control-sm" placeholder="Harag jual">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Harga Jual</label>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control form-control-sm text-right" placeholder="Harga Jual">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Upah Laut</label>
                                <input type="number" name="upah_laut" id="upah_laut" class="form-control form-control-sm text-right" placeholder="Upah Laut">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Upah Darat</label>
                                <input type="number" name="upah_darat" id="upah_darat" class="form-control form-control-sm text-right" placeholder="Upah Darat">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" cols="3" placeholder="Keterangan"></textarea>
                            </div>
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

        const id = "<?= !empty($id) ? $id : '' ?>";

        if (id) {
            get_edit_item(id);
        }

    });

    function get_edit_item(id) {
        $.ajax({
            url: "<?= base_url() . 'pos/get_item_master/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#satuan').val(data.satuan);
                $('#harga_jual').val(data.harga_jual);
                $('#keterangan').val(data.keterangan);
                $('#upah_laut').val(data.upah_laut);
                $('#upah_darat').val(data.upah_darat);
            }
        });
    }
</script>
<!-- /.content-wrapper -->
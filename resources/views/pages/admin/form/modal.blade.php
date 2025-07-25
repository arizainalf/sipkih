<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data <Form:post></Form:post>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah">
                <div class="modal-body">
                    <div class="form-group mb-1">
                        <label form="nama">Nama</label>
                        <textarea name="nama" id="nama" class="form-control"></textarea>
                        <div class="invalid-feedback" id="errornama"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="aktif" value="1"
                                checked>
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="tidak_aktif"
                                value="0">
                            <label class="form-check-label" for="tidak_aktif">Tidak Aktif</label>
                        </div>
                        <div class="invalid-feedback" id="errorstatus"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

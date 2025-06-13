<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Ibu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah">
                <div class="modal-body">
                    <div class="form-group mb-1">
                        <label for="ibu_id">Ibu</label>
                        <select name="ibu_id" id="ibu_id" class="form-control">
                        </select>
                        <div class="invalid-feedback" id="erroribu_id"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label id="anak_ke">Kehamilan anak ke</label>
                        <input type="number" name="anak_ke" id="anak_ke" class="form-control">
                        <div class="invalid-feedback" id="erroranak_ke"></div>
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

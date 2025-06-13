<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Ibu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah">
                <div class="modal-body">

                    <!-- Kolom Kiri -->
                    <div class="form-group mb-1">
                        <label for="ibu_id">Ibu</label>
                        <select class="form-control" name="ibu_id" id="ibu_id" required>
                        </select>
                        <div class="invalid-feedback" id="erroribu_id"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="alasan">Alasan</label>
                        <input type="text" class="form-control" name="alasan" required>
                        <div class="invalid-feedback" id="erroralasan"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="tanggal_rujukan">Tanggal Rujukan</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="tanggal_rujukan"
                            required>
                        <div class="invalid-feedback" id="errortanggal_rujukan"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="diagnosa_akhir">Diagnosa Akhir</label>
                        <input type="text" class="form-control" name="diagnosa_akhir" required>
                        <div class="invalid-feedback" id="errordiagnosa_akhir"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="anjuran">Anjuran</label>
                        <input type="text" class="form-control" name="anjuran" required>
                        <div class="invalid-feedback" id="erroranjuran"></div>
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

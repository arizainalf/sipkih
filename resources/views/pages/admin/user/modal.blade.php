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

                    <div class="form-group mb-1">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                        <div class="invalid-feedback" id="errornama"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" required>
                        <div class="invalid-feedback" id="erroremail"></div>
                    </div>

                    <div class="form-group mb-1" id="password-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password" required>
                        <div class="invalid-feedback" id="errorpassword"></div>
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

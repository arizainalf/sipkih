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
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Kolom Kiri -->
                            <div class="form-group mb-1">
                                <label>NIK</label>
                                <input type="text" class="form-control" name="nik" required maxlength="16">
                                <div class="invalid-feedback" id="errornik"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" required>
                                <div class="invalid-feedback" id="errornama"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Pembiayaan</label>
                                <select class="form-control" name="pembiayaan" required>
                                    <option value="">Pilih Pembiayaan</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="KIS">KIS</option>
                                    <option value="KIP">KIP</option>
                                </select>
                                <div class="invalid-feedback" id="errorpembiayaan"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>No JKN</label>
                                <input type="text" class="form-control" name="no_jkn">
                                <div class="invalid-feedback" id="errorno_jkn"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Golongan Darah</label>
                                <select class="form-control" name="golongan_darah">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                <div class="invalid-feedback" id="errorgolongan_darah"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Kolom Kanan -->
                            <div class="form-group mb-1">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control" name="tempat_lahir">
                                <div class="invalid-feedback" id="errortempat_lahir"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir">
                                <div class="invalid-feedback" id="errortanggal_lahir"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Pendidikan</label>
                                <select class="form-control" name="pendidikan">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA/SMK</option>
                                    <option value="d3">D3</option>
                                    <option value="s1">S1</option>
                                    <option value="s2">S2</option>
                                    <option value="s3">S3</option>
                                </select>
                                <div class="invalid-feedback" id="errorpendidikan"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" name="pekerjaan">
                                <div class="invalid-feedback" id="errorpekerjaan"></div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Telepon</label>
                                <input type="text" class="form-control" name="telepon">
                                <div class="invalid-feedback" id="errortelepon"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-1">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" rows="2"></textarea>
                        <div class="invalid-feedback" id="erroralamat"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label>Nama Suami</label>
                        <input type="text" class="form-control" name="suami">
                        <div class="invalid-feedback" id="errorsuami"></div>
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

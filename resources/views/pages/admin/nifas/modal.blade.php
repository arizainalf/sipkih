<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Nifas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kehamilan_id">Kehamilan</label>
                                <select name="kehamilan_id" id="kehamilan_id" class="form-control select2" required>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pemeriksaan</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="periksa_asi"
                                        name="periksa_asi" value="1">
                                    <label class="custom-control-label" for="periksa_asi">Periksa ASI</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="periksa_perdarahan"
                                        name="periksa_perdarahan" value="1">
                                    <label class="custom-control-label" for="periksa_perdarahan">Periksa
                                        Perdarahan</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="periksa_jalan_lahir"
                                        name="periksa_jalan_lahir" value="1">
                                    <label class="custom-control-label" for="periksa_jalan_lahir">Periksa Jalan
                                        Lahir</label>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vitamin_a">Vitamin A</label>
                                <input type="text" class="form-control" id="vitamin_a" name="vitamin_a"
                                    placeholder="Misal: 200.000 IU">
                            </div>

                            <div class="form-group">
                                <label for="kb_pasca_kelahiran">KB Pasca Kelahiran</label>
                                <select name="kb_pasca_kelahiran" id="kb_pasca_kelahiran" class="form-control">
                                    <option value="">Pilih KB</option>
                                    <option value="suntik">Suntik</option>
                                    <option value="pil">Pil</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Layanan</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="konseling" name="konseling"
                                        value="1">
                                    <label class="custom-control-label" for="konseling">Konseling</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="tata_laksana_kasus"
                                        name="tata_laksana_kasus" value="1">
                                    <label class="custom-control-label" for="tata_laksana_kasus">Tata Laksana
                                        Kasus</label>
                                </div>
                            </div>
                        </div>
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

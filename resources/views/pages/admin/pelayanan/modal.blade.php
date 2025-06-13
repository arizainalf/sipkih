<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Pelayanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="kehamilan_id">Kehamilan</label>
                        <select name="kehamilan_id" id="kehamilan_id" class="form-control" required>
                            <!-- Options akan diisi via JavaScript -->
                        </select>
                        <div class="invalid-feedback" id="errorkehamilan_id"></div>
                    </div>
                    <div class="row">
                        <!-- Kolom 1 -->

                        <div class="col-md-6">

                            <div class="form-group mb-2">
                                <label for="trismester">Trimester</label>
                                <select name="trismester" id="trismester" class="form-control" required>
                                    <option value="">Pilih Trimester</option>
                                    <option value="1">Trimester 1</option>
                                    <option value="2">Trimester 2</option>
                                    <option value="3">Trimester 3</option>
                                </select>
                                <div class="invalid-feedback" id="errortrismester"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tanggal_periksa">Tanggal Periksa</label>
                                <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback" id="errortanggal_periksa"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tb">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" name="tb" id="tb" class="form-control"
                                    required>
                                <div class="invalid-feedback" id="errortb"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="bb">Berat Badan (kg)</label>
                                <input type="number" step="0.1" name="bb" id="bb" class="form-control"
                                    required>
                                <div class="invalid-feedback" id="errorbb"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="lingkar_lengan_atas">Lingkar Lengan Atas (cm)</label>
                                <input type="number" step="0.1" name="lingkar_lengan_atas" id="lingkar_lengan_atas"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errorlingkar_lengan_atas"></div>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="detak_jantung_janin">Detak Jantung Janin</label>
                                <input type="text" name="detak_jantung_janin" id="detak_jantung_janin"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errordetak_jantung_janin"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tinggi_rahim">Tinggi Rahim (cm)</label>
                                <input type="number" step="0.1" name="tinggi_rahim" id="tinggi_rahim"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errortinggi_rahim"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="konseling">Konseling</label>
                                <input type="text" name="konseling" id="konseling" class="form-control" required>
                                <div class="invalid-feedback" id="errorkonseling"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="test_hb">Test HB (g/dL)</label>
                                <input type="text" name="test_hb" id="test_hb" class="form-control" required>
                                <div class="invalid-feedback" id="errortest_hb"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="test_golongan_darah">Test Golongan Darah</label>
                                <select name="test_golongan_darah" id="test_golongan_darah" class="form-control"
                                    required>
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                <div class="invalid-feedback" id="errortest_golongan_darah"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Baris tambahan untuk field baru -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="test_protein_urin">Test Protein Urin</label>
                                <select name="test_protein_urin" id="test_protein_urin" class="form-control"
                                    required>
                                    <option value="">Pilih Hasil</option>
                                    <option value="Negatif">Negatif</option>
                                    <option value="Trace">Trace</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                    <option value="+4">+4</option>
                                </select>
                                <div class="invalid-feedback" id="errortest_protein_urin"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="test_gula_darah">Test Gula Darah (mg/dL)</label>
                                <input type="text" name="test_gula_darah" id="test_gula_darah"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errortest_gula_darah"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="ppia">PPIA</label>
                                <select name="ppia" id="ppia" class="form-control" required>
                                    <option value="">Pilih Status PPIA</option>
                                    <option value="reaktif">Reaktif</option>
                                    <option value="non reaktif">Non Reaktif</option>
                                </select>
                                <div class="invalid-feedback" id="errorppia"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="usg">Hasil USG</label>
                                <input type="text" name="usg" id="usg" class="form-control" required>
                                <div class="invalid-feedback" id="errorusg"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Textarea untuk input panjang -->
                    <div class="form-group mb-2">
                        <label for="tata_laksana_kasus">Tata Laksana Kasus</label>
                        <textarea name="tata_laksana_kasus" id="tata_laksana_kasus" class="form-control" rows="3"></textarea>
                        <div class="invalid-feedback" id="errortata_laksana_kasus"></div>
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

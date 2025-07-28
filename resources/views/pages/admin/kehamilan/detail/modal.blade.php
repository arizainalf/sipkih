<div class="modal fade" id="modal-tambah-pelayanan" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Pelayanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-pelayanan">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="{{ $kehamilan->id }}" name="kehamilan_id">
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
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="tablet_tambah_darah">Tablet Tambah Darah</label>
                                <input type="text" name="tablet_tambah_darah" id="tablet_tambah_darah"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errortablet_tambah_darah"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="imunisasi_tetanus">Status Imunisasi dan Tetanus</label>
                                <input type="text" name="imunisasi_tetanus" id="imunisasi_tetanus"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errorimunisasi_tetanus"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="tablet_tambah_darah">Tablet Tambah Darah</label>
                                <input type="text" name="tablet_tambah_darah" id="tablet_tambah_darah"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errortablet_tambah_darah"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="imunisasi_tetanus">Status Imunisasi dan Tetanus</label>
                                <input type="text" name="imunisasi_tetanus" id="imunisasi_tetanus"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="errorimunisasi_tetanus"></div>
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

<div class="modal fade" id="modal-tambah-nifas" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-nifas" id="modalLabel">Tambah Data Nifas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-nifas">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">

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
                                    <input type="checkbox" class="custom-control-input" id="konseling_nifas"
                                        name="konseling" value="1">
                                    <label class="custom-control-label" for="konseling_nifas">Konseling</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="tata_laksana_kasus_nifas"
                                        name="tata_laksana_kasus" value="1">
                                    <label class="custom-control-label" for="tata_laksana_kasus_nifas">Tata Laksana
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

<div class="modal fade" id="modal-persalinan" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Persalinan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-persalinan">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="ibu_id">Ibu</label>
                        <select name="ibu_id" id="ibu_id" class="form-control" required>
                            <!-- Options akan diisi via JavaScript -->
                        </select>
                        <div class="invalid-feedback" id="error-ibu_id"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="tanggal_persalinan">Tanggal Persalinan</label>
                                <input type="date" name="tanggal_persalinan" id="tanggal_persalinan"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-tanggal_persalinan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="waktu_persalinan">Waktu Persalinan</label>
                                <input type="time" name="waktu_persalinan" id="waktu_persalinan"
                                    class="form-control">
                                <div class="invalid-feedback" id="error-waktu_persalinan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="umur_kehamilan_minggu">Umur Kehamilan (minggu)</label>
                                <input type="number" name="umur_kehamilan_minggu" id="umur_kehamilan_minggu"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-umur_kehamilan_minggu"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="penolong_persalinan">Penolong Persalinan</label>
                                <select name="penolong_persalinan" id="penolong_persalinan" class="form-control"
                                    required>
                                    <option value="">Pilih Penolong</option>
                                    <option value="SpOG">SpOG</option>
                                    <option value="Dokter Umum">Dokter Umum</option>
                                    <option value="Bidan">Bidan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback" id="error-penolong_persalinan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="cara_persalinan">Cara Persalinan</label>
                                <select name="cara_persalinan" id="cara_persalinan" class="form-control" required>
                                    <option value="">Pilih Cara</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Forceps">Forceps</option>
                                    <option value="Vakum">Vakum</option>
                                    <option value="Sectio Caesarea">Sectio Caesarea</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback" id="error-cara_persalinan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="keadaan_ibu">Keadaan Ibu</label>
                                <select name="keadaan_ibu" id="keadaan_ibu" class="form-control" required>
                                    <option value="">Pilih Keadaan</option>
                                    <option value="Sehat">Sehat</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Meninggal">Meninggal</option>
                                </select>
                                <div class="invalid-feedback" id="error-keadaan_ibu"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="detail_keadaan_ibu">Detail Keadaan Ibu</label>
                        <textarea name="detail_keadaan_ibu" id="detail_keadaan_ibu" class="form-control" rows="2"></textarea>
                        <div class="invalid-feedback" id="error-detail_keadaan_ibu"></div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="kb_pasca_persalinan">KB Pasca Persalinan</label>
                        <input type="text" name="kb_pasca_persalinan" id="kb_pasca_persalinan"
                            class="form-control">
                        <div class="invalid-feedback" id="error-kb_pasca_persalinan"></div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="keterangan_tambahan">Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="2"></textarea>
                        <div class="invalid-feedback" id="error-keterangan_tambahan"></div>
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

<div class="modal fade" id="modal-bayi" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Data Bayi Baru Lahir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-bayi">
                @csrf
                <input type="hidden" name="persalinan_id" id="persalinan_id">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="anak_ke">Anak Ke</label>
                                <input type="number" name="anak_ke" id="anak_ke" class="form-control" required>
                                <div class="invalid-feedback" id="error-anak_ke"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="berat_lahir_gram">Berat Lahir (gram)</label>
                                <input type="number" name="berat_lahir_gram" id="berat_lahir_gram"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-berat_lahir_gram"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="panjang_badan_cm">Panjang Badan (cm)</label>
                                <input type="number" step="0.1" name="panjang_badan_cm" id="panjang_badan_cm"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-panjang_badan_cm"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="lingkar_kepala_cm">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" name="lingkar_kepala_cm" id="lingkar_kepala_cm"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-lingkar_kepala_cm"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Tidak bisa ditentukan">Tidak bisa ditentukan</option>
                                </select>
                                <div class="invalid-feedback" id="error-jenis_kelamin"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">Kondisi Bayi Saat Lahir</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="segera_menangis"
                                            id="segera_menangis">
                                        <label class="form-check-label" for="segera_menangis">Segera menangis</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="menangis_beberapa_saat"
                                            id="menangis_beberapa_saat">
                                        <label class="form-check-label" for="menangis_beberapa_saat">Menangis beberapa
                                            saat</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="tidak_menangis"
                                            id="tidak_menangis">
                                        <label class="form-check-label" for="tidak_menangis">Tidak menangis</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"
                                            name="seluruh_tubuh_kemerahan" id="seluruh_tubuh_kemerahan">
                                        <label class="form-check-label" for="seluruh_tubuh_kemerahan">Seluruh tubuh
                                            kemerahan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="anggota_gerak_kebiruan"
                                            id="anggota_gerak_kebiruan">
                                        <label class="form-check-label" for="anggota_gerak_kebiruan">Anggota gerak
                                            kebiruan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="seluruh_tubuh_biru"
                                            id="seluruh_tubuh_biru">
                                        <label class="form-check-label" for="seluruh_tubuh_biru">Seluruh tubuh
                                            biru</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="kelainan_bawaan">Kelainan bawaan</label>
                                        <input type="text" name="kelainan_bawaan" id="kelainan_bawaan"
                                            class="form-control">
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="meninggal"
                                            id="meninggal">
                                        <label class="form-check-label" for="meninggal">Meninggal</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">Asuhan Bayi Baru Lahir</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="imd"
                                            id="imd">
                                        <label class="form-check-label" for="imd">Inisiasi Menyusu Dini
                                            (IMD)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vitamin_k1"
                                            id="vitamin_k1">
                                        <label class="form-check-label" for="vitamin_k1">Suntikan Vitamin K1</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="salep_mata"
                                            id="salep_mata">
                                        <label class="form-check-label" for="salep_mata">Salep mata antibiotika
                                            profilaksis</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="imunisasi_hb0"
                                            id="imunisasi_hb0">
                                        <label class="form-check-label" for="imunisasi_hb0">Imunisasi HB0</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="keterangan_tambahan">Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="2"></textarea>
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

<div class="modal fade" id="modal-kunjungan-nifas" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Kunjungan Nifas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-kunjungan-nifas">
                @csrf
                <input type="hidden" name="persalinan_id" id="persalinan_id_kunjungan">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="jenis_kunjungan">Jenis Kunjungan</label>
                                <select name="jenis_kunjungan" id="jenis_kunjungan" class="form-control" required>
                                    <option value="">Pilih Jenis Kunjungan</option>
                                    <option value="KF1">KF1 (6-48 jam)</option>
                                    <option value="KF2">KF2 (3-7 hari)</option>
                                    <option value="KF3">KF3 (8-28 hari)</option>
                                    <option value="KF4">KF4 (29-42 hari)</option>
                                </select>
                                <div class="invalid-feedback" id="error-jenis_kunjungan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                                    class="form-control" required>
                                <div class="invalid-feedback" id="error-tanggal_kunjungan"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="faskes">Fasilitas Kesehatan</label>
                                <input type="text" name="faskes" id="faskes" class="form-control" required>
                                <div class="invalid-feedback" id="error-faskes"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="masalah">Masalah yang Ditemukan</label>
                                <textarea name="masalah" id="masalah" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tindakan">Tindakan</label>
                                <textarea name="tindakan" id="tindakan" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- KF1 Specific -->
                    <div class="card mb-3 kf1-fields">
                        <div class="card-header">KF1 - 6-48 Jam</div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="asi" id="asi">
                                <label class="form-check-label" for="asi">ASI</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="belum_asi" id="belum_asi">
                                <label class="form-check-label" for="belum_asi">BELUM ASI</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="trauma" id="trauma">
                                <label class="form-check-label" for="trauma">Trauma</label>
                            </div>
                            <div class="form-group mb-2">
                                <label for="message">Message</label>
                                <input type="text" name="message" id="message" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- KF2 Specific -->
                    <div class="card mb-3 kf2-fields">
                        <div class="card-header">KF2 - 3-7 Hari</div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="belum_bab" id="belum_bab">
                                <label class="form-check-label" for="belum_bab">BELUM BAB</label>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ayruba">Ayruba</label>
                                <input type="text" name="ayruba" id="ayruba" class="form-control">
                            </div>
                            <div class="form-group mb-2">
                                <label for="mudra">Mudra</label>
                                <input type="text" name="mudra" id="mudra" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- KF3 Specific -->
                    <div class="card mb-3 kf3-fields">
                        <div class="card-header">KF3 - 8-28 Hari</div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="tetanus" id="tetanus">
                                <label class="form-check-label" for="tetanus">Tetanus</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="keterangan_tambahan">Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" id="keterangan_tambahan_kunjungan" class="form-control" rows="2"></textarea>
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

<div class="modal fade" id="modal-kesimpulan-nifas" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Kesimpulan Akhir Nifas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-kesimpulan-nifas">
                @csrf
                <input type="hidden" name="persalinan_id" id="persalinan_id_kesimpulan">

                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header">Keadaan Ibu</div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="keadaan_ibu"
                                    id="keadaan_ibu_sehat" value="Sehat" required>
                                <label class="form-check-label" for="keadaan_ibu_sehat">Sehat</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="keadaan_ibu"
                                    id="keadaan_ibu_sakit" value="Sakit">
                                <label class="form-check-label" for="keadaan_ibu_sakit">Sakit</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="keadaan_ibu"
                                    id="keadaan_ibu_meninggal" value="Meninggal">
                                <label class="form-check-label" for="keadaan_ibu_meninggal">Meninggal</label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">Komplikasi Nifas</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="perdarahan"
                                            id="perdarahan">
                                        <label class="form-check-label" for="perdarahan">Perdarahan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="infeksi"
                                            id="infeksi">
                                        <label class="form-check-label" for="infeksi">Infeksi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="hipertensi"
                                            id="hipertensi">
                                        <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="komplikasi_lain">Lain-lain</label>
                                        <input type="text" name="komplikasi_lain" id="komplikasi_lain"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">Keadaan Bayi</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="keadaan_bayi"
                                            id="keadaan_bayi_sehat" value="Sehat" required>
                                        <label class="form-check-label" for="keadaan_bayi_sehat">Sehat</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="keadaan_bayi"
                                            id="keadaan_bayi_sakit" value="Sakit">
                                        <label class="form-check-label" for="keadaan_bayi_sakit">Sakit</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="kelainan_bawaan">Kelainan Bawaan</label>
                                        <input type="text" name="kelainan_bawaan" id="kelainan_bawaan_kesimpulan"
                                            class="form-control">
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="keadaan_bayi"
                                            id="keadaan_bayi_meninggal" value="Meninggal">
                                        <label class="form-check-label" for="keadaan_bayi_meninggal">Meninggal</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label for="kesimpulan">Kesimpulan</label>
                        <textarea name="kesimpulan" id="kesimpulan" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback" id="error-kesimpulan"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Kesimpulan</button>
                </div>
            </form>
        </div>
    </div>
</div>

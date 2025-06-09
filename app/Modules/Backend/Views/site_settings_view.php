    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row position-relative">
            <div class="img-container">

            <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
            </div>
            <div class="col-12">
            <div class="card mb-4 border-custom mx-auto">
                <div class="card-header">
                    <h6>Site Settings</h6>
                </div>
                <div class="card-body h-100">
                    <?= form_open('blackhole/pengaturan-aplikasi/simpan', 'id="siteForm" method="post"');?>
                    <input type="hidden" name="site_id" value="<?= $setting['site_id']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_name">Judul Aplikasi *</label>
                                <input type="text" id="site_name" name="site_name" class="form-control" placeholder="Judul Aplikasi" value="<?= $setting['site_name']; ?>" required="required">
                                <small id="error_site_name" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_name_alt">Judul Aplikasi (alt) *</label>
                                <input type="text" id="site_name_alt" name="site_name_alt" class="form-control" placeholder="Judul Aplikasi (alt)" value="<?= $setting['site_name_alt']; ?>" required="required">
                                <small id="error_site_name_alt" class="text-danger error_field"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="site_description">Deskripsi Aplikasi</label>
                                <textarea id="site_description" name="site_description" class="form-control" placeholder="Deskripsi Aplikasi" rows="5"><?= $setting['site_description']; ?></textarea>
                                <small id="error_site_description" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label for="site_keywords">Kata kunci</label>
                                <input type="text" id="site_keywords" name="site_keywords" class="form-control" placeholder="Kata kuncil" value="<?= $setting['site_keywords']; ?>">
                                <small id="error_site_keywords" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_author">Author</label>
                                <input type="text" id="site_author" name="site_author" class="form-control" placeholder="Author" value="<?= $setting['site_author']; ?>">
                                <small id="error_site_author" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_logo">Logo Aplikasi</label>
                                <div class="input-group">
                                    <input type="text" id="site_logo" name="site_logo" class="form-control" placeholder="Logo Path" value="<?= $setting['site_logo']; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="browseIconBtn" type="button">Cari</button>
                                    </div>
                                </div>
                                <small id="error_site_logo" class="text-danger error_field"></small>
                            </div>
                            <img src="<?= base_url('uploads/sites/'.$setting['site_logo']); ?>" id="siteLogoPreview" class="img-fluid img-thumbnail w-25" alt="Site Logo">
                        </div>
                    </div>
                    <hr>
                    <h6 class="font-weight-bold">Informasi Administrasi</h6>
                    <div class="row mt-3">
                        <?php $info_adm = json_decode($setting['info_adm'], true); ?>
                        <div class="col-lg-4 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="no_surat_dinas">Tautan No Surat Dinas</label>
                                <input type="url" id="no_surat_dinas" name="no_surat_dinas" class="form-control" placeholder="Tautan Surat Dinas" value="<?= $info_adm['no_surat_dinas'] ?? null; ?>">
                                <small id="error_no_surat_dinas" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="no_sk_kpa">Tautan No SK KPA</label>
                                <input type="url" id="no_sk_kpa" name="no_sk_kpa" class="form-control" placeholder="Tautan SK KPA" value="<?= $info_adm['no_sk_kpa'] ?? null; ?>">
                                <small id="error_no_sk_kpa" class="text-danger error_field"></small>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="monitoring_kegiatan">Monitoring Kegiatan</label>
                                <input type="url" id="monitoring_kegiatan" name="monitoring_kegiatan" class="form-control" placeholder="Tautan Monitoring Kegiatan" value="<?= $info_adm['monitoring_kegiatan'] ?? null; ?>">
                                <small id="error_monitoring_kegiatan" class="text-danger error_field"></small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="font-weight-bold">Pedoman Administrasi Keuangan</h6>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="laporan_keuangan">Laporan Keuangan</label>
                                <div class="input-group">
                                    <input type="text" id="laporan_keuangan" name="laporan_keuangan" class="form-control" placeholder="File Path" value="<?= $info_adm['laporan_keuangan'] ?? null; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="lapkeuBrowseBtn" type="button">Cari</button>
                                    </div>
                                </div>
                                <small id="error_laporan_keuangan" class="text-danger error_field"></small>
                            </div>
                            <?php if(!empty($info_adm['laporan_keuangan'])):?>
                                <iframe id="laporan_keuangan_preview" src="<?= base_url('uploads/sites/'.$info_adm['laporan_keuangan']); ?>" frameborder="0" style="height:300px;max-height:300px" style="height:300px;max-height:300px" class="w-100 mt-3"></iframe>
                            <?php else: ?>
                                <iframe id="laporan_keuangan_preview" src="" frameborder="0" style="height:300px;max-height:300px" class="d-none w-100 mt-3"></iframe>
                            <?php endif; ?>
                        </div>
                        <?php $ped_adm = json_decode($setting['pedoman_adm_keuangan'], true); ?>
                        <div class="col-lg-3 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="file_pok">Petunjuk Operasional Kegiatan</label>
                                <div class="input-group">
                                    <input type="text" id="file_pok" name="file_pok" class="form-control" placeholder="File Path" value="<?= $ped_adm['file_pok'] ?? null; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="filePOKBtn" type="button">Cari</button>
                                    </div>
                                </div>
                                <small id="error_file_pok" class="text-danger error_field"></small>
                            </div>
                            <?php if(!empty($ped_adm['file_pok'])):?>
                                <iframe id="file_pok_preview" src="<?= base_url('uploads/sites/'.$ped_adm['file_pok']); ?>" frameborder="0" style="height:300px;max-height:300px" class="w-100 mt-3"></iframe>
                            <?php else: ?>
                                <iframe id="file_pok_preview" src="" frameborder="0" style="height:300px;max-height:300px" class="d-none w-100 mt-3"></iframe>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-3 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="file_pak">Panduan Administrasi Kegiatan</label>
                                <div class="input-group">
                                    <input type="text" id="file_pak" name="file_pak" class="form-control" placeholder="File Path" value="<?= $ped_adm['file_pak'] ?? null; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="filePAKBtn" type="button">Cari</button>
                                    </div>
                                </div>
                                <small id="error_file_pak" class="text-danger error_field"></small>
                            </div>
                            <?php if(!empty($ped_adm['file_pak'])):?>
                                <iframe id="file_pak_preview" src="<?= base_url('uploads/sites/'.$ped_adm['file_pak']); ?>" frameborder="0" style="height:300px;max-height:300px" class="w-100 mt-3"></iframe>
                            <?php else: ?>
                                <iframe id="file_pak_preview" src="" frameborder="0" style="height:300px;max-height:300px" class="d-none w-100 mt-3"></iframe>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-3 col-md-12 mt-lg-0 mt-md-3 px-1">
                            <div class="form-group">
                                <label for="file_peraturan">Peraturan Kepala BPS</label>
                                <div class="input-group">
                                    <input type="text" id="file_peraturan" name="file_peraturan" class="form-control" placeholder="File Path" value="<?= $ped_adm['file_peraturan'] ?? null; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="filePeraturanBtn" type="button">Cari</button>
                                    </div>
                                </div>
                                <small id="error_file_peraturan" class="text-danger error_field"></small>
                            </div>
                            <?php if(!empty($ped_adm['file_peraturan'])):?>
                                <iframe id="file_peraturan_preview" src="<?= base_url('uploads/sites/'.$ped_adm['file_peraturan']); ?>" frameborder="0" style="height:300px;max-height:300px" class="w-100 mt-3"></iframe>
                            <?php else: ?>
                                <iframe id="file_peraturan_preview" src="" frameborder="0" style="height:300px;max-height:300px" class="d-none w-100 mt-3"></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mt-2 text-right">
                        <div class="col-12">
                            <button type="reset" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</button>
                            <button type="submit" id="btnSave" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
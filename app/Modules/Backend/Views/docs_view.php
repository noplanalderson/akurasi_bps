    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
          <div class="card mb-4 border-custom mx-auto">
            <div class="card-header">
              <h6><?= $header; ?></h6>
            </div>
            <div class="card-body h-100">
                <div class="form-group form-inline float-right">
                    <label class="mr-4 mt-1" for="range">Periode SPJ</label>
                    <input type="text" id="range" name="range" aria-label="Periode" placeholder="Periode"
                        class="form-control">
                </div>
                <input type="hidden" name="classification" id="classification" value="<?= $classification; ?>">

                <div class="table-responsive">

                  <table id="tbl_documents" class="table table-striped table-bordered align-items-center mb-0">
                      <thead>
                      <tr class="text-center">
                          <th class="no-sort">No</th>
                          <th>Kategori Layanan</th>
                          <th class="no-sort">Detail Pekerjaan/Kegiatan</th>
                          <th>Tgl. SPJ Administrasi</th>
                          <th>Petugas</th>
                          <th>Tgl. Perubahan</th>
                          <th>Kelengkapan Dokumen</th>
                          <th class="no-sort">Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Modal -->
    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true" data-bs-focus="false">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="documentModalLabel">Unggah Dokumen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body px-5">
            <div id="general_alert"></div>
            <?= form_open('blackhole/dokumen/simpan', 'method="post" class="wizard mt-5" id="formDocument"'); ?>
            <aside class="wizard-content container">
              <div class="wizard-step text-start" data-title="Rincian Dokumen">
                <input type="hidden" name="document_id" id="document_id" value="">
                <small id="error_document_id" class="error_validation text-danger"></small>

                <input type="hidden" name="action" id="action" value="add">
                <input type="hidden" name="status" id="status" value="draft">
                <small id="error_action" class="error_validation text-danger"></small>

                <input type="hidden" name="document_classification" id="document_classification" value="<?= $classification; ?>">
                <small id="error_action" class="error_validation text-danger"></small>
                <div class="form-group">
                    <div class="row">
                      <div class="col-lg-6 col-md-12">
                        <label for="category_id">Kategori Layanan *</label>
                        <select name="category_id" id="category_id" class="form-control select2-search" required>
                        </select>
                        <small id="error_category_id" class="error_validation text-danger"></small>
                      </div>
                      <div class="col-lg-6 col-md-12">
                        <label for="spj_date">Tanggal SPJ *</label>
                        <input type="date" name="spj_date" id="spj_date" class="form-control" required>
                        <small id="error_spj_date" class="error_validation text-danger"></small>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-12">
                        <textarea name="document_details" id="document_details" class="form-control" placeholder="Detail Pekerjaan/Kegiatan" row="8" required></textarea>
                        <small id="error_document_details" class="error_validation text-danger"></small>
                      </div>
                    </div>
                </div>
              </div>
              <div class="wizard-step text-start" data-title="Unggah Berkas">
                <div class="form-group">

                  <div class="row">
                    <?php 
                      $files = [
                        'kak' => 'Kerangka Acuan Kerja (KAK)',
                        'form_permintaan' => 'Form Permintaan',
                        'sk_kpa' => 'Surat Keputusan KPA',
                        'surat_tugas' => 'Surat Tugas',
                        'mon_kegiatan' => 'SPJ Kegiatan',
                        'dok_kegiatan' => 'Dokumen Kegiatan',
                        'adm_kegiatan' => 'Dokumen Keuangan'
                      ]; 
                      $i = 0;
                      foreach ($files as $key => $file) :
                      $i++;
                    ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 <?= ($i > 0 ?  'mt-3' : ''); ?>">
                      <label for="<?= $key; ?>"><?= $file; ?> *</label>
                      <input type="hidden" name="<?= $key ?>_id" id="<?= $key ?>_id" value="" class="form-control mb-1 file-id" placeholder="File UUID" readonly required>
                      <br/>
                      <small id="error_<?= $key; ?>" class="error_validation text-danger mb-2"></small>
                      <!-- <small id="error_action" class="error_validation text-danger mb-2"></small> -->
                      <div class="custom-file">
                        <input name="<?= $key; ?>" id="<?= $key; ?>" type="file" class="custom-file-input picture_upload" accept="application/pdf" required>
                        <label class="custom-file-label" for="<?= $key; ?>">Pilih file PDF...</label>
                      </div>    
                      <br/>
                      <small class="text-danger font-weight-normal">Ukuran Maks. 5 MB/File</small>
                      <small id="error_<?= $key; ?>" class="text-danger error-validation mt-2"></small>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </aside>
            </form>
          </div>
          <div class="modal-footer">
            <div class="align-content-center justify-content-start m-3 d-flex">
                <button type="reset" id="btn_reset" class="btn btn-warning">Reset</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pratinjau Berkas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <div class="modal-body">
            <div class="container-fluid h-100">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

              <iframe src="" class="file-preview mt-3" id="frame-pdf" width="100%" height="800px" frameborder="0"></iframe>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modalFiles" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Daftar Berkas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="table-responsive">
                <table id="tbl_files" class="table table-striped table-bordered align-items-center mb-0">
                  <thead>
                    <tr class="text-center">
                      <th class="no-sort">No</th>
                      <th>Nama Berkas</th>
                      <th>Tanggal Unggah</th>
                      <th>Pengunggah</th>
                      <th class="no-sort">Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="files">
                    <?php
                    $i = 0;
                    foreach ($files as $key => $file) :
                      $i++;
                    ?>
                    <tr>
                      <td class="text-center"><?= $i; ?></td>
                      <td><?= $file; ?></td>
                      <td id="<?= $key ?>_upload_date"></td>
                      <td id="<?= $key ?>_uploader"></td>
                      <td class="text-center">
                        <a href="" id="<?= $key ?>_file_link" class="btn btn-primary btn-sm fs-11" target="_blank" rel="noopener noreferrer nofollow"><i class="fas fa-spin fa-spinner"></i> Memuat...</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
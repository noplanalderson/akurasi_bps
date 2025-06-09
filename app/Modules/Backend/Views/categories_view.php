    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
          <div class="card mb-4 border-custom mx-auto">
            <div class="card-header">
              <h6>Kelola Kategori</h6>
            </div>
            <div class="card-body">
              <table id="tbl_categories" class="table table-striped table-bordered align-items-center mb-0">
                <thead>
                  <tr class="text-center">
                    <th>Kode Kategori</th>
                    <th>Kategori</th>
                    <th class="no-sort">Slug</th>
                    <th class="no-sort">Meta Data</th>
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
      
      <div class="modal fade" id="categoryModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="Category Management" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 id="categoryModalLabel" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
              
              <div id="general_alert"></div>

              <?= form_open('blackhole/kategori/simpan', 'id="categoryForm" method="post"');?>
              
              <input type="hidden" id="category_id" name="category_id" value="">
              <small id="error_category_id" class="text-danger error-validation"></small>
              <input type="hidden" id="action" name="action" value="">
              <small id="error_action" class="text-danger error-validation"></small>

              <div class="form-group">
                <div class="row">
                  <div class="col-12">
                    <label for="category_name">Kategori *</label>
                    <input id="category_name" type="text" class="form-control" name="category_name"  placeholder="Kategori" required="required">
                    <small id="error_category_name" class="text-danger error-validation"></small>
                  </div>
                  <div class="col-12">
                    <label for="category_code">Kode Kategori *</label>
                    <input id="category_code" type="text" class="form-control" name="category_code"  placeholder="Kode Kategori" required="required">
                    <small id="error_category_code" class="text-danger error-validation"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
              <button id="submitCategory" class="btn btn-success" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
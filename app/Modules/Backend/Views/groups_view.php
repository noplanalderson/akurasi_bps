    <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row position-relative">
          <div class="img-container">

            <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
          </div>
          <div class="col-12">
            <div class="card mb-4 border-custom mx-auto">
              <div class="card-header">
                <h6>Grup Pengguna</h6>
              </div>
              <div class="card-body h-100">
                <table id="tbl_group" class="table table-striped table-bordered align-items-center mb-0">
                  <thead>
                    <tr class="text-center">
                      <th>Nama Grup</th>
                      <th class="wrapok">Hak Akses</th>
                      <th>Mode Akses</th>
                      <th>Indeks</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      <div class="modal fade" id="groupModal" role="dialog" data-backdrop="static" data-keyboard="false"  aria-labelledby="User Group Management" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">

              <?= form_open('blackhole/grup/simpan', 'id="groupForm" method="post"');?>
              
              <input type="hidden" id="group_id" name="group_id" value="">
              <input type="hidden" id="action" name="action" value="">

              <div class="form-group">
                <label for="group_name">Nama Grup *</label>
                <input type="text" id="group_name" name="group_name" class="form-control" placeholder="Nama Grup" required="required">
                <small id="error_group_name" class="text-danger error_field"></small>
              </div>

              <div class="form-group">
                <label for="mode">Mode Akses *</label>
                <select id="mode" class="form-control" name="mode" required="required">
                  <option value="">Pilih Mode</option>
                  <option value="r">Read Only</option>
                  <option value="rw">Read Write</option>
                </select>
                <small id="error_mode" class="text-danger error_field"></small>
              </div>
              <div class="form-group">
                <label for="group_feature">Hak Akses *</label>
                <select id="group_feature" name="group_feature[]" class="form-control text-dark select2-search" required="required" multiple="multiple">
                
                </select>
                <small id="error_group_feature" class="text-danger error_field"></small>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-undo"></i> Batal</button>
              <button id="submit" class="btn btn-success" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
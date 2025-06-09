    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
          <div class="card mb-4 border-custom mx-auto">
            <div class="card-header">
              <h6>Kelola Akun</h6>
            </div>
            <div class="card-body h-100">
              <table id="tbl_accounts" class="table table-striped table-bordered align-items-center mb-0">
                <thead>
                  <tr class="text-center">
                    <th>Akun</th>
                    <th>Email</th>
                    <th>Nama Pegawai</th>
                    <th>Status Akun</th>
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

      <div class="modal fade" id="userAccountModal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="Account Management" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
              
              <div id="general_alert"></div>

              <?= form_open('blackhole/akun/simpan', 'id="accountForm" method="post"');?>
              
              <input type="hidden" id="user_id" name="user_id" value="">
              <small id="error_user_id" class="text-danger error-validation"></small>
              <input type="hidden" id="action" name="action" value="">
              <small id="error_action" class="text-danger error-validation"></small>

              <div class="form-group">
                <div class="row">
                  <div class="col-12">
                    <label for="user_realname">Nama Pegawai *</label>
                    <input id="user_realname" type="text" class="form-control" name="user_realname"  placeholder="Nama" required="required">
                    <small id="error_user_realname" class="text-danger error-validation"></small>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="user_name">Username *</label>
                        <input id="user_name" type="text" class="form-control" name="user_name" placeholder="Username (ex: user_name)" required="required">
                        <small id="error_user_name" class="text-danger error-validation"></small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="user_email">Email</label>
                        <input id="user_email" type="email" class="form-control" name="user_email"  placeholder="you@somewhere.com">
                        <small id="error_user_email" class="text-danger error-validation"></small>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <label for="user_password my-2">Kata Sandi *</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" aria-label="Password" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary show-btn-password" type="button" id="button-addon2"><i class="fas fa-eye password"></i></button>
                        </div>
                    </div>
                    <small id="error_user_password" class="text-danger error-validation">Password harus mengandung alfanumerik and simbol minimal 8 karakter.</small>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <label for="repeat_password my-2">Ulangi Kata Sandi *</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="repeat_password" id="repeat_password" placeholder="Repeat Password" aria-label="Repeat Password" aria-describedby="button-addon3">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary show-btn-repeat" type="button" id="button-addon3"><i class="fas fa-eye repeat"></i></button>
                        </div>
                    </div>
                    <small id="error_repeat_password" class="text-danger error-validation"></small>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="group_id">Grup Pengguna *</label>
                    <select name="group_id" id="group_id" class="form-control" required>
                      <option value="">Pilih grup</option>
                      <?php foreach($usergroups as $group) : ?>
                      <option value="<?= $group['group_id']; ?>"><?= $group['group_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <small id="error_group_id" class="text-danger error-validation"></small>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="is_active">Status Akun *</label>
                    <select name="is_active" id="is_active" class="form-control">
                      <option value="0">NONAKTIF</option>
                      <option value="1">AKTIF</option>
                    </select>
                    <small id="error_is_active" class="text-danger error-validation"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
              <button id="submitAccount" class="btn btn-success" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
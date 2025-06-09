            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span><?= $setting['org_name'] ?> &copy; <?= date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Perhatian!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Anda yakin ingin keluar dari aplikasi?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="<?= base_url('blackhole/logout'); ?>">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Modal-->
    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengaturan Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= 
                        form_open('blackhole/settings', 'method="post" id="formAccount"');
                    ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <label for="user_name">Username</label>
                                <input type="text" name="user_name" class="form-control" value="<?= $user['user_name']; ?>" disabled>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-lg-0 mt-sm-2">
                                <label for="user_email">Email *</label>
                                <input type="email" name="user_email" class="form-control" value="<?= $user['user_email']; ?>" placeholder="Email" required>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-lg-2 mt-sm-2">
                                <label for="user_password">Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="user_password" id="user_password_acc" placeholder="Password" aria-label="Password" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary show-btn-password-acc" type="button" id="button-addon2-acc"><i class="fas fa-eye password-acc"></i></button>
                                    </div>
                                </div>
                                <small class="text-danger">Password must contains alphanumerics and at least one symbol with 8-32 characters.</small>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-lg-2 mt-sm-2">
                                <label for="repeat_password">Ulangi Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="repeat_password" id="repeat_password_acc" placeholder="Repeat Password" aria-label="Repeat Password" aria-describedby="button-addon3">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary show-btn-repeat-acc" type="button" id="button-addon3-acc"><i class="fas fa-eye repeat-acc"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <label for="user_picture">User Picture</label>
                                <input type="file" name="user_picture" id="user_picture" class="form-control">
                                <small></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSave"><i class="fas fa-save"></i> Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
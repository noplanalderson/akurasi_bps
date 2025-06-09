    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
            <div class="card mb-4 border-custom mx-auto">
                <div class="card-header">
                    <h6>Pengaturan Organisasi</h6>
                </div>
                <div class="card-body h-100">                
                    <main class="mt-3">
                        <div id="general_alert"></div>
                        <?php echo form_open(base_url('blackhole/pengaturan-organisasi/simpan'), 'method="post" class="wizard" id="wizard"'); ?>
                        <aside class="wizard-content container">
                            <div class="wizard-step text-start" data-title="Profil Organisasi">
                                <input type="hidden" name="org_id" id="org_id" value="<?php echo $setting['org_id']; ?>">
                                <small id="error_org_id" class="error_validation text-danger"></small>
                                    <div class="form-group">
                                        <label for="org_name">Nama Organisasi *</label>
                                        <input type="text" name="org_name"  class="form-control required" placeholder="Judul Situs" value="<?php echo $setting['org_name']; ?>" required>
                                        <small id="error_org_name" class="error_validation text-danger"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="org_slogan">Slogan</label>
                                        <input type="text" name="org_slogan" class="form-control " id="org_slogan" placeholder="Slogan" value="<?php echo $setting['org_slogan']; ?>">
                                        <small id="error_org_slogan" class="error_validation text-danger"></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="org_profile">Profil</label>
                                        <textarea name="org_profile" id="org_profile" class="form-control"  placeholder="Organization Profile"><?php echo $setting['org_profile']; ?></textarea>
                                        <small id="error_org_profile" class="error_validation text-danger"></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="org_vision">Visi</label>
                                        <textarea name="org_vision" id="org_vision" class="form-control"  placeholder="Vision"><?php echo $setting['org_vision']; ?></textarea>
                                        
                                        <small id="error_vision" class="error_validation text-danger"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="org_missions">Misi</label>
                                        <textarea name="org_missions" id="org_missions" class="form-control"  placeholder="Missions"><?php echo $setting['org_missions']; ?></textarea>
                                        <small id="error_missions" class="error_validation text-danger"></small>
                                    </div>
                                </div>
                                <div class="wizard-step text-start" data-title="Kontak dan Sosial Media">
                                    <div class="form-group">
                                        <label for="org_address">Alamat Organisasi</label>
                                        <textarea name="org_address" id="org_address" class="form-control" placeholder="Alamat Organisasi"><?php echo $setting['org_address']; ?></textarea>
                                        <small id="error_org_address" class="error_validation text-danger"></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">

                                                <label for="org_phone">No. Telepon *</label>
                                                <input type="text" name="org_phone" id="org_phone" class="form-control required" value="<?php echo $setting['org_phone']; ?>" placeholder="+62xxx" required>
                                                <small id="error_org_phone" class="error_validation text-danger"></small>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                        
                                                <label for="org_email">Email *</label>
                                                <input type="text" name="org_email" class="form-control required " id="org_email" placeholder="Email" value="<?php echo $social_media['email'] ?? null; ?>" required>
                                                <small id="error_org_email" class="error_validation text-danger"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">

                                                <label for="instagram">Instagram</label>
                                                <input type="url" name="social_media[instagram]" id="instagram" class="form-control" value="<?php echo $social_media['instagram'] ?? null; ?>" placeholder="https://">
                                                <small id="error_social_media_instagram" class="error_validation text-danger"></small>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                        
                                                <label for="facebook">Facebook</label>
                                                <input type="url" name="social_media[facebook]" class="form-control " id="facebook" placeholder="https://" value="<?php echo $social_media['facebook'] ?? null; ?>">
                                                <small id="error_social_media_facebook" class="error_validation text-danger"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">

                                                <label for="linkedin">Linkedin</label>
                                                <input type="url" name="social_media[linkedin]" id="linkedin" class="form-control" value="<?php echo $social_media['linkedin'] ?? null; ?>" placeholder="https://">
                                                <small id="error_social_media_linkedin" class="error_validation text-danger"></small>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                        
                                                <label for="twitter">Twitter</label>
                                                <input type="url" name="social_media[twitter]" class="form-control " id="twitter" placeholder="https://" value="<?php echo $social_media['twitter'] ?? null; ?>">
                                                <small id="error_social_media_twitter" class="error_validation text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="org_map">Google Map</label>
                                                <input type="text" name="org_map" id="org_map" class="form-control" value="<?php echo $setting['org_map'] ?? null; ?>" placeholder="https://">
                                                <small id="error_org_map" class="error_validation text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </form>

                        <div class="align-content-center justify-content-start m-3 d-flex">
                            <button type="reset" id="btn_reset" class="btn btn-warning">Reset</button>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
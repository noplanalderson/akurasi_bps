<body>
<div id="particles-js"></div>
    <div class="container login-container">
        <div class="row no-gutters">
            <div class="col-md-6 d-none d-md-block login-image"></div>
            <div class="col-md-6">
                <div class="login-form">
                    <img src="<?= site_url('uploads/sites/'.$setting['site_logo']) ?>" alt="Logo BPS" class="logo float-left mr-4">
                    <h4><strong><?= $setting['site_name_alt']; ?></strong><br/><?= $setting['org_name']; ?></h4>
                    <div class="clearfix"></div>
                    <h5 class="mt-4 mb-3">Sign In to your Account</h5>
                    <p class="mb-4 text-muted">Welcome back! please enter your detail</p>
                    <div id="response"></div>
                    <form id="loginForm" method="post" action="<?= site_url('in') ?>">
                    <?= csrf_field('csrf_token'); ?>
                        <div class="form-group">
                            <label for="user_name">Username</label>
                            <input type="text" class="form-control" id="user_name" placeholder="Username" required>
                            <small id="user_name_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" aria-label="Password" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary show-btn-password" type="button" id="button-addon2"><i class="fas fa-eye password"></i></button>
                                </div>
                            </div>
                            <small id="user_password_error" class="text-danger"></small>
                        </div>
                        <!-- <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div> -->
                        <button type="submit" id="btn_submit" class="btn btn-primary btn-block"><i class="fas fa-door-open"></i> Masuk</button>
                    </form>
                </div>
            </div>
            <div class="col-12 my-3 pb-3 text-center">
                <small class="text-muted">Copyright &copy; <?= date('Y'); ?> - <?= $setting['org_name']; ?></small>
            </div>
        </div>
    </div>
</body>
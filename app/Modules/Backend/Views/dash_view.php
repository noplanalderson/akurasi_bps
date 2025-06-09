    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
          <div class="card mb-4 border-custom mx-auto">
            <div class="card-header">
              <h6>Dashboard</h6>
            </div>
            <div class="card-body">
                        
                <div id="stats" class="row px-0">
                    
                    <div class="col-xl-4 col-md-12">
                        <div class="bg-white  p-4 rounded border-left-primary shadow py-2">
                            <div id="totalDocument" class="">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mt-xl-0 mt-md-3 mt-sm-3">
                        <div class="bg-white p-4 rounded  border-left-info shadow py-2">
                            <div id="totalAccount" class="">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mt-xl-0 mt-md-3 mt-sm-3">
                        <div class="bg-white p-4 rounded  border-left-danger shadow py-2">
                            <div id="totalCategories" class="">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="bg-white shadow h-100 p-3 rounded">
                                    <h6 class="card-header mb-3">Selamat Datang!</h6>
                                    <div class="d-flex align-items-center px-2 mt-4">
                                        <img src="<?= UPLOAD_PATH . 'pp/' . session()->get('uid') . '/' . $user['user_picture']; ?>" alt="<?= $user['user_realname']; ?>" class="border rounded-circle border-primary" width="100" height="100">
                                        <br>
                                        <div class="ml-3">
                                            <h5 class="mb-1"><?= esc($user['user_realname']) ?></h5>
                                            <p class="mb-0 text-muted"><?= esc($user['user_email']) ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-3 px-2">
                                        <table class="table-borderless w-100">
                                            <tr>
                                                <td class="font-weight-bold" width="30%">Login Terakhir</td>
                                                <td id="lastLogin"></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">User Agent</td>
                                                <td id="userAgent"></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">IP Terakhir</td>
                                                <td id="lastIp"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-lg-0 mt-md-3">
                                
                                <div class="bg-white shadow h-100 p-3 rounded">
                                    <h6 class="card-header">Klasifikasi</h6>
                                    <canvas class="my-5" id="docClassificationChart"></canvas>
                                </div>
                                
                            </div>
                            <div class="col-12 mt-3">
                                <div class="bg-white shadow h-100 p-3 rounded mt-lg-0 mt-md-3 mt-sm-3">
                                    <h6 class="card-header">Kategori</h6>
                                    <canvas class="my-5" id="docCategoriesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
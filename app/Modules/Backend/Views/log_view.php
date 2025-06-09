    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row position-relative">
            <div class="img-container">

                <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card mb-4 border-custom mx-auto">
                    <div class="card-header">
                        <h6 class="float-left">Log Aplikasi</h6>
                    </div>
                    <div class="card-body h-100">
                        
                        <div class="form-group form-inline float-right">
                            <label class="mr-4 mt-1" for="range">Periode</label>
                            <input type="text" id="range" name="range" aria-label="Periode" placeholder="Periode"
                                class="form-control">
                        </div>
                        <div class="table-responsive">

                            <table id="tbl_logs" class="table table-striped table-bordered table-sm ft-align-items-center">
                                <thead>
                                    <tr class="text-center">
                                        <th>Waktu</th>
                                        <th class="no-sort">Jenis Log</th>
                                        <th class="no-sort">Log</th>
                                        <th class="no-sort">Level</th>
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
    </div>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between bg-white p-3 rounded border-left-success">
            <h1 class="h3 mb-0">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div id="stats" class="row">
            <div class="col-12">

                <div class="row">
                    
                    <div class="col-xl-4 col-md-12">
                        <div class="card border-left-primary shadow py-2">
                            <div id="totalDocument" class="card-body">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12">
                        <div class="card border-left-info shadow py-2">
                            <div id="totalAccount" class="card-body">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12">
                        <div class="card border-left-danger shadow py-2">
                            <div id="totalVisitor" class="card-body">
                                <i class="fas fa-spin fa-spinner fa-3x"></i>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="card h-100">
                    <div class="card-header">Visitor Browser</div>
                    <div class="card-body d-flex align-items-center justify-content-center h-100">
                        <canvas class="my-auto" id="userAgentChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header">Visitor Country</div>
                    <div class="card-body">

                        <div id="visitorCountryMap" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <table id="tbl_top_document" class="table table-stripped table-sm fs-11">
                            <thead>
                                <tr>
                                    <th>Dokumen</th>
                                    <th>Viewers</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row position-relative">
        <div class="img-container">

          <img class="img-header" src="<?= site_url('statics/img/backend/edoc.jpg') ?>">
        </div>
        <div class="col-12">
          <div class="card mb-4 border-custom mx-auto">
            <div class="card-header">
              <h6>Informasi dan Pedoman</h6>
            </div>
            <div class="card-body">
                <?php
                    $infoAdm = json_decode($setting['info_adm'], true);
                    $pedoman = json_decode($setting['pedoman_adm_keuangan'], true);
                ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th>Rincian</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-section">
                        <td colspan="4">Informasi Administrasi</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Nomor Surat Dinas</td>
                        <td><a href="<?= $infoAdm['no_surat_dinas']; ?>" target="_blank"><?= $infoAdm['no_surat_dinas']; ?></a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Nomor SK KPA</td>
                        <td><a href="<?= $infoAdm['no_sk_kpa']; ?>" target="_blank"><?= $infoAdm['no_sk_kpa']; ?></a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Monitoring Kegiatan</td>
                        <td><a href="<?= $infoAdm['monitoring_kegiatan']; ?>" target="_blank"><?= $infoAdm['monitoring_kegiatan']; ?></a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Laporan Keuangan</td>
                        <td>
                            <a class="btn btn-success" href="<?= site_url('uploads/sites/'.$infoAdm['laporan_keuangan']); ?>" target="_blank"><i class="fas fa-file-download"></i> Unduh</a>
                        </td>
                    </tr>

                    <tr class="bg-subsection">
                        <td colspan="4">Pedoman Administrasi Keuangan</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Petunjuk Operasional Kegiatan (POK)</td>
                        <td>
                            <a class="btn btn-success" href="<?= site_url('uploads/sites/'.$pedoman['file_pok']); ?>" target="_blank"><i class="fas fa-file-download"></i> Unduh</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Panduan Administrasi Kegiatan (PAK)</td>
                        <td>
                            <a class="btn btn-success" href="<?= site_url('uploads/sites/'.$pedoman['file_pak']); ?>" target="_blank"><i class="fas fa-file-download"></i> Unduh</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Peraturan Kepala BPS</td>
                        <td>
                            <a class="btn btn-success" href="<?= site_url('uploads/sites/'.$pedoman['file_peraturan']); ?>" target="_blank"><i class="fas fa-file-download"></i> Unduh</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// HTTP language settings
return [
    // Permintaan CURL
    'missingCurl' => 'CURL harus diaktifkan untuk menggunakan kelas CURLRequest.',
    'invalidSSLKey' => 'Tidak dapat menyetel Kunci SSL. "{0}" bukan berkas yang valid.',
    'sslCertNotFound' => 'Sertifikat SSL tidak ditemukan di: "{0}"',
    'curlError' => '{0} : {1}',

    // Permintaan Masuk
    'invalidNegotiationType' => '"{0}" bukan jenis negosiasi yang valid. Harus salah satu dari: media, rangkaian karakter, pengkodean, bahasa.',
    'invalidJSON' => 'Gagal mengurai string JSON. Kesalahan: {0}',
    'unsupportedJSONFormat' => 'Format JSON yang disediakan tidak didukung.',

    // Pesan
    'invalidHTTPProtocol' => 'Versi Protokol HTTP tidak valid: {0}',

    // Negosiasi
    'emptySupportedNegotiations' => 'Anda harus menyediakan serangkaian nilai yang didukung untuk semua Negosiasi.',

    // Respon Pengalihan
    'invalidRoute' => 'Rute untuk "{0}" tidak dapat ditemukan.',

    // UnduhRespon
    'cannotSetBinary' => 'Saat menyetel jalur file tidak dapat menyetel biner.',
    'cannotSetFilepath' => 'Ketika pengaturan biner tidak dapat mengatur jalur file: "{0}"',
    'notFoundDownloadSource' => 'Sumber badan unduhan tidak ditemukan.',
    'cannotSetCache' => 'Tidak mendukung caching untuk pengunduhan.',
    'cannotSetStatusCode' => 'Tidak mendukung perubahan kode status untuk pengunduhan. kode: {0}, alasan: {1}',

    // Tanggapan
    'missingResponseStatus' => 'Respon HTTP tidak memiliki kode status',
    'invalidStatusCode' => '{0} bukan kode status pengembalian HTTP yang valid',
    'unknownStatusCode' => 'Kode status HTTP tidak diketahui diberikan tanpa pesan: {0}',

    // URI
    'cannotParseURI' => 'Tidak dapat menguraikan URI: "{0}"',
    'segmentOutOfRange' => 'Segmen URI Permintaan di luar jangkauan: "{0}"',
    'invalidPort' => 'Port harus antara 0 dan 65535. Diketahui: {0}',
    'malformedQueryString' => 'String kueri tidak boleh menyertakan fragmen URI.',

    // Halaman tidak ditemukan
    'pageNotFound' => 'Halaman Tidak Ditemukan',
    'emptyController' => 'Tidak ada Controller yang ditentukan.',
    'controllerNotFound' => 'Controller atau method tidak ditemukan: {0}::{1}',
    'methodNotFound' => 'Method controller tidak ditemukan: "{0}"',
    'localeNotSupported' => 'Lokal tidak didukung: {0}',

    // CSRF
    // @tidak digunakan lagi menggunakan 'Security.disallowedAction'
    'disallowedAction' => 'Tindakan yang Anda minta tidak diperbolehkan.',

    // File yang diunggah dipindahkan
    'alreadyMoved' => 'File yang diunggah telah dipindahkan.',
    'invalidFile' => 'File asli bukan file yang valid.',
    'moveFailed' => 'Tidak dapat memindahkan berkas "{0}" ke "{1}". Alasan: {2}',

    'uploadErrOk' => 'File berhasil diunggah.',
    'uploadErrIniSize' => 'File "%s" melebihi arahan upload_max_filesize ini.',
    'uploadErrFormSize' => 'File "%s" melebihi batas unggahan yang ditentukan dalam form Anda.',
    'uploadErrPartial' => 'File "%s" hanya diunggah sebagian.',
    'uploadErrNoFile' => 'Tidak ada file yang diunggah.',
    'uploadErrCantWrite' => 'File "%s" tidak dapat ditulis ke disk.',
    'uploadErrNoTmpDir' => 'File tidak dapat diunggah: direktori sementara tidak ada.',
    'uploadErrExtension' => 'Unggahan berkas dihentikan oleh ekstensi PHP.',
    'uploadErrUnknown' => 'File "%s" tidak dapat diunggah karena kesalahan yang tidak diketahui.',

    // Pengaturan Situs yang Sama
    // @tidak digunakan lagi
    'invalidSameSiteSetting' => 'Pengaturan SameSite harus None, Lax, Strict, atau string kosong. Diberikan: {0}',
];

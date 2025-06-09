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

// Migration language settings
return [
    // Migration Runner
    'missingTable' => 'Tabel migrasi harus disetel.',
    'disabled' => 'Migrasi telah dimuat tetapi dinonaktifkan atau pengaturannya salah.',
    'notFound' => 'File migrasi tidak ditemukan: ',
    'batchNotFound' => 'Kumpulan target tidak ditemukan:',
    'empty' => 'Tidak ditemukan file Migrasi',
    'gap' => 'Ada celah dalam urutan migrasi di dekat nomor versi: ',
    'classNotFound' => 'Kelas migrasi "%s" tidak dapat ditemukan.',
    'missingMethod' => 'Kelas migrasi tidak memiliki metode "%s".',

    // Perintah Migrasi
    'migHelpLatest' => "\t\tMemigrasikan database ke migrasi terbaru yang tersedia.",
    'migHelpCurrent' => "\t\tMemigrasi database ke versi yang ditetapkan sebagai 'saat ini' dalam konfigurasi.",
    'migHelpVersion' => "\tMemigrasikan basis data ke versi {v}.",
    'migHelpRollback' => "\tMenjalankan semua migrasi 'turun' ke versi 0.",
    'migHelpRefresh' => "\t\tUninstall dan jalankan kembali semua migrasi untuk menyegarkan database.",
    'migHelpSeed' => "\tJalankan seeder bernama [nama].",
    'migCreate' => "\tMembuat migrasi baru bernama [nama]",
    'nameMigration' => 'Beri nama file migrasi',
    'migNumberError' => 'Nomor migrasi harus tiga digit, dan tidak boleh ada celah dalam urutannya.',
    'rollBackConfirm' => 'Apakah Anda yakin ingin melakukan rollback?',
    'refreshConfirm' => 'Apakah Anda yakin ingin menyegarkan?',

    'latest' => 'Menjalankan semua migrasi baru...',
    'generalFault' => 'Migrasi gagal!',
    'migrated' => 'Migrasi selesai.',
    'migInvalidVersion' => 'Nomor versi yang diberikan tidak valid.',
    'toVersionPH' => 'Bermigrasi ke versi %s...',
    'toVersion' => 'Bermigrasi ke versi saat ini...',
    'rollingBack' => 'Mengembalikan migrasi ke batch: ',
    'noneFound' => 'Tidak ada migrasi yang ditemukan.',
    'migSeeder' => 'Nama seeder',
    'migMissingSeeder' => 'Anda harus memberikan nama seeder.',
    'nameSeeder' => 'Beri nama file seeder',
    'removed' => 'Memutar kembali: ',
    'added' => 'Berjalan: ',

    // Migrate Status
    'namespace' => 'Namespace',
    'filename'  => 'Filename',
    'version'   => 'Version',
    'group'     => 'Group',
    'on'        => 'Migrated On: ',
    'batch'     => 'Batch',
];

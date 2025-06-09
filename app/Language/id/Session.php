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

// Session language settings
return [
    'missingDatabaseTable' => '"sessionSavePath" harus memiliki nama tabel agar Database Session Handler dapat berfungsi.',
    'invalidSavePath' => 'Sesi: Jalur penyimpanan "{0}" yang dikonfigurasi bukan direktori, tidak ada atau tidak dapat dibuat.',
    'writeProtectedSavePath' => 'Sesi: Jalur penyimpanan "{0}" yang dikonfigurasi tidak dapat ditulis oleh proses PHP.',
    'emptySavePath' => 'Sesi: Tidak ada jalur penyimpanan yang dikonfigurasi.',
    'invalidSavePathFormat' => 'Sesi: Format jalur penyimpanan Redis tidak valid: "{0}"',

    // @tidak digunakan lagi
    'invalidSameSiteSetting' => 'Sesi: Pengaturan SameSite harus None, Lax, Strict, atau string kosong. Diberikan: "{0}"',
];

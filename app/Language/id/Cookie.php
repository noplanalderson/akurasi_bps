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

// Cookie language settings
return [
    'invalidExpiresTime' => 'Jenis "{0}" untuk atribut "Expires" tidak valid. Diharapkan: string, integer, objek DateTimeInterface.',
    'invalidExpiresValue' => 'Waktu habis masa berlaku cookie tidak valid.',
    'invalidCookieName' => 'Nama cookie "{0}" berisi karakter yang tidak valid.',
    'emptyCookieName' => 'Nama cookie tidak boleh kosong.',
    'invalidSecurePrefix' => 'Penggunaan awalan "__Secure-" memerlukan pengaturan atribut "Secure".',
    'invalidHostPrefix' => 'Menggunakan awalan "__Host-" harus disetel dengan flag "Secure", tidak boleh memiliki atribut "Domain", dan "Path" disetel ke "/".',
    'invalidSameSite' => 'Nilai SameSite harus None, Lax, Strict atau string kosong, {0} diberikan.',
    'invalidSameSiteNone' => 'Penggunaan atribut "SameSite=None" memerlukan pengaturan atribut "Secure".',
    'invalidCookieInstance' => '"{0}" kelas array cookie diharapkan menjadi instance "{1}" tetapi mendapatkan "{2}" pada indeks {3}.',
    'unknownCookieInstance' => 'Objek cookie dengan nama "{0}" dan awalan "{1}" tidak ditemukan dalam koleksi.',
];

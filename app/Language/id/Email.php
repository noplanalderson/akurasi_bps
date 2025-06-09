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

// Email language settings
return [
    'mustBeArray' => 'Metode validasi email harus melewati array.',
    'invalidAddress' => 'Alamat email tidak valid: "{0}"',
    'attachmentMissing' => 'Tidak dapat menemukan lampiran email berikut: "{0}"',
    'attachmentUnreadable' => 'Tidak dapat membuka lampiran ini: "{0}"',
    'noFrom' => 'Tidak dapat mengirim email tanpa header "Dari".',
    'noRecipients' => 'Anda harus menyertakan penerima: Kepada, Cc, atau Bcc',
    'sendFailurePHPMail' => 'Tidak dapat mengirim email menggunakan PHP mail(). Server Anda mungkin tidak dikonfigurasi untuk mengirim email menggunakan metode ini.',
    'sendFailureSendmail' => 'Tidak dapat mengirim email menggunakan Sendmail. Server Anda mungkin tidak dikonfigurasi untuk mengirim email menggunakan metode ini.',
    'sendFailureSmtp' => 'Tidak dapat mengirim email menggunakan SMTP. Server Anda mungkin tidak dikonfigurasi untuk mengirim email menggunakan metode ini.',
    'sent' => 'Pesan Anda telah berhasil dikirim menggunakan protokol berikut: {0}',
    'noSocket' => 'Tidak dapat membuka soket ke Sendmail. Silakan periksa pengaturan.',
    'noHostname' => 'Anda tidak menentukan nama host SMTP.',
    'SMTPError' => 'Terjadi kesalahan SMTP berikut: {0}',
    'noSMTPAuth' => 'Kesalahan: Anda harus menetapkan nama pengguna dan kata sandi SMTP.',
    'failedSMTPLogin' => 'Gagal mengirim perintah AUTH LOGIN. Kesalahan: {0}',
    'SMTPAuthUsername' => 'Gagal mengautentikasi nama pengguna. Kesalahan: {0}',
    'SMTPAuthPassword' => 'Gagal mengautentikasi kata sandi. Kesalahan: {0}',
    'SMTPDataFailure' => 'Tidak dapat mengirim data: {0}',
    'exitStatus' => 'Kode status keluar: {0}',
];

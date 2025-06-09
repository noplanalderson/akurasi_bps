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

// Validation language settings
return [
    // Core Messages
    'noRuleSets' => 'Tidak ada kumpulan aturan yang ditentukan dalam konfigurasi Validasi.',
    'ruleNotFound' => '"{0}" bukan aturan yang valid.',
    'groupNotFound' => '"{0}" bukan grup aturan validasi.',
    'groupNotArray' => '"{0}" grup aturan harus berupa array.',
    'invalidTemplate' => '"{0}" bukan templat Validasi yang valid.',

    // Pesan Aturan
    'alpha' => 'Bagian {field} hanya boleh berisi karakter alfabet.',
    'alpha_dash' => 'Bagian {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.',
    'alpha_numeric' => 'Bagian {field} hanya boleh berisi karakter alfanumerik.',
    'alpha_numeric_punct' => 'Bagian {field} hanya boleh berisi karakter alfanumerik, spasi, dan ~ ! # $ % & * - _ + = | : . karakter.',
    'alpha_numeric_space' => 'Bagian {field} hanya boleh berisi karakter alfanumerik dan spasi.',
    'alpha_space' => 'Bagian {field} hanya boleh berisi karakter alfabet dan spasi.',
    'decimal' => 'Bagian {field} harus berisi angka desimal.',
    'differs' => 'Kolom {field} harus berbeda dengan kolom {param}.',
    'equals' => 'Bidang {field} harus sama persis: {param}.',
    'exact_length' => 'Panjang kolom {field} harus tepat {param} karakter.',
    'field_exists' => 'Bidang {field} harus ada.',
    'greater_than' => 'Bidang {field} harus berisi angka yang lebih besar dari {param}.',
    'greater_than_equal_to' => 'Bagian {field} harus berisi angka yang lebih besar atau sama dengan {param}.',
    'hex' => 'Bagian {field} hanya boleh berisi karakter heksadesimal.',
    'in_list' => 'Kolom {field} harus berupa salah satu dari: {param}.',
    'integer' => 'Bidang {field} harus berisi bilangan bulat.',
    'is_natural' => 'Bidang {field} hanya boleh berisi angka.',
    'is_natural_no_zero' => 'Bidang {field} hanya boleh berisi angka dan harus lebih besar dari nol.',
    'is_not_unique' => 'Bagian {field} harus berisi nilai yang sudah ada sebelumnya di database.',
    'is_unique' => 'Bidang {field} harus berisi nilai unik.',
    'less_than' => 'Bidang {field} harus berisi angka kurang dari {param}.',
    'less_than_equal_to' => 'Bidang {field} harus berisi angka yang kurang dari atau sama dengan {param}.',
    'matches' => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'max_length' => 'Panjang kolom {field} tidak boleh melebihi {param} karakter.',
    'min_length' => 'Panjang kolom {field} minimal harus {param} karakter.',
    'not_equals' => 'Bidang {field} tidak boleh: {param}.',
    'not_in_list' => 'Bidang {field} tidak boleh salah satu dari: {param}.',
    'numeric' => 'Bagian {field} hanya boleh berisi angka.',
    'regex_match' => 'Format kolom {field} salah.',
    'required' => 'Kolom {field} wajib diisi.',
    'required_with' => 'Bidang {field} diperlukan bila {param} ada.',
    'required_without' => 'Bidang {field} diperlukan bila {param} tidak ada.',
    'string' => 'Bidang {field} harus berupa string yang valid.',
    'timezone' => 'Bagian {field} harus berupa zona waktu yang valid.',
    'valid_base64' => 'Bidang {field} harus berupa string base64 yang valid.',
    'valid_email' => 'Bagian {field} harus berisi alamat email yang valid.',
    'valid_emails' => 'Bagian {field} harus berisi semua alamat email yang valid.',
    'valid_ip' => 'Bagian {field} harus berisi IP yang valid.',
    'valid_url' => 'Bagian {field} harus berisi URL yang valid.',
    'valid_url_strict' => 'Bagian {field} harus berisi URL yang valid.',
    'valid_date' => 'Bagian {field} harus berisi tanggal yang valid.',
    'valid_json' => 'Kolom {field} harus berisi json yang valid.',

    // Kartu kredit
    'valid_cc_num' => '{field} sepertinya bukan nomor kartu kredit yang valid.',

    // File
    'uploaded' => '{field} bukan file unggahan yang valid.',
    'max_size' => '{field} file terlalu besar.',
    'is_image' => '{field} bukan file gambar yang diunggah dan valid.',
    'mime_in' => '{field} tidak memiliki tipe mime yang valid.',
    'ext_in' => '{field} tidak memiliki ekstensi file yang valid.',
    'max_dims' => '{field} mungkin bukan gambar, atau terlalu lebar atau tinggi.',

    'is_unique_custom' => 'Kolom {field} harus mengandung nilai unik.',
    'is_uuid' => 'Kolom {field} harus mengandung UUID yang valid.',
    'valid_phone' => 'Kolom {field} harus mengandung nomor telepon Indonesia yang valid.',
    'check_uuid' => 'Kolom {field} wajib diisi berupa UUID jika action adalah edit.',
    'check_uuid7' => 'Kolom {field} wajib diisi berupa UUIDv7 jika action adalah edit.',
    'check_id' => 'Kolom {field} wajib diisi berupa integer jika action adalah edit.',
    'uuid7' => 'Kolom {field} wajib diisi berupa UUIDv7.',
    'employee_name' => 'Kolom {field} hanya boleh mengandung huruf, spasi, and  [\' . ,] 3-100 karakter.',
];

<?php

namespace Config;

use App\Validations\UUIDv7Validation;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validations\CustomRules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class, // Register CustomRules
        UUIDv7Validation::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $datatables = array(
        'draw' => [
            'label'  => 'DT Draw',
            'rules'  => 'required|is_natural'
        ],
        'start' => [
            'label'  => 'DT Start',
            'rules'  => 'required|is_natural'
        ],
        'length' => [
            'label'  => 'DT Length',
            'rules'  => 'required|integer'
        ],
        'order.*.column' => [
            'label'  => 'DT Kolom',
            'rules'  => 'required|is_natural'
        ],
        'order.*.dir' => [
            'label'  => 'DT Order',
            'rules'  => 'required|in_list[asc,desc]'
        ]
    );

    public array $usergroup = array(
        'group_id' => [
            'label' => 'ID Grup',
            'rules' => 'check_id[action,group_id]'
        ],
        'action' => [
            'label' => 'Aksi',
            'rules' => 'required|in_list[add,edit]'
        ],
        'group_name' => [
            'label'  => 'Nama Grup',
            'rules'  => "required|alpha_numeric_space|max_length[100]|is_unique_custom[tb_user_groups.group_name,group_id,group_id,false]"
        ],
        'group_feature.*' => [
            'label' => 'Hak Akses',
            'rules' => 'required|regex_match[/[a-z0-9\/\-_]+$/]'
        ]
    );

    public array $account = array(
        'user_id' => [
            'label' => 'ID Akun',
            'rules' => 'check_uuid[action,user_id]'
        ],
        'action' => [
            'label' => 'Aksi',
            'rules' => 'required|in_list[add,edit]'
        ],
        'group_id' => [
            'label' => 'Grup Pengguna',
            'rules' => 'required|is_uuid'
        ],
        'user_realname' => [
            'label'  => 'Nama Pegawai',
            'rules'  => "required|alpha_numeric_punct|max_length[100]"
        ],
        'user_name' => [
            'label'  => 'Username',
            'rules'  => "required|alpha_dash|is_unique_custom[tb_users.user_name,user_id,user_id,false]|max_length[100]"
        ],
        'user_email' => [
            'label'  => 'Email',
            'rules'  => "permit_empty|valid_email|is_unique_custom[tb_users.user_email,user_id,user_id,false]|max_length[100]"
        ],
        'user_password' => [
            'label'  => 'Kata Sandi',
            'rules'  => 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,32}$/]',
            'errors' => [
                'regex_match' => '{field} harus mengandung alfanumerik dan simbol 8-32 karakter!'
            ]
        ],
        'repeat_password' => [
            'label'  => 'Ulangi Kata Sandi',
            'rules'  => 'required|matches[user_password]'
        ],
        'is_active' => [
            'label' => 'Status Akun',
            'rules' => 'required|in_list[1,0]'
        ]
    );

    public array $organization = array(
        'org_id' => [
            'label' => 'ID Organisasi',
            'rules' => 'required|is_uuid'
        ],
        'org_name' => [
            'label' => 'Nama Organisasi',
            'rules' => 'required|regex_match[/[a-z0-9 \-.]+$/i]|max_length[100]'
        ],
        'org_profile' => [
            'label' => 'Profil',
            'rules' => 'required|max_length[5000]'
        ],
        'org_slogan' => [
            'label' => 'Slogan',
            'rules' => 'permit_empty|regex_match[/^[^*%$#?\\\|+=`~;:{}\[\]\']+$/]|max_length[5000]',
            'errors'=> [
                'regex_match' => "These characters are not allowed *%$#?\|+=`~;:{}[]'"
            ]
        ],
        'org_vision' => [
            'label' => 'Visi',
            'rules' => 'permit_empty|regex_match[/^[^*%$#?\\\|+=`~;:{}\[\]\']+$/]|max_length[5000]',
            'errors'=> [
                'regex_match' => "These characters are not allowed *%$#?\|+=`~;:{}[]'"
            ]
        ],
        'org_missions' => [
            'label' => 'Misi',
            'rules' => 'permit_empty|regex_match[/^[^*%$#?\\\|+=`~;:{}\[\]\']+$/]|max_length[5000]',
            'errors'=> [
                'regex_match' => "These characters are not allowed *%$#?\|+=`~;:{}[]'"
            ]
        ],
        'org_phone' => [
            'label' => 'No. Telepon',
            'rules' => 'required|valid_phone'
        ],
        'org_email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        'org_address' => [
            'label' => 'Alamat',
            'rules' => 'required|regex_match[/[a-z0-9 \/\-.]+$/i]|max_length[255]'
        ],
        'org_map' => [
            'label' => 'Google Map',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'social_media.instagram' => [
            'label' => 'Instagram',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'social_media.linkedin' => [
            'label' => 'LinkedIn',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'social_media.facebook' => [
            'label' => 'Facebook',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'social_media.tiwtter' => [
            'label' => 'Twitter',
            'rules' => 'permit_empty|valid_url_strict'
        ]
    );

    public array $site_settings = array(
        'site_id' => [
            'label' => 'ID Aplikasi',
            'rules' => 'required|is_uuid'
        ],
        'site_name' => [
            'label' => 'Judul Aplikasi',
            'rules' => 'required|regex_match[/[a-z0-9 \-.]+$/i]|max_length[100]'
        ],
        'site_name_alt' => [
            'label' => 'Judul Aplikasi (Alt)',
            'rules' => 'required|regex_match[/[a-z0-9 \-.]+$/i]|max_length[100]'
        ],
        'site_description' => [
            'label' => 'Deskripsi Aplikasi',
            'rules' => 'permit_empty|regex_match[/^[^*%$#?\\\|+=`~;:{}\[\]\']+$/]|max_length[5000]',
            'errors'=> [
                'regex_match' => "These characters are not allowed *%$#?\|+=`~;:{}[]'"
            ]
        ],
        'site_keywords' => [
            'label' => 'Kata Kunci',
            'rules' => 'permit_empty|regex_match[/[a-z0-9 \-.]+$/i]|max_length[255]'
        ],
        'site_author' => [
            'label' => 'Author',
            'rules' => 'permit_empty|regex_match[/[a-z0-9 \-.]+$/i]|max_length[100]'
        ],
        'site_logo' => [
            'label' => 'Logo Aplikasi',
            'rules' => 'permit_empty|valid_url'
        ],
        'no_surat_dinas' => [
            'label' => 'Tautan Surat Dinas',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'no_sk_kpa' => [
            'label' => 'Tautan SK KPA',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'monitoring_kegiatan' => [
            'label' => 'Tautan Monitoring Kegiatan',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'laporan_keuangan' => [
            'label' => 'Laporan Keuangan',
            'rules' => 'permit_empty|regex_match[/files\/([a-z0-9 %\/\-_]+)\.(pdf|png|jpg|jpeg)/i]',
            'errors'=> [
                'regex_match' => 'Lokasi atau nama file laporan keuangan tidak valid.'
            ]
        ],
        'file_pok' => [
            'label' => 'File POK',
            'rules' => 'permit_empty|regex_match[/files\/([a-z0-9 %\/\-_]+)\.(pdf|png|jpg|jpeg)/i]',
            'errors'=> [
                'regex_match' => 'Lokasi atau nama file POK tidak valid.'
            ]
        ],
        'file_pak' => [
            'label' => 'File PAK',
            'rules' => 'permit_empty|regex_match[/files\/([a-z0-9 %\/\-_]+)\.(pdf|png|jpg|jpeg)/i]',
            'errors'=> [
                'regex_match' => 'Lokasi atau nama file PAK tidak valid.'
            ]
        ],
        'file_peraturan' => [
            'label' => 'File Peraturan',
            'rules' => 'permit_empty|regex_match[/files\/([a-z0-9 %\/\-_]+)\.(pdf|png|jpg|jpeg)/i]',
            'errors'=> [
                'regex_match' => 'Lokasi atau nama file Peraturan tidak valid.'
            ]
        ]
    );

    public array $document = array(
        'document_id' => [
            'label' => 'ID Dokumen',
            'rules' => 'check_uuid7[action,document_id]'
        ],
        'action' => [
            'label' => 'Aksi',
            'rules' => 'required|in_list[add,edit]'
        ],
        'category_id' => [
            'label' => 'Kategori',
            'rules' => 'required|integer'
        ],
        'spj_date' => [
            'label' => 'Tgl. SPJ',
            'rules' => 'required|valid_date[Y-m-d]'
        ],
        'document_classification' => [
            'label' => 'Jenis Dokumen',
            'rules' => 'required|in_list[subbagumum,statsos,statprod,statdist,nerwilis,ipds]'
        ]
    );

    public array $file = array(
        'file_id' => [
            'label' => 'ID File',
            'rules' => 'check_uuid7[action,file_id]'
        ],
        'document_id' => [
            'label' => 'ID Dokumen',
            'rules' => 'required|uuid7'
        ],
        'action' => [
            'label' => 'Aksi',
            'rules' => 'required|in_list[add,edit]'
        ],
        'classification' => [
            'label' => 'Jenis/Klasifikasi File',
            'rules' => 'required|in_list[kak,form_permintaan,sk_kpa,surat_tugas,mon_kegiatan,dok_kegiatan,adm_kegiatan]'
        ]
    );
}

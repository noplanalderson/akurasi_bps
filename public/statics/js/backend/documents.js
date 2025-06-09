const file_classification = ['kak','form_permintaan','sk_kpa','surat_tugas','mon_kegiatan','dok_kegiatan','adm_kegiatan'];
var start = moment().startOf('month');
var end = moment().endOf('month');

$('#range').daterangepicker({
    startDate: start,
    endDate: end,
    "locale": {
        "cancelLabel": 'Clear',
        "format": "YYYY-MM-DD",
    },
    ranges: {
       '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
       '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
       '3 Bulan Terakhir': [moment().subtract(92, 'days'), moment()],
       'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
       'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
});
let tableLogsCfg =  {
    responsive: true,
    processing: true,
    serverSide: true,
    "language": {
        "paginate": {
            "previous": "<i class='fas fa-chevron-left'></i>",
            "next": "<i class='fas fa-chevron-right'></i>",
        },
    },
    "order": [[ 3, "desc" ]],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, 'All'] ],
    'columnDefs': [
        {
            "targets": 'no-sort',
            "orderable": false,
        }
    ],
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Reload',
        className: 'btn btn-info btn-sm py-1 px-2 fs-13',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload(function ( json ) { 
                renewCSRF(json.token);
            }, false);
        }
    }],
    dom: '<"float-start"lB><"float-end"fr>ti<"float-end"p>',
    "ajax": {
        "url": window.location.href,
        "method": "POST",
        "data": function ( d ) {
            var range = $('#range').val().split(' - ');

            d.startDate = range[0];
            d.endDate = range[1];
            d.classification = $('#classification').val();
            d.csrf_token = getCSRF();
        },
        "complete": function(res) {
            var res = res.responseJSON;
            renewCSRF(res.token);
            if(res.errors !== null) {
                Swal.fire("Kesalahan!", res.errors, "error");
            }
        }
    },
    "columns":[
        {
            'title': 'No',
            'data': null,
            'render': (data, type, row, meta) => meta.row + 1
        },
        { 
            "title": "Kategori Layanan",
            "name":"category_name",
            "data": function (row, type, val, meta) { 
                return `${row.category_code}.${row.category_name}`;
            },
            "defaultContent": "-"
        },
        { "data": "document_details", "name": "document_details", "title": "Deskripsi Pekerjaan/Kegiatan" },
        { 
            "title": "Tgl. SPJ Administrasi",
            "name":"spj_date",
            "data": function (row, type, val, meta) { 
                return `Tgl. SPJ: ${row.spj_date.indonesianDate()}<br/><small class="fs-13">Dibuat pada:${row.created_at.indonesianDate()}</small>`;
            },
            "defaultContent": "-"
        },
        { "data": "user_realname", "name": "user_realname", "title": "Petugas", "defaultContent": "-" },
        { 
            "title": "Tgl. Perubahan",
            "name":"updated_at",
            "data": function (row, type, val, meta) { 
                return `${row.updated_at == null ? '-' : row.updated_at.indonesianDate()}`;
            },
            "defaultContent": "-"
        },
        { 
            "title": "Kelengkapan Dokumen",
            "name":"file_count",
            "data": function (row, type, val, meta) { 
                if(row.file_count < 7) {
                    return `<span class="badge badge-danger">Tidak Lengkap (${row.file_count}/7)</span>`;
                } else {
                    return `<span class="badge badge-success">Lengkap (${row.file_count}/7)</span>`;
                }
            },
            "defaultContent": "-"
        },
        { 
            "name":"document_id",
            "defaultContent": "-",
            "data": function (row, type, val, meta) {
                let button = '';
                button += '<div class="dropdown">';
                button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.document_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
                button += '<div class="dropdown-menu" aria-labelledby="act-'+row.document_id+'"><h6 class="dropdown-header">Aksi</h6>';
                button += '<div class="dropdown-divider"></div>';
                if(menu.includes('simpan-dokumen')) {
                    button += "<button class='dropdown-item edit-document' data-toggle='modal' data-target='#documentModal' data-id='"+row.document_id+"'><i class='fas fa-edit'></i> Ubah</button>";
                }
                if(menu.includes('hapus-dokumen')) {
                    button += "<button href='#' data-id='"+row.document_id+"' class='dropdown-item delete-document'><i class='fas fa-trash-alt'></i> Hapus</button>";
                }
                button += "</div></div>";

                return button;
            }
        }
    ],
    initComplete: function(row, type, val, meta) {
        renewCSRF(type.token);
        if(type.errors !== null) {
            Swal.fire("Kesalahan!", type.errors, "error");
        }
    }
};


tableDocuments = $('#tbl_documents').DataTable(tableLogsCfg);

$('#range').on('change', function () {  
    tableDocuments.draw();
})

if(menu.includes('simpan-dokumen')) {
    let button = '<button type="button" class="btn btn-sm add-document btn-primary" data-toggle="modal" data-target="#documentModal"><i class="fas fa-file-upload" aria-hidden="true"></i> Unggah Dokumen</button>';
    $('#tbl_documents_wrapper .btn-group').append(button);
};

let categorySelect = {
    placeholder: 'Pilih Kategori',
    width: '100%',
    dropdownParent:'#documentModal',
    allowClear: true,
    ajax: {
        url: `${baseURI}kategori/select2`,
        type: 'GET',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                search: params.term, // search term
                page: params.page || 1
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            return {
                results: Array.isArray(data.results) ? data.results.map(item => ({
                    id: item.id,
                    text: item.text
                })) : [],
                pagination: {
                    more: false // Adjust if pagination is implemented on the server
                }
            };
        },
        cache: true
    }
};


$('.add-document').on('click', function(e){
    e.preventDefault();

    $('#documentModalLabel').text('Unggah Dokumen');
    $('.error_validation').text('');

    $('#document_id').val('');
    $('#action').val('add');
    $('#status').val('draft');
    $('#document_details').val('');
    $('#spj_date').val('');
    $('#category_id').select2(categorySelect).val('').trigger('change');

    $.each(file_classification, function (i, v) { 
        $(`#${v}_id`).val('');
        $(`#${v}`).fileinput({
            theme: "fa6",
            uploadUrl: `${baseURI}file/simpan`,
            showRemove: false,
            showUpload: false,
            fileActionSettings: {
                showZoom: true,
                showDrag: false
            },
            showBrowse: false,
            browseOnZoneClick: true,
            showCancel: false,
            autoReplace: false,
            append:true,
            uploadAsync: false,
            initialPreviewAsData: true,
            initialPreviewFileType: 'pdf',
            uploadIcon: '<i class="fas fa-upload"></i> Upload',
            uploadExtraData: function() {
                return { 
                    csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                    document_id: $('#document_id').val(),
                    action: 'add',
                    classification: v,
                    file_id: '',
                };
            }               
        }).on('fileselect', function(event, numFiles, label) {
            $('.kv-file-upload').html('<i class="fas fa-upload"></i> Unggah File');
            $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
            $('.file-preview-pdf').css('height', '100%');
        }).
        on('fileuploaderror', function(event, data, msg) {
            renewCSRF(data.response.token);
            renewCSRF(data.response.token);
            Swal.fire(data.response.message, data.response.errors, 'error');
        }).on('filedeleteerror', function(event, data, msg) {
            renewCSRF(data.response.token);
            renewCSRF(data.response.token);
            Swal.fire(data.response.message, data.response.errors, 'error');
        }).on('fileuploaded', function(event, data, previewId, index, fileId) {
            if (data.response.isError !== true) {

                $(`#${v}_id`).val(data.response.file.key);
                $(`#${v}`).fileinput('destroy').fileinput({
                    theme: "fa6",
                    uploadUrl: `${baseURI}file/simpan`,
                    showRemove: false,
                    showUpload: false,
                    fileActionSettings: {
                        showZoom: true,
                        showDrag: false
                    },
                    showBrowse: false,
                    browseOnZoneClick: true,
                    showCancel: false,
                    autoReplace: false,
                    append: true,
                    uploadAsync: false,
                    initialPreviewAsData: true,
                    initialPreviewFileType: 'pdf',
                    initialPreview: [data.response.file.url],
                    initialPreviewConfig: [{
                        caption: data.response.file.name,
                        url: data.response.file.deleteUrl,
                        key: data.response.file.key,
                        downloadUrl: data.response.file.downloadUrl
                    }],
                    uploadExtraData: function() {
                        return { 
                            csrf_token: getCSRF(),
                            document_id: document_id,
                            action: 'edit',
                            classification: v,
                            file_id: $(`#${v}_id`).val(),
                        };
                    }
                });

                $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
                $('.file-preview-pdf').css('height', '100%');
            }
            renewCSRF(data.response.token);
            renewCSRF(data.response.token);
            
            tableDocuments.ajax.reload(null, false);

            var type = data.response.isError == true ? 'error' : 'success';
            Swal.fire(data.response.message, data.response.errors, type);
        }).on('filedeleted', function(event, key, jqXHR, data) {
            renewCSRF(data.response.token);
            renewCSRF(data.response.token);
            if(data.responseJSON.status == null) {
                Swal.fire('Berhasil!', data.responseJSON.message, 'success');
                tableDocuments.ajax.reload(null, false);
            } else {
                Swal.fire('Kesalahan!', `${data.responseJSON.message} ${data.responseJSON.errors}`, 'error');
            }
        });
    });
                
    $('.kv-file-upload').html('<i class="fas fa-upload"></i> Unggah File');
    $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
    $('.file-preview-pdf').css('height', '100%');

    $('#kvFileinputModal').on('hidden.bs.modal', function () {
        // Cek apakah modal pertama masih terlihat
        if ($('#documentModal').hasClass('show')) {
            $('body').addClass('modal-open');
        }
    });
})


$('#tbl_documents').on('click', '.edit-document', function(e) {
    e.preventDefault();
    $('#documentModalLabel').html('Ubah Dokumen');
    $('.error_validation').text('');

    const document_id = $(this).data('id');

    $.ajax({
        url: window.location.href,
        data: {
                document_id: document_id, 
                csrf_token: getCSRF()
            },
        method: 'post',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});
        },
        success: function(response){
            let data = response.data;
            renewCSRF(response.token);

            if(response.status == true) {
                $('#document_id').val(document_id);
                $('#action').val('edit');
                $('#status').val('draft');
                $('#document_classification').val(data.document_classification);
                $('#spj_date').val(data.spj_date);
                
                var newOption = new Option(`${data.category_code}.${data.category_name}`, data.category_id, true, true);
                $('#category_id').append(newOption).trigger('change');
                $('#category_id').select2(categorySelect);

                $('#document_details').val(data.document_details);

                $.each(file_classification, function (i, v) { 
                    let fileId = data.file_data.meta[v] && data.file_data.meta[v].file_id ? data.file_data.meta[v].file_id : '';
                    $(`#${v}_id`).val(fileId);
                    console.log(fileId);
                    let action = fileId == '' ? 'add' : 'edit';
                    $(`#${v}`).fileinput({
                        theme: "fa6",
                        uploadUrl: `${baseURI}file/simpan`,
                        showRemove: false,
                        showUpload: false,
                        fileActionSettings: {
                            showZoom: true,
                            showDrag: false
                        },
                        showBrowse: false,
                        browseOnZoneClick: true,
                        showCancel: false,
                        autoReplace: false,
                        append:true,
                        uploadAsync: false,
                        uploadIcon: '<i class="fas fa-upload"></i> Upload',
                        initialPreviewAsData: true,
                        initialPreviewFileType: 'pdf',
                        uploadExtraData: function() {
                            return { 
                                csrf_token: getCSRF(),
                                document_id: document_id,
                                action: action,
                                classification: v,
                                file_id: $(`#${v}_id`).val(),
                            };
                        },
                        initialPreview: data.file_data.file[v],
                        initialPreviewConfig: [{
                            caption: data.file_data.meta[v].caption,
                            url: data.file_data.meta[v].url,
                            key: data.file_data.meta[v].key,
                            downloadUrl: data.file_data.meta[v].downloadUrl
                        }]            
                    }).on('fileselect', function(event, numFiles, label) {
                        $('.kv-file-upload').html('<i class="fas fa-upload"></i> Unggah File');
                        $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
                        $('.file-preview-pdf').css('height', '100%');
                    }).on('fileuploaderror', function(event, data, msg) {
                        renewCSRF(data.response.token);
                        renewCSRF(data.response.token);
                        Swal.fire(data.response.message, data.response.errors, 'error');
                    }).on('filedeleteerror', function(event, data, msg) {
                        renewCSRF(data.response.token);
                        renewCSRF(data.response.token);
                        Swal.fire(data.response.message, data.response.errors, 'error');
                    }).on('fileuploaded', function(event, data, previewId, index, fileId) {
                        if (data.response.isError !== true) {
                            $(`#${v}_id`).val(data.response.file.key);
                            $(`#${v}`).fileinput('destroy').fileinput({
                                theme: "fa6",
                                uploadUrl: `${baseURI}file/simpan`,
                                showRemove: false,
                                showUpload: false,
                                fileActionSettings: {
                                    showZoom: true,
                                    showDrag: false
                                },
                                showBrowse: false,
                                browseOnZoneClick: true,
                                showCancel: false,
                                autoReplace: false,
                                append: true,
                                uploadAsync: false,
                                initialPreviewAsData: true,
                                initialPreviewFileType: 'pdf',
                                initialPreview: [data.response.file.url],
                                initialPreviewConfig: [{
                                    caption: data.response.file.name,
                                    url: data.response.file.deleteUrl,
                                    key: data.response.file.key,
                                    downloadUrl: data.response.file.downloadUrl
                                }],
                                uploadExtraData: function() {
                                    return { 
                                        csrf_token: getCSRF(),
                                        document_id: document_id,
                                        action: 'edit',
                                        classification: v,
                                        file_id: $(`#${v}_id`).val(),
                                    };
                                }
                            });
                            $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
                            $('.file-preview-pdf').css('height', '100%');
                        }
                        renewCSRF(data.response.token);
                        renewCSRF(data.response.token);
                        
                        tableDocuments.ajax.reload(null, false);

                        var type = data.response.isError == true ? 'error' : 'success';
                        Swal.fire(data.response.message, data.response.errors, type);
                    }).on('filedeleted', function(event, key, data) {
                        renewCSRF(data.responseJSON.token);
                        renewCSRF(data.responseJSON.token);
                        if(data.responseJSON.status == null) {
                            Swal.fire('Berhasil!', data.responseJSON.message, 'success');
                            tableDocuments.ajax.reload(null, false);
                        } else {
                            Swal.fire('Kesalahan!', `${data.responseJSON.message} ${data.responseJSON.errors}`, 'error');
                        }
                    });
                });

                $('.kv-file-upload').html('<i class="fas fa-upload"></i> Unggah File');
                $('.krajee-default.file-preview-frame .kv-file-content').addClass('vh-100');
                $('.file-preview-pdf').css('height', '100%');

                $('#kvFileinputModal').on('hidden.bs.modal', function () {
                    // Cek apakah modal pertama masih terlihat
                    if ($('#documentModal').hasClass('show')) {
                        $('body').addClass('modal-open');
                    }
                });
            } else {
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: '',
                    text: response.error.replace( /(<([^>]+)>)/ig, ''),
                });
            }
        }
    });
})

let wz_class = ".wizard";

const wizard = new Wizard({
    wz_class: wz_class,
    "wz_nav_style": "dots",
    wz_ori: "horizontal",
    "wz_button_style": ".btn .btn-sm mx-1",
    buttons: true,
    next: "Lanjut",
    prev: "Kembali",
    finish: '<i class="fas fa-save"></i> Simpan',
    navigation: "all"
});

wizard.init();

document.getElementById("btn_reset").onclick = function () {
    wizard.reset();
};
  
let $wz_doc = document.querySelector(wz_class);

$wz_doc.addEventListener("wz.btn.next", function (e) {
    e.preventDefault();
    let status = $('#status').val();
    if(status === 'draft') {
        document.querySelector('.wizard-buttons .next').setAttribute('disabled', 'disabled');
        let formData = new FormData(document.querySelector('#formDocument'));
        $('.error_validation').text('');

        $.ajax({
            url: `${baseURI}simpan-dokumen`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function(xhr, status, error) {
                var data = 'Terjadi kesalahan! Mohon muat ulang halaman  (status code: ' + xhr.status + ')';
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: 'Error: ',
                    text: data,
                });
                document.querySelector('.wizard-buttons .next').removeAttribute('disabled');
            },
            success: function (response) {
                if (response.status) {
                    renewCSRF(response.token);
                    $('#document_id').val(response.document_id || '');
                    $('#action').val('edit');
                    $('#status').val('saved');
                    Swal.fire("Berhasil!", response.message, "success");
                    tableDocuments.ajax.reload(null,false);
                } else {
                    
                    Swal.fire("Kesalahan!", response.message, "error");
                }
        
                document.querySelector('.wizard-buttons .next').removeAttribute('disabled');
            }
        });
    }
    return false; // Prevent default next step behavior
});

$("#tbl_documents").on('click', '.delete-document', function(e){
    e.preventDefault();
  
    Swal.fire({
        title: 'Perhatian!',
        text: 'Anda yakin ingin menghapus dokumen?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
  
        if (result.value == true) {
  
            Swal.fire({
                title: 'Tunggu!',
                text: 'Menghapus dokumen...',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                type: 'warning',
                showConfirmButton: false,
                showCancelButton: false,
                reverseButtons: true
            })
  
            const document_id = $(this).data('id');
            $.ajax({
                url: `${baseURI}hapus-dokumen`,
                data: {
                        document_id: document_id, 
                        csrf_token: getCSRF()
                },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
                    Toast.fire({type:'error', icon:'error', title: '', text: data});
                },
                success: function(data) {
                    renewCSRF(data.csrf_token);

                    if (data.status == true) {
                        Swal.fire('Berhasil!', data.message, 'success');
                        tableDocuments.ajax.reload(null, false);
                    } else {
                        let errors = data.errors.validations;
                        let message = data.message;
                        if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                            $.each(errors, function( i, v ) {
                                message += `${v}<br/>`;
                            });
                        }
                        
                        Swal.fire('Kesalahan!', message, 'error');
                    }
                }
            });
        }
    })
});

$wz_doc.addEventListener("wz.form.submit", function (e) {
    e.preventDefault();
    let isValid = true;
    const uuid7Regex = /^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;

    file_classification.forEach(field => {
        const value = $(`#${field}_id`).val();
        if (!value || !uuid7Regex.test(value)) {
            isValid = false;
            $(`#${field}_id`).siblings('.error_validation').text('Field is required and must be a valid UUIDv7.');
        } else {
            $(`#${field}_id`).siblings('.error_validation').text('');
        }
    });

    if (!isValid) {
        Swal.fire('Kesalahan!', 'Pastikan anda mengunggah semua file yang dibutuhkan.', 'error');
        return false;
    } else {
        Swal.fire('Berhasil!', 'Dokumen dan file berhasil disimpan.', 'success');
        tableDocuments.ajax.reload(null, false);
        $('#documentModal').modal('hide');
    }
})

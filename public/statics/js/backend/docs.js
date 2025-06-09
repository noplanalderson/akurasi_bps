const file_classification = ['kak','form_permintaan','sk_kpa','surat_tugas','mon_kegiatan','dok_kegiatan','adm_kegiatan'];
var start = moment().startOf('month');
var end = moment().endOf('month');

let url = null;

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
                    return `<a href="#" data-id="${row.document_id}" data-toggle="modal" data-target="#modalFiles" class="btn btn-sm fs-11 btn-danger daftar-berkas">Tidak Lengkap (${row.file_count}/7)</a>`;
                } else {
                    return `<a href="#" data-id="${row.document_id}" data-toggle="modal" data-target="#modalFiles" class="btn btn-sm fs-11 btn-success daftar-berkas">Lengkap (${row.file_count}/7)</a>`;
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


// Show selected file name in custom file input
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files.length ? e.target.files[0].name : 'Pilih file PDF...';
            var inputId = input.id;
            var fileId = document.getElementById(inputId + '_id').value;
            var label = input.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.textContent = fileName;
            }
            let btnGroup = input.parentElement.querySelector('.file-btn-group');
            if (!btnGroup) {
                btnGroup = document.createElement('div');
                btnGroup.className = 'file-btn-group mt-2 btn-group btn-group-sm w-100 mb-4';
                input.parentElement.appendChild(btnGroup);
            }
            
            if (input.files.length) {
                const file = input.files[0];
                if (file.type === "application/pdf") {
                    url = URL.createObjectURL(file);
                    // window.open(url, '_blank');
                }
            }

            btnGroup.innerHTML = `
                <button type="button" class="btn btn-success upload-btn"><i class="fas fa-upload"></i> Unggah</button>
                <button type="button" data-toggle="modal" data-target="#previewModal" data-url="${url}" class="btn btn-info preview-btn"><i class="fas fa-eye"></i> Pratinjau</button>
                <button type="button" class="btn btn-danger delete-btn"><i class="fas fa-trash"></i> Hapus</button>
            `;

            btnGroup.querySelector('.upload-btn').onclick = function() {
                // Upload file when "Unggah" button is clicked
                const file = input.files[0];
                const $error = $(`error_${inputId}`);
                $error.text('');
                btnGroup.querySelector('.upload-btn').setAttribute('disabled', 'disabled');
                btnGroup.querySelector('.upload-btn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
                if (!file) return;

                const formData = new FormData();
                formData.append(inputId, file);
                formData.append('classification', inputId);
                formData.append('document_id', document.getElementById('document_id').value || '');
                formData.append('file_id', fileId);
                formData.append('action', fileId == '' ? 'add' : 'edit');
                formData.append('csrf_token', getCSRF());

                $.ajax({
                    url: `${baseURI}file/simpan`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        renewCSRF(response.token);
                        if (response.status && response.file.file_id && response.file.url) {
                            $(`#${inputId}_id`).val(response.file.file_id);
                            // Update preview button's data-url with the new file URL
                            let previewBtn = input.parentElement.querySelector('.preview-btn');
                            if (previewBtn) {
                                previewBtn.setAttribute('data-url', response.file.url);
                            }
                            if (label && response.file.name) {
                                label.textContent = response.file.name;
                            }
                            Toast.fire({
                                type: 'success',
                                icon: 'success',
                                title: '',
                                text: response.message || 'File berhasil diunggah.'
                            });

                            tableDocuments.ajax.reload(null, false);
                            btnGroup.querySelector('.upload-btn').remove();
                        } else {
                            $(`#${inputId}_id`).val('');
                            $(`#preview-${inputId}`).addClass('d-none').attr('src', '');
                            
                            Toast.fire({
                                type: 'error',
                                icon: 'error',
                                title: 'Upload Gagal!',
                                text: 'Periksa kembali file yang anda unggah.'
                            });
                            $error.text(response.errors.validations || 'Gagal mengunggah file.');
                            btnGroup.querySelector('.upload-btn').removeAttribute('disabled');
                            btnGroup.querySelector('.upload-btn').innerHTML = '<i class="fas fa-upload"></i> Unggah';
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $(`#${inputId}_id`).val('');
                        btnGroup.querySelector('.upload-btn').removeAttribute('disabled');
                        btnGroup.querySelector('.upload-btn').innerHTML = '<i class="fas fa-upload"></i> Unggah';
                        
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: '',
                            text: 'Terjadi kesalahan saat mengunggah file. (error code: '+jqXHR.status+')'
                        });
                    }
                });
            };
            btnGroup.querySelector('.preview-btn').onclick = function() {
                let frame = document.getElementById('frame-pdf');
                frame.classList.remove('d-none');
                frame.setAttribute('src', this.getAttribute('data-url'));
            };
            btnGroup.querySelector('.delete-btn').onclick = function() {
                input.value = '';
                let label = input.nextElementSibling;
                if (label && label.classList.contains('custom-file-label')) {
                    label.textContent = 'Pilih file PDF...';
                }
                btnGroup.remove();
            };
        });
    });
});

$('#previewModal').on('hidden.bs.modal', function () {
    // Cek apakah modal pertama masih terlihat
    if ($('#documentModal').hasClass('show')) {
        $('body').addClass('modal-open');
    }
});

if(menu.includes('simpan-dokumen')) {
    let button = '<button type="button" class="btn btn-sm add-document btn-primary" data-toggle="modal" data-target="#documentModal"><i class="fas fa-file-upload" aria-hidden="true"></i> Unggah Dokumen</button>';
    $('#tbl_documents_wrapper .btn-group').append(button);
};

// Use event delegation in case file inputs are dynamically added
// $.each(file_classification, function (i, v) {
//     $(document).on('change', `#${v}`, function (e) {
//         const fileInput = this;
//         const file = fileInput.files[0];
//         const $error = $(fileInput).siblings('.error_validation');
//         $error.text('');
//         if (!file) return;

//         const formData = new FormData();
//         formData.append('file', file);
//         formData.append('classification', v);
//         formData.append('csrf_token', getCSRF());

//         // Show loading indicator if needed

//         $.ajax({
//             url: `${baseURI}file/simpan`,
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             dataType: 'json',
//             success: function (response) {
//                 renewCSRF(response.token);
//                 if (response.status && response.file_id && response.file_url) {
//                     $(`#${v}_id`).val(response.file_id);
//                     $(`#preview-${v}`).removeClass('d-none').attr('src', response.file_url);
//                 } else {
//                     $(`#${v}_id`).val('');
//                     $(`#preview-${v}`).addClass('d-none').attr('src', '');
//                     $error.text(response.message || 'Gagal mengunggah file.');
//                 }
//             },
//             error: function (xhr) {
//                 $(`#${v}_id`).val('');
//                 $(`#preview-${v}`).addClass('d-none').attr('src', '');
//                 $error.text('Terjadi kesalahan saat upload.');
//             }
//         });
//     });
// })

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
    $('.file-id').val('');
    $('.file-preview').attr('src', '');
})

$('#tbl_documents').on('click', '.daftar-berkas', function(e) {
    e.preventDefault();

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

            if(response.status == true) 
            {
                $.each(file_classification, function (i, v) { 
                    if(typeof data.file_data.meta[v] !== 'undefined' || data.file_data.meta[v] !== null) {
                        let date = typeof data.file_data.meta[v].upload_date === 'undefined' ? '-' : data.file_data.meta[v].upload_date.indonesianDate();
                        let uploader = typeof data.file_data.meta[v].uploader === 'undefined' ? '-' : data.file_data.meta[v].uploader;
                        $(`#${v}_upload_date`).text(date);
                        $(`#${v}_uploader`).text(uploader);
                        if(typeof data.file_data.meta[v].downloadUrl !== 'undefined') {
                            $(`#${v}_file_link`)
                                .attr('href', data.file_data.meta[v].downloadUrl)
                                .html('<i class="fas fa-eye"></i> Lihat Berkas')
                                .addClass('btn-success')
                                .removeClass('btn-primary')
                        } else {
                            $(`#${v}_file_link`)
                                .removeAttr('target rel')
                                .attr('href','#')
                                .html('<i class="fas fa-exclamation-triangle"></i> Berkas belum diunggah')
                                .removeClass('btn-primary')
                                .addClass('btn-danger');
                        }
                    } 
                });
            }
            else
            {
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: '',
                    text: response.error.replace( /(<([^>]+)>)/ig, ''),
                });
            }
        }
    });
});

$('#tbl_documents').on('click', '.edit-document', function(e) {
    e.preventDefault();
    $('#documentModalLabel').html('Ubah Dokumen');
    $('.error_validation').text('');
    $('.file-id').val('');

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
                    if(typeof data.file_data.file[v] !== 'undefined' || data.file_data.file[v] !== null) {
                        if (data.file_data.file[v]) {
                            let btnGroup = $(`#${v}`).closest('.custom-file').find('.file-btn-group');
                            if (!btnGroup.length) {
                                btnGroup = $('<div class="file-btn-group mt-2 btn-group btn-group-sm w-100 mb-4"></div>');
                                $(`#${v}`).parent().append(btnGroup);
                            }
                            btnGroup.html(`
                                <button type="button" data-toggle="modal" data-target="#previewModal" data-url="${data.file_data.file[v]}" class="btn btn-info preview-btn"><i class="fas fa-eye"></i> Pratinjau</button>
                                <button type="button" class="btn btn-danger delete-btn" data-id="${data.file_data.meta[v].file_id}"><i class="fas fa-trash"></i> Hapus</button>
                            `);
                            let label = $(`#${v}`).siblings('.custom-file-label');
                            if (label.length && data.file_data.meta[v] && data.file_data.meta[v].caption) {
                                label.text(data.file_data.meta[v].caption);
                            } else if (label.length && data.file_data.file[v]) {
                                // fallback: show filename from URL if caption not available
                                try {
                                    const urlParts = data.file_data.file[v].split('/');
                                    label.text(urlParts[urlParts.length - 1]);
                                } catch (e) {
                                    label.text('Pilih file PDF...');
                                }
                            }
                            btnGroup.find('.preview-btn').on('click', function() {
                                let frame = document.getElementById('frame-pdf');
                                frame.setAttribute('src', $(this).data('url'));
                            });
                            
                            btnGroup.find('.delete-btn').on('click', function() {
                                 Swal.fire({
                                    title: 'Perhatian!',
                                    text: 'Anda yakin ingin menghapus file?',
                                    showCancelButton: true,
                                    type: 'warning',
                                    confirmButtonText: 'Ya',
                                    cancelButtonText: 'Batal',
                                    reverseButtons: true
                                }).then((result) => {
                            
                                    if (result.value == true) {
                                        
                                        btnGroup.find('.delete-btn').attr('disabled', 'disabled');
                                        btnGroup.find('.delete-btn').html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                            
                                        const key = $(this).data('id');
                                        $.ajax({
                                            url: `${baseURI}file/hapus`,
                                            data: {
                                                    key: key, 
                                                    csrf_token: getCSRF()
                                            },
                                            method: 'post',
                                            dataType: 'json',
                                            error: function(xhr, status, error) {
                                                var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
                                                Toast.fire({type:'error', icon:'error', title: '', text: data});
                                                btnGroup.find('.delete-btn').removeAttr('disabled');
                                                btnGroup.find('.delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
                                            },
                                            success: function(data) {
                                                renewCSRF(data.csrf_token);

                                                if (data.status == true) {
                                                    Swal.fire('Berhasil!', data.message, 'success');
                                                    $(`#${v}_id`).val('');
                                                    
                                                    let label = $(`#${v}`).siblings('.custom-file-label');
                                                    if (label.length) {
                                                        label.text('Pilih file PDF...');
                                                    }
                                                    btnGroup.remove();
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
                                                btnGroup.find('.delete-btn').removeAttr('disabled');
                                                btnGroup.find('.delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
                                            }
                                        });
                                    }
                                })
                            });
                            // let previewBtn = $(`#${v}`).closest('.custom-file').find('.preview-btn');
                            // if (previewBtn.length) {
                            //     previewBtn.attr('data-url', data.file_data.file[v]);
                            // }
                            // Check if the URL is not a 404 by making a HEAD request
                            // $.ajax({
                            //     url: data.file_data.file[v],
                            //     type: 'HEAD',
                            //     success: function() {
                            //         $('#preview-' + v).removeClass('d-none').attr('src', `${data.file_data.file[v]}`);
                            //     },
                            //     error: function(xhr) {
                            //         if (xhr.status === 404) {
                            //             $('#preview-' + v).addClass('d-none').attr('src', '');
                            //         }
                            //     }
                            // });
                        }
                    }
                    let action = fileId == '' ? 'add' : 'edit'; 
                })

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

$(".finish").on('click', function (e) {
    e.preventDefault();
    let isValid = true;
    const uuid7Regex = /^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;

    file_classification.forEach(field => {
        const value = $(`#${field}_id`).val();
        if (!value || !uuid7Regex.test(value)) {
            isValid = false;
            $('#error_'+field).text('Field is required and must be a valid UUIDv7.');
        } else {
            $('#error_'+field).text('');
        }
    });

    if (!isValid) {
        console.log('Pastikan anda mengunggah semua file yang dibutuhkan.');
        Swal.fire('Kesalahan!', 'Pastikan anda mengunggah semua file yang dibutuhkan.', 'error');
        return false;
    } else {
        Swal.fire('Berhasil!', 'Dokumen dan file berhasil disimpan.', 'success');
        tableDocuments.ajax.reload(null, false);
        $('#documentModal').modal('hide');
    }
})

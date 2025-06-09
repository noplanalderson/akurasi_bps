let tblCategories;

let tableCfgCategories = {
    responsive: true,
    processing: true,
    serverSide: true,
    searchDelay: 1000,
    "lengthMenu": [[10,25,50,-1],[10,25,50,"All"]],
    "order": [[0, "asc"]],
    dom: '<"left"l><"right"fr>Btip',
    'columnDefs': [
        {
            "targets": "no-sort",
            'orderable': false
        },
        {
            "targets": [3],
            'width': "200px"
        },
        {
            "targets": [4],
            'width': "80px"
        }
    ],
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'kategori').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'kategori',
        "method": "POST",
        "data": function ( d ) {
            d.type = 'categories';
            d.csrf_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        },
        "complete": function(res) {
            var res = res.responseJSON;
            $('input[name="csrf_token"]').val(res.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', res.token);
            if(res.errors !== null) {
                Swal.fire("Error!", res.errors, "error");
            }
        }
    },
    "columns":[
        {
            "name": "category_code",
            "data": "category_code",
            "title": "Kode Kategori",
            "defaultContent": "-"
        },
        {
            "name": "category_name",
            "data": "category_name",
            "title": "Kategori",
            "defaultContent": "-"
        },
        {  
            "name":"category_slug",
            "data": "category_slug",
            "title": "Slug",
            "defaultContent": "-"
        },
        { 
            "name":"created_at",
            "title": "Tgl. Ditambahkan",
            "data": function (row, type, val, meta) {
                return `Tgl. Ditambahkan: ${row.created_at}<br/>Tgl. Diperbarui: ${row.updated_at ?? '-'}`;
            },
            "defaultContent": "-",
        },
        { 
            "name":"category_id",
            "defaultContent": "-",
            "data": function (row, type, val, meta) {
                let button = '';
                button += '<div class="dropdown">';
                button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.category_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
                button += '<div class="dropdown-menu" aria-labelledby="act-'+row.category_id+'"><h6 class="dropdown-header">Action</h6>';
                button += '<div class="dropdown-divider"></div>';
                if(menu.includes('kategori/simpan')) {
                    button += "<button class='dropdown-item edit-category' data-toggle='modal' data-target='#categoryModal' data-id='"+row.category_id+"'><i class='fas fa-edit'></i> Ubah</button>";
                }
                if(menu.includes('kategori/hapus')) {
                    button += "<button href='#' data-id='"+row.category_id+"' class='dropdown-item delete-category'><i class='fas fa-trash-alt'></i> Hapus</button>";
                }
                button += "</div></div>";

                return button;
            }}
    ],
    initComplete: function(row, type, val, meta) {
        $('input[name="csrf_token"]').val(type.token);
        $('meta[name="X-CSRF-TOKEN"]').attr('content', type.token);
        if(type.errors !== null) {
            Swal.fire("Error!", type.errors, "error");
        }
    }
}

tblCategories = $('#tbl_categories').DataTable(tableCfgCategories);

if(menu.includes('kategori/simpan')) {
    let button = '<button type="button" class="btn btn-sm add-category btn-primary" data-toggle="modal" data-target="#categoryModal"><i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Kategori</button>';
    $('#tbl_categories_wrapper .btn-group').append(button);
};

$('.add-category').on('click', function(e) {
    e.preventDefault();

    $('#categoryModalLabel').text('Tambah Kategori');
    $('.error_validation').text('');
    $('#category_id').val('');
    $('#action').val('add');
    $('#category_code').val('');
    $('#category_name').val('');
})

$("#categoryForm").on('submit', function(e) {
    e.preventDefault();
    $('#submitCategory').prop('disabled', true);
    $('#submitCategory').html('<i class="fas fa-spin fa-spinner"></i> Menyimpan...');
    $('.error_validation').text('');

    var formAction = $(this).attr('action');

    $.ajax({
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        url: formAction,
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman  (status code: ' + xhr.status + ')';
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: 'Error: ',
                text: data,
            });

            $('#submitCategory').prop('disabled', false);
            $('#submitCategory').html('<i class="fas fa-save"></i> Simpan');
        },
        success: function(data) {

            $('input[name="csrf_token"]').val(data.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('.error-validation').text('');
            if (data.status == true) {
                Swal.fire('Success!', data.message, 'success');
                tblCategories.ajax.reload(null, false);

                $('#categoryModal').modal('hide');
            } else {
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: 'Error: ',
                    text: data.message,
                });

                let errors = data.errors.validations;

                if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                    $.each(errors, function( i, v ) {
                        $(`#error_${i}`).text(v);
                    });
                }
            }

            $('#submitCategory').prop('disabled', false);
            $('#submitCategory').html('<i class="fas fa-save"></i> Simpan');
        }
    });

    return false;
});

$('#tbl_categories').on('click', '.edit-category', function() {
    var category_id = $(this).data('id');
    var formAction = baseURI + 'kategori';
    $('.error_validation').text('');

    $.ajax({
        type: "POST",
        url: formAction,
        data: {
            category_id: category_id,
            csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
        },
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman  (status code: ' + xhr.status + ')';
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: 'Error: ',
                text: data,
            });
        },
        success: function(data) {
            if(data.status == false) {
                Swal.fire("Kesalahan!", data.message, "error");
            }
            $('#categoryModalLabel').text('Edit Category');
            $('#category_id').val(data.data.category_id);
            $('#action').val('edit');
            $('#category_name').val(data.data.category_name);
            $('#category_code').val(data.data.category_code);
        }
    });
});

$('#tbl_categories').on('click', '.delete-category', function() {
    var category_id = $(this).data('id');
    var formAction = baseURI + 'kategori/hapus';

    Swal.fire({
        title: 'Perhatian!',
        text: 'Anda yakin ingin menghapus kategori?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: formAction,
                data: {
                    category_id: category_id,
                    csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Terjadi kesalahan! Mohon muat ulang halaman  (status code: ' + xhr.status + ')';
                    Toast.fire({
                        type : 'error',
                        icon: 'error',
                        title: 'Error: ',
                        text: data,
                    });
                },
                success: function(data) {
                    if(data.status == false) {
                        Swal.fire("Kesalahan!", data.message, "error");
                    } else {
                        Swal.fire('Berhasil!', data.message, 'success');
                        tblCategories.ajax.reload(null, false);
                    }
                }
            });
        }
    });
});
let tableCfg = {
    responsive: true,
    processing: true,
    serverSide: true,
    "lengthMenu": [[5,10,-1],[5,10,"All"]],
    "order": [[ 0, "asc" ]],
    'columnDefs': [ 
        {
            'targets': [1,2,3,4],
            'orderable': false,
            'searchable': false
        },
        {
            "class": "wrapok", 
            "targets": [1],
            "width": '50%'
        },
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'grup').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'grup',
        "method": "POST",
        "data": function ( d ) {
            d.csrf_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        },
        "complete": function(res) {
            var res = res.responseJSON;
            $('input[name="csrf_token"]').val(res.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', res.token);
            if(res.errors !== null) {
                Swal.fire("Kesalahan!", res.errors, "error");
            }
        }
    },
    "columns":[
        { 
            "name":"group_name",
            "data": function (row, type, val, meta) { 
                return row.group_name;
            },
            "defaultContent": "-"
        },
        {  
            "name":"group_id",
            "data": function (row, type, val, meta) { 
                var h = '';

                if(row.features !== null) {
                    let features = row.features.split(',');
                    $.each(features, function(index, val) {
                      h += '<span class="badge badge-success p-2 m-1">'+val+'</span>'
                    });
                }
                return h;
            },
            "defaultContent": "-"
        },
        { 
            "name":"read_mode",
            "data": function (row, type, val, meta) { 
                return row.read_mode;
            },
            "defaultContent": "-"
        },
        { 
            "name":"index_page",
            "data": function (row, type, val, meta) { 
                return '<select name="index_page" class="index_page" data-id="'+row.group_id+'" required><option value="">Index Page</option>'+row.index_page+'</select><small id="error_index_page_'+row.group_id+'" class="d-block text-danger error_field text-wrap"></small>';
            },
            "defaultContent": "-"
        },
        { 
            "name":"group_id",
            "defaultContent": "-",
            "data": function (row, type, val, meta) {
                let button = '';
                button += '<div class="dropdown">';
                button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.group_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
                button += '<div class="dropdown-menu" aria-labelledby="act-'+row.group_id+'"><h6 class="dropdown-header">Action</h6>';
                button += '<div class="dropdown-divider"></div>';
                if(menu.includes('grup/simpan')) {
                    button += "<button class='dropdown-item edit-group' data-toggle='modal' data-target='#groupModal' data-id='"+row.group_id+"'><i class='fas fa-edit'></i> Ubah</button>";
                }
                if(menu.includes('grup/hapus')) {
                    button += "<button href='#' data-id='"+row.group_id+"' data-name='"+row.group_name+"' class='dropdown-item delete-group'><i class='fas fa-trash-alt'></i> Hapus</button>";
                }
                button += "</div></div>";

                return button;
            }}
    ],
    initComplete: function(row, type, val, meta) {
        $('input[name="csrf_token"]').val(type.token);
        $('meta[name="X-CSRF-TOKEN"]').attr('content', type.token);
        if(type.errors !== null) {
            Swal.fire("Kesalahan!", type.errors, "error");
        }
    }
}

let tblGroup = $('#tbl_group').DataTable(tableCfg);

if(menu.includes('grup/simpan')) {
    let button = '<button type="button" class="btn btn-sm add-group btn-primary" data-toggle="modal" data-target="#groupModal"><i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Grup</button>';
    $('#tbl_group_wrapper .btn-group').append(button);
};

$(function () {
    var features = "";
    $.getJSON(baseURI + "grup/fitur", function(data) {

        $.each(data, function(index, item) {
            features += "<option value='" + item.menu_group + "_"+item.menu_mode+"'>" + item.menu_group.toUpperCase() + " ("+item.menu_mode+")</option>";
        });
        $("#group_feature").html(features);
    });
})

function initSelect2(val = '') {
    $('#group_feature').select2({
        width: '100%',
        dropdownParent:'#groupModal',
        placeholder: 'Pilih hak akses'
    }).val(val).trigger('change');
}

$('#mode').on('change', function(e) {
    e.preventDefault();
    var features = "";
    $.getJSON(baseURI + "grup/fitur?mode="+$(this).val(), function(data) {

        $.each(data, function(index, item) {
            features += "<option value='" + item.menu_group + "_"+item.menu_mode+"' selected>" + item.menu_group.toUpperCase() + " ("+item.menu_mode+")</option>";
        });
        $("#group_feature").html(features);
    });

    initSelect2();
})

$('.add-group').on('click', function(e) {
    e.preventDefault();

    $('#groupModal .modal-title').text('Tambah Grup');
    $('.error_field').text('');
    $('#group_id').val('');
    $('#action').val('add');
    $('#group_name').val('');
    $('#read_mode').val('0');
    $('#group_feature').val('');
    $('#mode').val('').trigger('change');
    initSelect2();
})  

$('#tbl_group').on('click', '.edit-group', function(e) {
    e.preventDefault();

    $('#groupModal .modal-title').text('Ubah Grup');
    $('.error_field').text('');

    let group_id = $(this).data('id');
    let csrf_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');

    $.ajax({
        url: baseURI + 'grup',
        type: 'post',
        data: {
            group_id,
            csrf_token
        },
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});
        },
        success: function (data) {
            
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('input[name="csrf_token"]').val(data.token);

            if(data.status == true) {
                var d = data.data;
                $('#action').val('edit');
                $('#group_id').val(group_id);
                $('#group_name').val(d.group_name);
                $('#read_mode').val(d.read_mode);
                $('#mode').val(d.mode).trigger('change');

                var features = d.menus;

                if (features) {
                    var arrayFeatures = features.split(',');
                    initSelect2(arrayFeatures);
                }
                else
                {
                    initSelect2();
                }
            }
            else
            {
                Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Kesalahan: ',
                   text: data.message,
                });
            }
        }
    })
})

$('#groupForm').on('submit', function(e) {
    e.preventDefault();
    $('.modal-footer button[type=submit]').prop('disabled', true);
    $('.modal-footer button[type=submit]').html('<i class="fas fa-spin fa-spinner"></i> Menyimpan...');

    let action = $(this).attr('action');

    let data = {
        action: $('#action').val(),
        group_id: $('#group_id').val(),
        group_name: $('#group_name').val(),
        mode: $('#mode').val(),
        read_mode: $('#read_mode').val(),
        group_feature: $('#group_feature').val(),
        csrf_token: $('input[name="csrf_token"]').val()
    };

    $.ajax({
        url: action,
        type: 'post',
        data: data,
        dataType:'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});

            $('.modal-footer button[type=submit]').prop('disabled', false);
            $('.modal-footer button[type=submit]').html('<i class="fas fa-save"></i> Simpan');
        },
        success: function (data, xhr) {
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            $('input[name="csrf_token"]').val(data.token);
            if(data.status == true) {

                Toast.fire({
                   type : 'success',
                   icon: 'success',
                   title: '',
                   text: data.message,
                });
                $('#groupModal').modal('hide');
                tblGroup.ajax.reload(null, false);

            } else {
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: 'Kesalahan: ',
                    text: data.message,
                });

                let errors = data.errors.validations;

                if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                    $.each(errors, function( i, v ) {
                        $(`#error_${i}`).text(v);
                    });
                }
            }

            $('.modal-footer button[type=submit]').prop('disabled', false);
            $('.modal-footer button[type=submit]').html('<i class="fas fa-save"></i> Simpan');
        }
    });
})

$("#tbl_group").on('click', '.delete-group', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Perhatian!',
        text: 'Anda yakin ingin menghapus grup?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.value == true) {

            Swal.fire({
                title: 'Wait',
                text: 'Menghapus grup..',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                type: 'warning',
                showConfirmButton: false,
                showCancelButton: false,
                reverseButtons: true
            })

            const group_id = $(this).data('id');
            const group_name = $(this).data('name');
            $.ajax({
                url: baseURI + 'grup/hapus',
                data: {
                        group_id: group_id, 
                        group_name: group_name,
                        csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
                    Toast.fire({type:'error', icon:'error', title: '', text: data});
                },
                success: function(data) {
                    $('input[name="csrf_token"]').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    if (data.status == true) {
                        Swal.fire('Success!', data.message, 'success');
                        tblGroup.ajax.reload(null, false);
                    } else {
                        let errors = data.errors.validations;
                        let message = data.message;
                        if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                            $.each(errors, function( i, v ) {
                                message += `${v}<br/>`;
                            });
                        }
                        
                        Swal.fire('Gagal!', message, 'error');
                    }
                }
            });
        }
    })
});

$("#tbl_group").on('change', '.index_page', function(){
    
    const group_id = $(this).data('id');
    var index_page = $('select[data-id="'+group_id+'"]').val();

    $.ajax({
        url: baseURI + 'grup/update-index',
        data: { 
            group_id,
            index_page,
            csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        method: 'post',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});
        },
        success: function(data) {

            $('input[name="csrf_token"]').val(data.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

            if(data.status == false) {
                $('.index_page option').prop('selected', function() {
                    return this.defaultSelected;
                });
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: 'Error: ',
                    text: data.message,
                })

                let errors = data.errors.validations;

                if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                    var text = '';
                    $.each(errors, function( i, v ) {
                        text += `${v}<br/>`;
                    });

                    $(`#error_index_page_${group_id}`).html(text);
                }
            }
            else
            {
                $(`#error_index_page_${group_id}`).html('');

                Toast.fire({
                    type : 'success',
                    icon: 'success',
                    title: '',
                    text: data.message,
                })
            }
        }
    });
});
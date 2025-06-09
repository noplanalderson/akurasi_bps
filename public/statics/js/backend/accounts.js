let tableCfg = {
    responsive: true,
    processing: true,
    serverSide: true,
    searchDelay: 1000,
    "lengthMenu": [[10,25,50,-1],[10,25,50,"All"]],
    "order": [[ 0, "asc" ]],
    'columnDefs': [
        {
            "targets": "no-sort",
            'orderable': false
        }
    ],
    dom: '<"left"l><"right"fr>Btip',
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Muat Ulang',
        className: 'btn btn-info btn-sm',
        action: function ( e, dt, node, config ) {
            dt.ajax.url(baseURI + 'akun').load();
        }
    }],
    'ajax': {
        'url': baseURI + 'akun',
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
            "name":"user_name",
            "data": function (row, type, val, meta) { 
                return `<strong>${row.user_name}</strong><br/>Group: ${row.group_name}`;
            },
            "defaultContent": "-"
        },
        {
            "name": "user_email",
            "data": "user_email",
            "title": "Email"
        },
        {  
            "name":"user_realname",
            "title": "Nama Pegawai",
            "data": "user_realname",
            "defaultContent": "-"
        },
        { 
            "name":"is_active",
            "title": "Status Akun",
            "data": function (row, type, val, meta) { 
                return row.is_active == 1 ? '<span class="badge badge-success">AKTIF</span>' : '<span class="badge badge-danger">NON AKTIF</span>';
            },
            "defaultContent": "-"
        },
        { 
            "name":"user_id",
            "defaultContent": "-",
            "data": function (row, type, val, meta) {
                let button = '';
                button += '<div class="dropdown">';
                button += '<button class="btn btn-primary dropdown-toggle" type="button" id="act-'+row.user_id+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>';
                button += '<div class="dropdown-menu" aria-labelledby="act-'+row.user_id+'"><h6 class="dropdown-header">Action</h6>';
                button += '<div class="dropdown-divider"></div>';
                if(menu.includes('akun/simpan')) {
                    button += "<button class='dropdown-item edit-user' data-toggle='modal' data-target='#userAccountModal' data-name='"+row.user_realname+"' data-id='"+row.user_id+"'><i class='fas fa-edit'></i> Ubah</button>";
                }
                if(menu.includes('akun/hapus')) {
                    button += "<button href='#' data-id='"+row.user_id+"' data-name='"+row.user_name+"' class='dropdown-item delete-user'><i class='fas fa-trash-alt'></i> Hapus</button>";
                }
                button += "</div></div>";

                return button;
            }
        }
    ],
    initComplete: function(row, type, val, meta) {
        $('input[name="csrf_token"]').val(type.token);
        $('meta[name="X-CSRF-TOKEN"]').attr('content', type.token);
        if(type.errors !== null) {
            Swal.fire("Kesalahan!", type.errors, "error");
        }
    }
}

let tblAccount = $('#tbl_accounts').DataTable(tableCfg);

if(menu.includes('akun/simpan')) {
    let button = '<button type="button" class="btn btn-sm add-user btn-primary" data-toggle="modal" data-target="#userAccountModal"><i class="fas fa-plus-square" aria-hidden="true"></i> Buat Akun</button>';
    $('#tbl_accounts_wrapper .btn-group').append(button);
};

let pwdRandom = pwdGenerator(10);

$(".show-btn-password").click(function() {
var showBtn = $('.show-btn-password');
var formPassword = $('#user_password').attr('type');

if(formPassword === "password"){
    showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
    $('.password').attr('class', 'svg-inline--fa fa-eye-slash password');
    $('#user_password').attr('type', 'text');
    }else{
    $('.password').attr('class', 'svg-inline--fa fa-eye password');
    $('#user_password').attr('type', 'password');
    showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
var showBtn = $('.show-btn-repeat');
var formPassword = $('#repeat_password').attr('type');

if(formPassword === "password"){
    showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
    $('.repeat').attr('class', 'svg-inline--fa fa-eye-slash repeat');
    $('#repeat_password').attr('type', 'text');
    }else{
    $('#repeat_password').attr('type', 'password');
    $('.repeat').attr('class', 'svg-inline--fa fa-eye repeat');
    showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

$('.add-user').on('click', function() {
    $('.modal-title').html('Buat Akun');
    $('.error_validation').text('');

    $('#user_id').val('');
    $('#action').val('add');
    $('#user_realname').val('');
    $('#user_name').val('');
    $('#user_email').val('');
    $('#group_id').val('');
    $('#user_password').val(pwdRandom).prop('required', true);
    $('#repeat_password').val(pwdRandom).prop('required', true);
    $('#is_active').val('0');
});

$("#tbl_accounts").on('click', '.edit-user', function() {
    $('.modal-title').html('Ubah Akun');
    $('.error_validation').text('');

    const user_id = $(this).data('id');
    let nama_pegawai = $(this).data('name');

    $.ajax({
        url: baseURI + 'akun',
        data: {
                user_id: user_id, 
                csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
        method: 'post',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});
        },
        success: function(response){
            let data = response.data;
            $('meta[name="X-CSRF-TOKEN"]').attr('content', response.token);
            $('input[name="csrf_token"]').val(response.token);

            if(response.status == true) {
                $('#user_id').val(user_id);
                $('#action').val('edit');
                $('#user_realname').val(data.user_realname);
                $('#user_name').val(data.user_name);
                $('#user_email').val(data.user_email);
                $('#group_id').val(data.group_id);
                $('#user_password').val('').prop('required', false);
                $('#repeat_password').val('').prop('required', false);
                $('#is_active').val((data.is_active == true ? 1 : 0));
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
});

$("#accountForm").on('submit', function(e) {
    e.preventDefault();
    $('#submitAccount').prop('disabled', true);
    $('#submitAccount').html('<i class="fas fa-spin fa-spinner"></i> Menyimpan...');

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
            var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ').';
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: 'Error: ',
                text: data,
            });

            $('#submitAccount').prop('disabled', false);
            $('#submitAccount').html('<i class="fas fa-save"></i> Simpan');
        },
        success: function(data) {

            $('input[name="csrf_token"]').val(data.csrf_token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.csrf_token);
            $('.error-validation').text('');
            if (data.status == true) {
                Swal.fire('Berhasil!', data.message, 'success');
                tblAccount.ajax.reload(null, false);

                $('#userAccountModal').modal('hide');
            } else {
                Swal.fire('Kesalahan!', data.message, 'error');

                let errors = data.errors.validations;

                if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                    $.each(errors, function( i, v ) {
                        $(`#error_${i}`).text(v);
                    });
                }
            }

            $('#submitAccount').prop('disabled', false);
            $('#submitAccount').html('<i class="fas fa-save"></i> Simpan');
        }
    });

    return false;
});

$("#tbl_accounts").on('click', '.delete-user', function(e){
    e.preventDefault();
  
      Swal.fire({
          title: 'Perhatian!',
          text: 'Anda yakin ingin menghapus akun?',
          showCancelButton: true,
          type: 'warning',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal',
          reverseButtons: true
      }).then((result) => {
  
          if (result.value == true) {
  
              Swal.fire({
                  title: 'Tunggu!',
                  text: 'Menghapus akun...',
                  showCancelButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  type: 'warning',
                  showConfirmButton: false,
                  showCancelButton: false,
                  reverseButtons: true
              })
  
              const user_id = $(this).data('id');
              const user_name = $(this).data('name');
              $.ajax({
                  url: baseURI + 'akun/hapus',
                  data: {
                          user_id: user_id, 
                          user_name: user_name,
                          csrf_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                  },
                  method: 'post',
                  dataType: 'json',
                  error: function(xhr, status, error) {
                      var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ')';
                      Toast.fire({type:'error', icon:'error', title: '', text: data});
                  },
                  success: function(data) {
                      $('input[name="csrf_token"]').val(data.csrf_token);
                      $('meta[name="X-CSRF-TOKEN"]').attr('content', data.csrf_token);
  
                      if (data.status == true) {
                          Swal.fire('Berhasil!', data.message, 'success');
                          tblAccount.ajax.reload(null, false);
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
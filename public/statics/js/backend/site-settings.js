$('#site_keywords').tagsInput({
    width: 'auto',
    defaultText:"Tambah keyword"
  });
  
$('#browseIconBtn').on('click', function (e) {
    e.preventDefault();

    CKFinder.modal( {
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function( finder ) {
            var output = document.getElementById( 'site_logo' );
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                $('#siteLogoPreview').attr('src', file.getUrl());
            } );

            finder.on( 'file:choose:resizedImage', function( evt ) {
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                $('#siteLogoPreview').attr('src', evt.data.resizedUrl);
            } );
        }
    } );    
})

$('#lapkeuBrowseBtn').on('click', function (e) {
    e.preventDefault();    
    CKFinder.modal( {
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function( finder ) {
            var output = document.getElementById( 'laporan_keuangan' );
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                $('#laporan_keuangan_preview').attr('src', file.getUrl());
            } );
        }
    } );    
})

$('#filePOKBtn').on('click', function (e) {
    e.preventDefault();    
    CKFinder.modal( {
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function( finder ) {
            var output = document.getElementById( 'file_pok' );
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                console.log(file.getUrl())
                $('#file_pok_preview').removeClass('d-none');
                $('#file_pok_preview').attr('src', file.getUrl());
            } );
        }
    } );    
})

$('#filePAKBtn').on('click', function (e) {
    e.preventDefault();    
    CKFinder.modal( {
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function( finder ) {
            var output = document.getElementById( 'file_pak' );
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                $('#file_pak_preview').removeClass('d-none');
                $('#file_pak_preview').attr('src', file.getUrl());
            } );
        }
    } );    
})

$('#filePeraturanBtn').on('click', function (e) {
    e.preventDefault();    
    CKFinder.modal( {
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function( finder ) {
            var output = document.getElementById( 'file_peraturan' );
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var newUrl = file.getUrl().replace(/^https?:\/\/[^\/]+\/uploads\/sites\//, '');
                output.value = newUrl;
                $('#file_peraturan_preview').removeClass('d-none');
                $('#file_peraturan_preview').attr('src', file.getUrl());
            } );
        }
    } );    
})

$("#siteForm").on('submit', function(e) {
    e.preventDefault();
    $('#btnSave').prop('disabled', true);
    $('#btnSave').html('<i class="fas fa-spin fa-spinner"></i> Menyimpan...');

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

            $('#btnSave').prop('disabled', false);
            $('#btnSave').html('<i class="fas fa-save"></i> Simpan');
        },
        success: function(data) {

            $('input[name="csrf_token"]').val(data.csrf_token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', data.csrf_token);
            $('.error-validation').text('');
            if (data.status == true) {
                Swal.fire('Berhasil!', data.message, 'success');
                setTimeout(function() {
                    window.location.reload();
                }, 2500);
            } else {
                Swal.fire('Gagal!', data.message, "error");

                let errors = data.errors.validations;

                if(typeof errors === 'object' &&  !Array.isArray(errors) && errors !== null) {
                    $.each(errors, function( i, v ) {
                        $(`#error_${i}`).text(v);
                    });
                }
            }

            $('#btnSave').prop('disabled', false);
            $('#btnSave').html('<i class="fas fa-save"></i> Simpan');
        }
    });

    return false;
});
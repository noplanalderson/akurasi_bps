let wz_class = ".wizard";

const wizard = new Wizard({
    wz_class: wz_class,
    "wz_nav_style": "dots",
    wz_ori: "vertical",
    "wz_button_style": ".btn .btn-sm mx-1",
    buttons: true,
    next: "Lanjut",
    prev: "Kembali",
    finish: '<i class="fas fa-save"></i> Simpan',
    navigation: "all"
});

wizard.init();

CKEDITOR.replace('org_vision', {
height: 200,
    removeButtons: 'NewPage,Preview,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Language,Flash,PageBreak,About,ShowBlocks,Save,Smiley,SpecialChar,PasteFromWord,PasteText,Styles,Maximize',
    allowedContent: 'p h1 h2 strong em;'
});


CKEDITOR.replace('org_profile', {
    height: 200,
    removeButtons: 'NewPage,Preview,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,CopyFormatting,RemoveFormat,Language,Flash,PageBreak,About,ShowBlocks,Save,Smiley,SpecialChar,PasteFromWord,PasteText,Styles,Maximize',
    filebrowserImageBrowseUrl: `${baseURIFront}statics/plugins/backend/ckeditor/ckfinder/ckfinder.html?uid=${uid}&gid=${gid}&access=${fm}&Type=Images`,
    filebrowserImageUploadUrl: `${baseURIFront}statics/plugins/backend/ckeditor/ckfinder/core/connector/php/connector.php?uid=${uid}&gid=${gid}&access=${fm}&command=QuickUpload&type=Images`,
    filebrowserWindowWidth : '1000',
    filebrowserWindowHeight : '700'
});

CKEDITOR.replace('org_missions', {
    height: 200,
    removeButtons: 'NewPage,Preview,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Language,Flash,PageBreak,About,ShowBlocks,Save,Smiley,SpecialChar,PasteFromWord,PasteText,Styles,Maximize',
    allowedContent: 'p h1 h2 strong em;'
});

document.getElementById("btn_reset").onclick = function () {
    wizard.reset();
  };
  
let $wz_doc = document.querySelector(wz_class);
  
$wz_doc.addEventListener("wz.form.submit", function (e) {
    for ( instance in CKEDITOR.instances )
      CKEDITOR.instances[instance].updateElement();
    
    $('.error_validation').text('');
    $.ajax({
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      timeout: 800000,
      url: `${baseURI}pengaturan-organisasi/simpan`,
      dataType: "json",
      error: function(xhr) {
        var data = 'Terjadi kesalahan! Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ').';
        Toast.fire({
            type : 'error',
            icon: 'error',
            title: 'Error: ',
            text: data,
        });
      },
      success: function (data) {
        $('input[name="csrf_token"]').val(data.token);
        $('meta[name="X-CSRF-TOKEN"]').attr("content", data.token);
  
        if (data.status == true) {
          Swal.fire('Berhasil!', data.message, "success");
          setTimeout(() => {
            window.location.reload();
          }, 2500);
        } else {
          Swal.fire('Gagal!', data.message, "error");
          let errors = data.errors;
          if (
            typeof errors === "object" &&
            !Array.isArray(errors) &&
            errors !== null
          ) {
            var general_error = `<div class="alert alert-danger text-light animate__animated animate__slideOutUp animate__delay-3s" role="alert"><ul>`;
            $.each(errors, function (i, v) {
              if(i == "validations") {
                general_error += "<li>Periksa kembali semua isian.</li>";
                if (
                  typeof v === "object" &&
                  !Array.isArray(v) &&
                  v !== null
                ) {
                  $.each(v, function (x, y) {
                    var index = x.replace(/[^a-zA-Z-_]/g, '_');
                    $('#error_'+index).text(y);
                  })
                }
              }
              else {
                if(v !== '')
                  general_error += "<li>"+v+"</li>";
              }
            });
            general_error += '</ul></div>';
            $("#general_alert").slideDown('slow');
            $('#general_alert').html(general_error);
            $("#general_alert").alert().delay(5000).slideUp('slow');
          }
        }
      },
    });
    return false;
})
(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
    
    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict

$('#formAccount').on('submit', function(e) {
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
          var data = 'Terjadi kesalahan. Mohon muat ulang halaman ' + '(status code: ' + xhr.status + ').';
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
          if (data.status == true) {
              Swal.fire('Berhasil!', data.message, 'success');
              $('#accountModal').modal('hide');
              $('#img-profile-navbar').attr('src', data.user_picture);
          } else {
              Swal.fire('Terjadi Kesalahan!', data.message, 'error');
          }

          $('#btnSave').prop('disabled', false);
          $('#btnSave').html('<i class="fas fa-save"></i> Simpan');
      }
  });

  return false;
});

$(".show-btn-password-acc").click(function() {
  var showBtn = $('.show-btn-password-acc');
  var formPassword = $('#user_password_acc').attr('type');
  
  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password-acc d-flex hide-btn');
      $('.password-acc').attr('class', 'svg-inline--fa fa-eye-slash password-acc');
      $('#user_password_acc').attr('type', 'text');
      }else{
      $('.password-acc').attr('class', 'svg-inline--fa fa-eye password-acc');
      $('#user_password_acc').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password-acc d-flex');
      }
  });
  
  $(".show-btn-repeat-acc").click(function() {
  var showBtn = $('.show-btn-repeat-acc');
  var formPassword = $('#repeat_password_acc').attr('type');
  
  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat-acc d-flex hide-btn');
      $('.repeat-acc').attr('class', 'svg-inline--fa fa-eye-slash repeat-acc');
      $('#repeat_password_acc').attr('type', 'text');
      }else{
      $('#repeat_password_acc').attr('type', 'password');
      $('.repeat-acc').attr('class', 'svg-inline--fa fa-eye repeat-acc');
      showBtn.attr('class', 'input-group-text show-btn-repeat-acc d-flex');
      }
  });
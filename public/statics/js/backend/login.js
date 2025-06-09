$(".show-btn-password").click(function() {
    var showBtn = $('.show-btn-password');
    var formPassword = $('#user_password').attr('type');
  
    if(formPassword === "password") {
        showBtn.attr('class', 'btn btn-outline-secondary show-btn-password hide-btn');
        $('.password').attr('class', 'svg-inline--fa fa-eye-slash password');
        $('#user_password').attr('type', 'text');
    }
    else
    {
        $('.password').attr('class', 'svg-inline--fa fa-eye password');
        $('#user_password').attr('type', 'password');
        showBtn.attr('class', 'btn btn-outline-secondary show-btn-password');
    }
});

$(document).ready(function () {
  const loginForm = $('#loginForm');
  const responseDiv = $('#response');
  const buttonSubmit = $('#btn_submit');

  loginForm.on('submit', function (e) {
    e.preventDefault();
    buttonSubmit.attr('disabled', 'disabled');
    buttonSubmit.html('<i class="fas fa-spin fa-spinner text-white"></i> <span class="text-white">Please wait...</span>');

    const formData = {
      csrf_token: $('#csrf_token').val(),
      user_name: $('#user_name').val(),
      user_password: $('#user_password').val()
    };

    $.ajax({
      url: `${baseURI}in`,
      method: 'POST',
      contentType: 'application/json',
      headers: {
        "X-Requested-With": "XMLHttpRequest"
      },
      data: JSON.stringify(formData),
      success: function (data) {
        let color = (data.status == 1) ? 'alert-success' : 'alert-danger';
        let alert = `<div class="alert ${color} text-light font-weight-bold animate__animated animate__slideOutUp animate__delay-3s" role="alert">${data.message}</div>`;

        responseDiv.slideDown('fast').html(alert);
        $('#csrf_token').val(data.csrf_token);

        if (data.status == 0) {
          buttonSubmit.removeAttr('disabled');
          buttonSubmit.html('<i class="fas fa-door-open"></i> Let Me In!');
        } else {
          const urlParams = new URLSearchParams(window.location.search);
          const next = urlParams.get('next');
          var url = (next == null) ? baseURI + data.index_page : baseURIFront + next;
          setTimeout(function () { window.location.href = url; }, 2000);
        }

        if (data.rule_msg !== '') {
          $('#user_name_error').fadeIn('fast').text(data.rule_msg["user_name"] || '');
          $('#user_password_error').fadeIn('fast').text(data.rule_msg["user_password"] || '');
        }

        responseDiv.alert().delay(5000).slideUp('fast');
        $('#user_name_error').alert().delay(5000).fadeOut();
        $('#user_password_error').alert().delay(5000).fadeOut();
      },
      error: function (xhr) {
        let alert = `<div class="alert alert-danger text-light font-weight-bold animate__animated animate__slideOutUp animate__delay-3s" role="alert">Error: ${xhr.statusText}</div>`;
        responseDiv.slideDown('fast').html(alert);
        responseDiv.alert().delay(5000).slideUp('fast');
        buttonSubmit.removeAttr('disabled');
        buttonSubmit.html('<i class="fas fa-door-open"></i> Let Me In!');
      }
    });
  });
});

// Ensure Particles.js library is loaded before calling particlesJS
if (typeof particlesJS !== 'undefined') {
  particlesJS("particles-js", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});
} else {
  console.error("Particles.js library is not loaded. Please include it in your HTML.");
}
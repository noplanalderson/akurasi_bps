"use strict";
// Set a cookie with a name, value, and optional options
function setCookie(name, value, daysToExpire) {
    var cookie = name + "=" + value;

    if (daysToExpire) {
        var expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + daysToExpire);
        cookie += "; expires=" + expirationDate.toUTCString();
    }

    document.cookie = cookie;
}

function isCookieSet(cookieName) {
    // Split the document.cookie string into individual cookies
    var cookies = document.cookie.split(';');

    // Loop through the cookies and check if the desired cookie is set
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim(); // Remove leading/trailing spaces
        if (cookie.indexOf(cookieName + '=') === 0) {
            // The cookie is set
            return true;
        }
    }

    // The cookie is not set
    return false;
}

function removeCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function bulanIndonesia(bln) {
    let bulan = new Date(bln);
    const options = { year: 'numeric', month: 'long' };
    return bulan.toLocaleDateString('id-ID', options); 
}

$('#logout').on('click', function(e){
  e.preventDefault();
  localStorage.clear();
  window.location.href = baseURI + 'logout';
})

const Toast = Swal.mixin({toast: true,position: 'bottom-right',showConfirmButton: false,timer: 5000});

String.prototype.toTitle = function() {
  var i, frags = this.split('-');
  for (i=0; i<frags.length; i++) {
    frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
  }
  return frags.join(' ');
}

String.prototype.slugify = function() {
  return this
      .toLowerCase() // Mengubah semua huruf menjadi huruf kecil
      .trim() // Menghapus spasi di awal dan akhir string
      .replace(/[\s_]+/g, '-') // Mengganti spasi dan underscore dengan tanda hubung
      .replace(/[^\w\-]+/g, '') // Menghapus karakter non-alfanumerik (selain tanda hubung)
      .replace(/\-\-+/g, '-') // Mengganti tanda hubung yang berulang dengan satu tanda hubung
      .replace(/^-+|-+$/g, ''); // Menghapus tanda hubung di awal atau akhir string
}

String.prototype.truncateStr = function(maxLength) {
    return this.length > maxLength ? `${this.substring(0, maxLength)}...` : this;
}

String.prototype.indonesianDate = function() {
    const date = new Date(this);
    if (isNaN(date)) return "Invalid Date";

    // Format date as "DD Month YYYY" in Indonesian
    const formattedDate = date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric"
    });

    // Check if time should be included
    if (this.includes(':')) {
        const time = date.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            hour12: false
        });
        return `${formattedDate} - ${time}`;
    }

    return formattedDate;
}

String.prototype.ucwords = function() {
    return this
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());
};

// Fungsi untuk memilih karakter acak dari suatu string
function getRandomChar(charset) {
    var randomIndex = Math.floor(Math.random() * charset.length);
    return charset.charAt(randomIndex);
}

// Fungsi untuk mengacak urutan karakter dalam string
function shuffleString(string) {
    var array = string.split('');
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array.join('');
}

function pwdGenerator(length) {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
    var password = "";
    
    password += getRandomChar("abcdefghijklmnopqrstuvwxyz");
    password += getRandomChar("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    password += getRandomChar("0123456789");
    password += getRandomChar("!@#$%^&*()_+-=[]{}|;:,.<>?");
    
    for (var i = 5; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        var randomChar = charset.charAt(randomIndex);
        password += randomChar;
    }
    
    password = shuffleString(password);
    
    return password;
}

function getCSRF()
{
    let csrfToken = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (!csrfToken) {
        csrfToken = $('input[name="csrf_token"]').val();
    }
    return csrfToken;
}

function renewCSRF(token)
{
    $('input[name="csrf_token"]').val(token);
    $('meta[name="X-CSRF-TOKEN"]').attr('content', token);
}
// Konstanta Pesan
const ERR_AJAX = 'Terjadi kesalahan tak terduga.';
const INVALID_REQ = 'Terjadi kesalahan.';
const DEL_WARNING_TEXT = 'Anda yakin ingin menghapus item ini?';
const SAVE_WARNING_TEXT = 'Data yang dimasukkan sudah benar?';
const DEL_WAIT = 'Menghapus item...';
const SUCCESS = 'Berhasil!';
const FAILED = 'Gagal!';
const confirmButtonText = 'Ya';
const cancelButtonText = 'Batal';
const dtLang = {
  "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
  "emptyTable": "Tidak ada data",
  "lengthMenu": "_MENU_ &nbsp; data/halaman",
  "search": "Cari: ",
  "zeroRecords": "Tidak ditemukan data yang cocok.",
  "paginate": {
    "previous": "<i class='fas fa-chevron-left'></i>",
    "next": "<i class='fas fa-chevron-right'></i>",
  },
};

let menu = JSON.parse(localStorage['menu_alutsista']);
let akses = localStorage['akses_alutsista'];
sessionStorage.setItem('uid', uid);
sessionStorage.setItem('gid', gid);
sessionStorage.setItem('fm', fm);
/*
 Copyright (c) 2007-2019, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or https://ckeditor.com/sales/license/ckfinder
 */

var config = {
    skin: 'neko',
    swatch: 'b',
};

// Set your configuration options below.

// Examples:
config.language = 'moono';
// config.skin = 'jquery-mobile';
// var urlParams = new URLSearchParams(window.location.search);
// var uid = urlParams.get('uid');
// var gid = urlParams.get('gid');
// var access = urlParams.get('access');

var uid = sessionStorage.getItem('uid');
var gid = sessionStorage.getItem('gid');
var access = sessionStorage.getItem('fm');

config.pass = 'uid,gid,access';
config.uid = uid;
config.gid = gid;
config.access = access;
CKFinder.define( config );

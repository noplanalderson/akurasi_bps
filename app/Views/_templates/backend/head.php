<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= UPLOAD_PATH . 'sites/'.$setting['site_logo']; ?>">
    <link rel="icon" type="image/png" href="<?= UPLOAD_PATH . 'sites/'.$setting['site_logo']; ?>">
    <title><?php echo @$title ?? 'Untitled'; ?></title>

    <!-- Custom fonts for this template-->
    <?php echo link_tag(PLUGINPATH . 'backend/fontawesome/css/all.min.css'); ?>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <?php echo link_tag(CSSPATH . 'backend/sb-admin-2.css'); ?>

    <?php echo link_tag(CSSPATH . 'backend/toast.css'); ?>

    <?php echo link_tag(PLUGINPATH . 'backend/swal/sweetalert2.min.css'); ?>

    <?php echo link_tag(CSSPATH . 'backend/custom.css'); ?>

    <?php echo (empty($css) ? '' : $css); ?>

    <?php echo csrf_meta(); ?>

    <meta name="X-USER-ID" content="<?php echo (empty(session()->get()) ? null : session()->get('uid')); ?>">
    <meta name="X-GROUP-ID" content="<?php echo (empty(session()->get()) ? null : session()->get('gid')); ?>">
    <meta name="X-FM-ACCESS" content='<?php echo (empty(session()->get('file_manager')) ? '' : base64Url_encode(json_encode(session()->get('file_manager')))); ?>'>
  
    <script <?php echo csp_script_nonce(); ?>>
        const uid = document.querySelector('meta[name="X-USER-ID"]').getAttribute('content');
        const gid = document.querySelector('meta[name="X-GROUP-ID"]').getAttribute('content');
        const fm = document.querySelector('meta[name="X-FM-ACCESS"]').getAttribute('content');
        let baseURI = '<?php echo base_url('blackhole/'); ?>';
        let baseURIFront = '<?php echo base_url(); ?>';
    </script>

</head>
    <script <?php echo csp_script_nonce(); ?>>
        const BTN_MENU = '<?php echo json_encode($btnmenu, TRUE); ?>';
        const AKSES_MODE = '<?php echo ($user['read_mode'] ?? null); ?>'
        var userJsonString = JSON.stringify(BTN_MENU);
        localStorage.setItem('menu_alutsista', userJsonString);
        localStorage.setItem('akses_alutsista', AKSES_MODE);
    </script>

    <!-- Bootstrap core JavaScript-->
    <?php echo script_tag(PLUGINPATH . 'backend/jquery/jquery.min.js'); ?>

    <?php echo script_tag(PLUGINPATH . 'backend/bootstrap/js/bootstrap.bundle.min.js'); ?>

    <!-- Core plugin JavaScript-->
    <?php echo script_tag(PLUGINPATH . 'backend/jquery-easing/jquery.easing.min.js'); ?>

    <?php echo script_tag(PLUGINPATH . 'backend/swal/sweetalert2.min.js'); ?>

    <?php echo script_tag(PLUGINPATH . 'backend/fontawesome/js/all.min.js'); ?>

    <?php echo script_tag(JSPATH . 'backend/toaster.js'); ?>

    <?php if(session()->has('uid')) : ?>
    <!-- Custom scripts for all pages-->
    <?php echo script_tag(JSPATH . 'backend/sb-admin-2.js'); ?>

    <?php echo script_tag(JSPATH . 'backend/function.js'); ?>
    <?php endif; ?>

    <?php echo $js ?? null; ?>

</body>

</html>
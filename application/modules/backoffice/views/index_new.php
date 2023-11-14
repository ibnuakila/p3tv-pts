<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= base_url() ?>assets/bootstrap-4.4.1/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/bootstrap-4.4.1/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/jquery-3.3.0.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/bootstrap.bundle.min.js"></script>
    <!--<script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/bootstrap.min.js"></script>-->
    
        <!--<script type="text/javascript" src="<?= base_url() ?>assets/js/tinymce/tinymce.min.js"></script>-->
        <?php
            echo put_footers_css();
            echo put_footers_js();
        ?>
</head>

<body>
    <!-- navigation -->
    <?php
        $this->load->view('header_new');
    ?>
    <!-- image slide carousel -->

    <!-- jumbotron -->

    <!-- welcome section -->

    <!-- content -->
    <div class="container mb-5 mt-5">
    <?php $this->load->view($view) ?>
    </div>
    <!-- three column section -->
</body>

</html>
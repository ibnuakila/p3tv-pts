

<html class="h-100">

<head>
    <link href="<?= base_url() ?>assets/bootstrap-4.4.1/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/bootstrap-4.4.1/css/style.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/jquery-3.3.0.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="h-100">
    <!-- navigation -->

    <!-- image slide -->

    <!-- jumbotron -->

    <!-- welcome section -->
    <div class="container h-100">


        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-lg-6 ">
                <div class="card bg-light">
                    <div class="card-header">Form Login PPPTS</div>
                    <div class="card-body ">
                        <form method="POST" action="<?php echo base_url()?>suplier/suplier/login">
                            <div class="form-group ">
                                <label for="exampleInputEmail1 ">User Name:</label>
                                <input type="text " name="userid" class="form-control " id="" aria-describedby="">
                                <small id="emailHelp " class="form-text text-muted ">Don't forget your user name.</small>
                            </div>
                            <div class="form-group ">
                                <label for="exampleInputPassword1 ">Password</label>
                                <input type="password" name="password" class="form-control " id="">
                                <small id="emailHelp " class="form-text text-muted ">Keep it hidden.</small>
                            </div>
                            <div class="form-group form-check ">
                                <input type="checkbox" class="form-check-input " id="exampleCheck1 ">
                                <label class="form-check-label " for="exampleCheck1 ">Remember Me</label>
                            </div>
                            <button type="submit " class="btn btn-primary ">Login</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <!-- three column section -->
</body>

</html>
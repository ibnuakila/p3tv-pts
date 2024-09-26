<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <script type="text/javascript" charset="UTF-8" src="<?= base_url()?>assets/js/jquery-1.9.1.js"></script>
        <script type="text/javascript">
            $("document").ready(function () {
                var _penyelenggara_id = "Y15431";
                var _token = "7bb9430ca19acd767eb2f59c3a7ae2cc";
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "http://silemkerma.ristekdikti.go.id/evapro/evaservice/getstatuspenyelenggara/",
                        data: {token: _token , penyelenggara_id: _penyelenggara_id},
                        success:
                                function (data) {
                                    if (data.length > 0) {
                                        alert("OK!");

                                        $("#lbl_status").html(data[0].status_usulan);
                                    } else {
                                        alert("Verifikasi Fail!");
                                    }
                                }
                    });
                    /*event.preventDefault();*/
            });
        </script>
    </head>
    <body>
        <h3>Usulan Perubahan Penyelenggara ID Y15431: <label id="lbl_status"></label></h3>
    </body>
</html>

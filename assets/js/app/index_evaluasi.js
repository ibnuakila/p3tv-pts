$("document").ready(function () {
    var url = $("#url").val();
    
        /*$("#tglawal").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglakhir").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglawal2").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglakhir2").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });*/

        $("#filter").change(function () {
            var x = document.getElementById("filter").selectedIndex;
            var y = document.getElementById("filter").options;
            //alert(y[x].value);
            if (y[x].value === 'semua') {
                $("#keyword").val("all");
            } else if (y[x].value === 'jns_usulan') {
                //$("#keyword").attr("class",'complete');
            }

        });

        $("#chevrondown").click(function () {
            $("#prosesverifikasi").animate({
                height: 'togle'
            });
        });

        $("#proses").click(function () {
            var x = confirm("Proses data terverifikasi ?");
            if (x) {
                var tgl1 = $("#tglawal2").val();
                var tgl2 = $("#tglakhir2").val();
                $.post( url+"evapro/registrasiprodi/procesverification",
                        {
                            tglawal: tgl1,
                            tglakhir: tgl2
                        },
                        function (data, status) {
                            alert(data + "\nStatus: " + status);
                            document.location.reload();
                        });
            }
        });

        /*$("#keyword").autocomplete({
            minLength: 3,
            source: function (req, add) {
                var text = $("select[name='filter'] option:selected").text();

                if (text === 'Jenis Usulan') {
                    $.ajax({
                        url: url+"evapro/registrasiprodi/autocompletejenisusulan/",
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success: function (data) {
                            if (data.response == 'true') {
                                add(data.message);
                            }
                        }
                    });
                }
            },
            select: function (event, ui) {
                var nama = ui.item.nama_usulan;
                $("#keyword").val(nama);
                //alert(kdeval);

            }
        });*/

    });
$("document").ready(function () {
        $("#tglawal").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglakhir").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });



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


        $(document.body).on("click", ".pleno", function ()
        {
            var id_reg = $(this).attr('id');
            var status = $("#" + id_reg).is(":checked");

            //alert(status);
            if (confirm("Anda ingin mengumumkan usulan ini ?")) {

                $.ajax
                        ({
                            type: "POST",
                            url: "<?php echo base_url() . 'backoffice/kelolaregistrasi/publishverifikasi/' ?>" + id_reg + "/" + status,
                            success: function (msg)
                            {
                                alert(msg);
                                //$("#"+noevaluasi).Attr("checked","true");
                            }
                        });

            } else {
                if (status) {
                    $("#" + noevaluasi).removeAttr("checked");
                } else {
                    $("#" + noevaluasi).prop("checked", true);
                }
            }
        });



    });
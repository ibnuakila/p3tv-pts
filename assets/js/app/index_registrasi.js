"use strict";
$(document).ready(function () {
    $(document.body).on("click", ".pleno", function ()
    {
        var id_reg = $(this).attr('id');
        var status = $("#" + id_reg).is(":checked");
        var url = $("#url").val();
        //alert(status);
        if (confirm("Anda ingin mengumumkan usulan ini ?")) {

            $.ajax
                    ({
                        type: "POST",
                        url: url+"backoffice/kelolaregistrasi/publishverifikasi/",
                        data: {id_reg:id_reg, status:status},
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
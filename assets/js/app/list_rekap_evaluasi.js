"use strict";
$(document).ready(function () {
    let url = $("#url").val();
    
    $(document.body).on("click", ".pleno", function ()
    {
        var id_reg = $(this).attr('id');
        var status = $("#" + id_reg).is(":checked");
        
        //alert(status);
        if (confirm("Anda ingin mengumumkan usulan ini ?")) {

            $.ajax
                    ({
                        type: "POST",
                        url: url+"backoffice/kelolarekapitulasi/publish/",
                        data: {id_reg:id_reg, status:status},
                        success: function (msg)
                        {
                            alert(msg);
                            //$("#"+noevaluasi).Attr("checked","true");
                        }
                    });

        } else {
            if (status) {
                $("#" + id_reg).removeAttr("checked");
            } else {
                $("#" + id_reg).prop("checked", true);
            }
        }
    });
    
    $(document.body).on("click", ".update-status", function ()
    {
        var id_rekap = $(this).attr('id');
        alert(id_rekap);
        $("#id_rekapitulasi").val(id_rekap);
        
    });
    
    $(document.body).on("click", "#btn-save", function () {
        //alert("you clicked me!");
        var idStatusRegistrasi = $("#id_status_registrasi").val();
        var idRekapitulasi = $("#id_rekapitulasi").val();
        
        $.ajax({
            url: url + 'backoffice/kelolarekapitulasi/updatestatus/',
            dataType: 'json',
            type: 'POST',
            data: {id_status_registrasi: idStatusRegistrasi, id_rekapitulasi: idRekapitulasi},
            success: function (response) {
                alert(response[0].message);
                document.location.reload();
            }
        });
    });
});
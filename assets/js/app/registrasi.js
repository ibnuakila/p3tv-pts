"use strict";
$(document).ready(function () {
    //tinymce.init({
        //selector: 'textarea', // change this value according to your HTML
        //plugins: 'a_tinymce_plugin',
        //a_plugin_option: true,
        //a_configuration_option: 400
    //});
    tinymce.init({
      selector: 'textarea',
      //plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      /*tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))*/
    });
    var url = $("#url").val();
    $("#approved").click(function (event) {

        var _keterangan = tinyMCE.activeEditor.getContent();
        var _id = $("#idregistrasi").val();
        var status = '2';
        //alert("Id" + _id);
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url+"backoffice/kelolaregistrasi/verifikasi",
            data: {id: _id, status: status, keterangan: _keterangan},
            success:
                    function (data) {
                        if (data[0].message === "true") {
                            alert("Verifikasi OK!");
                            $("#approved").attr('disabled', 'disabled');
                            $("#disapproved").removeAttr('disabled');
                            $("#status_ver").val(data[0].status);
                        } else {
                            alert("Verifikasi Fail!");
                        }
                    }
        });

    });

    $("#disapproved").click(function (event) {
        var _keterangan = tinyMCE.activeEditor.getContent(); //$("textarea#keterangan").val();
        var _id = $("#idregistrasi").val();
        var status = '6';
        //alert("Id" + _id);
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url+"backoffice/kelolaregistrasi/verifikasi",
            data: {id: _id, status: status, keterangan: _keterangan},
            success:
                    function (data) {
                        if (data[0].message === "true") {
                            alert("Verifikasi OK!");
                            $("#disapproved").attr('disabled', 'disabled');
                            $("#approved").removeAttr('disabled');
                            $("#status_ver").val(data[0].status);
                        } else {
                            alert("Verifikasi Fail!");
                        }
                    }
        });

    });

    $(document.body).on("click", ".view", function ()
    {
        var id = $(this).attr("id");
        var src = $(this).attr("src");
        //alert(src);
        $("#pdfview").attr("src", src);
    });

    $(document.body).on("click", ".tersedia", function ()
    {
        var id = $(this).attr("id");
        //alert(id);
        var status = $("#" + id).is(":checked");
        $.ajax
                ({
                    type: "POST",
                    url: "<?php echo base_url() . 'backoffice/kelolaregistrasi/updatedocument/' ?>" + id + "/" + status,
                    success: function (msg)
                    {
                        //alert(msg); 
                        $("#lbl_" + id).text(msg);
                    }
                });

    });
    
    $("#submit-form").click(function(event){        
        event.preventDefault();
        var form = $("#form-dana").serializeArray();
        //var _id = $("#id_dana").val();
        var _id_reg = $("#idregistrasi").val();
        var _kdpti = $("#kdpti").val();
        var _nmpti = $("#nmpti").val();
        //form.push({name:'id', value:_id});
        form.push({name:'id_registrasi', value:_id_reg});
        form.push({name:'kdpti', value:_kdpti});
        form.push({name:'nmpti', value:_nmpti});
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url+"backoffice/keloladanapendamping/save",
            data: form,
            success:
                    function (result) {
                        if (result.response === true) {
                            alert("Data tersimpan");
                            $("#exampleModalLive").modal("hide");
                            location.reload();
                        } else {
                            alert("Simpan gagal!");
                        }
                    }
        });
    });
    $(document.body).on("click", ".edit-dana", function ()
    {
        var id = $(this).attr("id");
        //alert(id);
        //var status = $("#" + id).is(":checked");
        $.ajax
                ({
                    type: "POST",
                    url: url+"backoffice/keloladanapendamping/edit/",
                    dataType: "json",
                    data: {id:id},
                    success: function (result)
                    {
                        if(result.response == true){
                            console.log(result.data);
                            $("#id-dana").val(result.data.id);
                            $("#nama-kegiatan").val(result.data.nama_kegiatan);
                            $("#keuangan").val(result.data.keuangan);
                            $("#vol-output").val(result.data.vol_output);
                            $("#output-kegiatan").val(result.data.output_kegiatan);
                            $("#realisasi-keuangan").val(result.data.real_keuangan);
                            $("#real-vol-output").val(result.data.real_vol_output);
                            $("#exampleModalLive").modal("show");
                        }else{
                            alert("Tidak ada data!");
                        }
                    }
                });

    });
    $(document.body).on("click", ".delete-dana", function ()
    {
        var id = $(this).attr("id");
        if(confirm("Apakah yakin dihapus?")){
            $.ajax
                ({
                    type: "POST",
                    url: url+"backoffice/keloladanapendamping/remove/",
                    dataType: "json",
                    data: {id:id},
                    success: function (result)
                    {
                        if(result.response == true){
                            alert("Delete berhasil");
                            location.reload();
                        }else{
                            alert("Delete gagal!");
                        }
                    }
                });
            }

    });
    /*let submitBtn = document.getElementById("submit-form");
    submitBtn.addEventListener("click", function(e){
        console.log("oke");
        alert("Saved");
        e.preventDefault();
    });*/
       
    function showMessage(input, message, type) {
	// get the <small> element and set the message
	const msg = input.parentNode.querySelector("#");
	msg.innerText = message;
	// update the class for the input
	input.className = type ? "success" : "error";
	return type;
    }
});
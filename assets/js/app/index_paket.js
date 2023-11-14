$("document").ready(function () {
        var url = $("#url").val();
        $(function () {
            $("#hide_form").hide();
        });
        
        $("#supplier").autocomplete({
            minLength: 3,
            source: function (req, add) {
                $.ajax({
                    url: url + "backoffice/kelolapaket/autocompletesupplier/",
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success: function (data) {
                        if (data.response === 'true') {
                            add(data.message);
                        }
                    }
                });
            },
            select: function (event, ui) {
                var kdeval = ui.item.kode;
                $("#id_supplier").val(kdeval);
                //alert(kdeval);

            }
        });

        /*$("#perguruan_tinggi").autocomplete({
            minLength: 3,
            source: function (req, add) {
                $.ajax({
                    url: '<?php echo base_url() . 'backoffice/kelolapaket/autocompletept/'; ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success: function (data) {
                        if (data.response === 'true') {
                            add(data.message);
                        }
                    }
                });
            },
            select: function (event, ui) {
                var idreg = ui.item.kode;
                $("#id_registrasi").val(idreg);
                //alert(kdeval);
                /*$.ajax({
                    url: '<?php echo base_url() . 'backoffice/kelolapaket/autocompletebarang/'; ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {idregistrasi:idreg},
                    success: function (result) {
                        if (result.response === 'true') {
                            for(var x=0;x<result['message'].length;x++){
                                    $('#nama_barang').empty(); // kosongkan dahulu combobox yang ingin diisi datanya
                                     $('#nama_barang').append('<option>-Pilih-</option>'); // buat pilihan awal pada combobox
                                     for(var x=0;x<result['message'].length;x++){
                                            // berikut adalah cara singkat untuk menambahkan element option pada tag <select>
                                            $('#nama_barang').append($('<option></option>').val(result['message'][x].value).text(result['message'][x].label));
                                     }

                            }
                        }
                    }
                });
            }
        });

        $("#_nama_barang").autocomplete({
            minLength: 3,
            source: function (req, add) {
                $.ajax({
                    url: '<?php echo base_url() . 'backoffice/kelolapaket/autocompletebarang/'; ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success: function (data) {
                        if (data.response === 'true') {
                            add(data.message);
                        }
                    }
                });
            },
            select: function (event, ui) {
                var kdeval = ui.item.kode;
                $("#id_item").val(kdeval);
                //alert(kdeval);

            }
        });*/

        $('#save_paket').click(function () {
            var formData = new FormData($('#form_paket')[0]);
            formData.append('flaginsert',$("#flaginsert").val());
            var _url = $("#form_paket").attr('action');
            //alert(_url);
            $.ajax({
                url: _url, //Server script to process data
                type: 'POST', 
                dataType: "JSON",
                /*xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        //myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },*/
                //Ajax events
                //beforeSend: beforeSendHandler,
                success: function (result) {
                    //alert(result.response);
                    if (result.response === "true") {
                        alert("Update sucessfull!");
                        $("#flaginsert").val(result.flaginsert);
                        $("#id_paket").val(result.id_paket);

                    } else if (result.response === "false") {
                        alert(result.error);
                    } else {
                        alert("Update fail!");
                    }
                },
                //error: errorHandler,
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#upload_detail').click(function () {
            var formData = new FormData($('#form_detail')[0]);
            formData.append('id_paket',$("#id_paket").val());
            formData.append('no_kontrak', $("#no_kontrak").val());
            formData.append('kontrak_adendum', $("#kontrak_adendum").val());
            //formData.append('id_item', $("select[id='nama_barang'] option:selected").val());*/
            //var id_pak = $("#id_paket").val();
            //var id_reg = $("#id_registrasi").val();
            var _url = $("#form_detail").attr('action');
            //alert(_url);
            $.ajax({
                url: _url, //Server script to process data
                type: 'POST', dataType: "JSON",
                /*xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        //myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },*/
                //Ajax events
                //beforeSend: beforeSendHandler,
                success: function (result) {
                    //alert(result.response);
                    if (result.response === "true") {
                        alert("Update sucessfull!");
                        //$("#flag_detail").val(result.flaginsert);
                        //$("#id_detail_paket").val(result.id_detail_paket);
                        $("#id_item").val(result.id_item);
                        $("#tbl_detail tbody").remove();
                        $("#tbl_detail").append("<tbody></tbody>");
                        for(var x=0;x<result['record_detail'].length;x++){
                            $("#tbl_detail tbody").append(
                                    "<tr>" + 
                                    "<td>" + x + "</td>" +
                                    "<td>" + result['record_detail'][x].no_kontrak + "</td>" +
                                    "<td>" + result['record_detail'][x].adendum_ke + "</td>" +
                                    "<td>" + result['record_detail'][x].id_registrasi + "</td>" +
                                    "<td>" + result['record_detail'][x].kdpti + "</td>" +
                                    "<td>" + result['record_detail'][x].nama_barang + "</td>" + 
                                    "<td>" + result['record_detail'][x].merk + "</td>" + 
                                    "<td>" + result['record_detail'][x].type + "</td>" + 
                                    "<td>" + result['record_detail'][x].volume + "</td>" +                                      
                                    "<td>" + result['record_detail'][x].hps + "</td>" + 
                                    "<td>" + result['record_detail'][x].total + "</td>" + 
                                    /*"<td>" + "<a href='#' class='remove_rl' id='" + result['record_detail'][x].id_detail_paket + "'>" +
                                    "<i class='glyphicon glyphicon-remove'></i></a></td>" +*/
                                    "</tr>");

                        }
                    } else if (result.response === "false") {
                        alert(result.error);
                    } else {
                        alert("Update fail!");
                    }
                },
                //error: errorHandler,
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        });


        $("#tgl_kontrak").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tgl_akhir_kontrak").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });


        $("a.tab").click(function () {
            // switch all tabs off  

            $(".active").removeClass("active");
            // switch this tab on  
            $(this).addClass("active");
            // slide all elements with the class 'content' up  
            $(".tab_content").hide(); //slideUp;  
            //var maxY = window.scrollMaxY;
            //window.scrollByPages(1);
            // Now figure out what the 'title' attribute value is and find the element with that id.  Then slide that down.  
            var content_show = $(this).attr("title");
            $("#" + content_show).show();
            $("#" + content_show).focus();
            return false;
        });

        $('#myTab a:first').tab('show');
    });


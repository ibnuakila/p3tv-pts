$("document").ready(function () {
    let url = $("#base_url").val();
    
    $("#waktu-laksana").datepicker({
		dateFormat:"yy-mm-dd",
                changeYear:true
    });
    
    $("#btn-save").click(function (event) {
        var form = $("#my-form")[0];
        var data = new FormData(form);
        var id_registrasi = $("#id_registrasi").val();
        data.append('id_registrasi', id_registrasi);
        //console.log(form);
        event.preventDefault();
        $.ajax({
            url: url + 'backoffice/kelolaluaran/save/',
            dataType: "json",
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                //if(response.response == 'true'){
                console.log(data);
                    alert("Saved");
                    $("#tbl-luaran tbody").empty();
                    for (var i = 0; i < data.result.length; i++) {
                            $('#tbl-luaran tbody').append('<tr>');
                            $('#tbl-luaran tbody').append('<td>' + i + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].nama_prodi + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].ruang_lingkup + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].program_pengembangan + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].bentuk_luaran + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].jumlah_luaran + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].tahun + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].waktu_pelaksanaan + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].biaya + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].target_iku + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + data.result[i].keterangan + '</td>');
                            $('#tbl-luaran tbody').append('<td>' + 
                                    '<a href="#" class="edit" id="' + data.result[i].id + '"><i class="fa fa-edit"></i></a>' +
                                    '<a href="#" class="delete" id="' + data.result[i].id + '"><i class="fa fa-minus-circle"></i></a>' +
                                    '</td></tr>');
                        }
                //}
                location.reload();
                //console.log(response.result);
            },
            /*error: function (e) {
                console.log(e);
            }*/
        });
    });
    
    $(document.body).on("click", ".delete", function ()
    {
        var id = $(this).attr("id");
        if (confirm("Apakah yakin dihapus?")) {
            $.ajax
                    ({
                        type: "POST",
                        url: url + "backoffice/kelolaluaran/remove/",
                        dataType: "json",
                        data: {id: id},
                        success: function (result)
                        {
                            if (result.response == true) {
                                alert("Delete berhasil");
                                location.reload();
                            } else {
                                alert("Delete gagal!");
                            }
                        }
                    });
        }

    });
    
    $(document.body).on("click", ".edit", function ()
    {
        var id = $(this).attr("id");
        //alert(id);
        //var status = $("#" + id).is(":checked");
        $.ajax
                ({
                    type: "POST",
                    url: url + "backoffice/kelolaluaran/edit/",
                    dataType: "json",
                    data: {id: id},
                    success: function (result)
                    {
                        if (result.response == true) {
                            console.log(result.data);
                            $("#id").val(result.data.id);
                            $("#id-registrasi").val(result.data.id_registrasi);
                            $("#nama-prodi").val(result.data.nama_prodi);
                            $("#ruang-lingkup").val(result.data.ruang_lingkup);
                            $("#program").val(result.data.program_pengembangan);
                            $("#bentuk-luaran").val(result.data.bentuk_luaran);
                            $("#jumlah-luaran").val(result.data.jumlah_luaran);
                            $("#tahun").val(result.data.tahun);
                            $("#waktu-laksana").val(result.data.waktu_pelaksanaan);
                            $("#biaya").val(result.data.biaya);
                            $("#target-iku").val(result.data.target_iku);
                            $("#keterangan").val(result.data.keterangan);
                            $("#form-luaran").modal("show");
                        } else {
                            alert("Tidak ada data!");
                        }
                    }
                });

    });
});
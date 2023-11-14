
$("document").ready(function () {
        let url = $("#url").val();

        $("#kategori").change(function () {
            var x = document.getElementById("kategori").selectedIndex;
            var y = document.getElementById("kategori").options;
            //alert(y[x].value);
            $.ajax({
                url: url+'backoffice/kelolabarang/getsubkategori/',
                dataType: 'json',
                type: 'POST',
                data: {kd_kategori: y[x].value},
                success: function (response) {
                    if (response.length > 0) {
                        //alert("There is "+response.length+" data!");
                        $("#sub-kategori").empty();
                        $("#sub-kategori").append("<option>~Pilih~</option>");
                        for (var i = 0; i < response.length; i++) {
                            $('#sub-kategori').append($('<option></option>').val(
                                    response[i].value).text(response[i].label)
                                    );
                        }
                    }
                }
            });

        });

        $("#sub-kategori").change(function () {
            var x = document.getElementById("sub-kategori").selectedIndex;
            var y = document.getElementById("sub-kategori").options;
            
            var p = document.getElementById("kategori").selectedIndex;
            var q = document.getElementById("kategori").options;
            $.ajax({
                url: url + 'backoffice/kelolabarang/getitembarang/',
                type: 'GET',
                data: {kd_kategori: q[p].value, sub_kategori: y[x].value},
                success: function (response) {
                    $("#item-barang").html("");
                    $("#item-barang").append(response);
                }
            });
        });

        $("#txt-keyword").keyup(function () {
            var x = document.getElementById("sub-kategori").selectedIndex;
            var y = document.getElementById("sub-kategori").options;
            
            var p = document.getElementById("kategori").selectedIndex;
            var q = document.getElementById("kategori").options;
            
            var len = $(this).val().length;
            var key = $(this).val();
            if (len >= 3) {
                $.ajax({
                    url: url + 'backoffice/kelolabarang/getitembarang/',
                    type: 'GET',
                    data: {kd_kategori: q[p].value,sub_kategori: y[x].value, keyword:key},
                    success: function (response) {
                        $("#item-barang").html("");
                        $("#item-barang").append(response);
                    }
                });
            }
        });

        
        $(document.body).on("click", "#btn-save", function () {
            //alert("you clicked me!");
            var idItem = $("#id-item").val();
            var idRegistrasi = $("#id-registrasi").val();
            var qty = $("#txt-qty").val();
            var flag = $("#flag").val();
            $.ajax({
                url: url + 'backoffice/kelolabarang/save/',
                dataType: 'json',
                type: 'POST',
                data: {id_item: idItem, id_registrasi: idRegistrasi, qty: qty, flag: flag},
                success: function (response) {
                    alert(response[0].message);
                    $("#lbl-total").text("Rp. " + response[0].grand_total);
                    //$("#cart").append("<i class='fa fa-briefcase'></i>");
                    $("#cart").text(" Barang (" + response[0].count + ")");
                    $("#btn-save").attr("disabled", "disabled");
                }
            });
        });
        
        $(document.body).on("click", "#btn-save-gedung", function () {
            //alert("you clicked me!");
            var idItem = $("#id-item").val();
            var idRegistrasi = $("#id-registrasi").val();
            var biaya = $("#txt-biaya").val();
            var qty = $("#txt-qty").val();
            var flag = $("#flag").val();
            $.ajax({
                url: url + 'backoffice/kelolabarang/savegedung/',
                dataType: 'json',
                type: 'POST',
                data: {id_item: idItem, id_registrasi: idRegistrasi, qty: qty, flag: flag, biaya: biaya},
                success: function (response) {
                    alert(response[0].message);
                    $("#lbl-total").text("Rp. " + response[0].grand_total);
                    //$("#cart").append("<i class='fa fa-briefcase'></i>");
                    $("#cart").text(" Cart (" + response[0].count + ")");
                    $("#btn-save").attr("disabled", "disabled");
                }
            });
        });
        
        $(document.body).on("click", ".detail-barang", function ()
        {
            var idItem = $(this).attr('id');
            //alert("id item" + idItem);
            $.ajax({
                url: url + 'backoffice/kelolabarang/getbarang/',
                dataType: 'json',
                type: 'POST',
                data: {id_item: idItem},
                success: function (response) {
                    $("#title-barang").text(response[0].barang + " (" + response[0].no_barang + ")");
                    $("#img-barang").attr("src", response[0].image);
                    $("#lbl-harga").text("Rp. " + response[0].harga);
                    $("#text-spesifikasi").text(response[0].spesifikasi);
                    $("#id-item").val(response[0].id_item);
                    $("#btn-save").removeAttr("disabled");
                }
            });
        });
    });

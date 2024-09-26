$("document").ready(function () {
        var url = $("#base_url").val();
        
        $(document.body).on("click", ".remove", function (event) {
            
            var id = $(this).attr("id");
            var question = confirm("Yakin dihapus");
            if(question){
                
                $.ajax({
                    url: url + 'backoffice/kelolabarang/remove/',
                    dataType: 'json',
                    type: 'POST',
                    data: {id: id},
                    success: function (response) {
                        alert(response[0].message);
                        location.reload(true);
                    }
                });
            }
            event.preventDefault();
        });
        
        
        
        $(document.body).on("click", ".edit", function ()
        {
            var idItem = $(this).attr('id');
            //alert("id item" + idItem);
            $.ajax({
                url: url + 'backoffice/kelolabarang/getbaranghibah/',
                dataType: 'json',
                type: 'POST',
                data: {id: idItem},
                success: function (response) {
                    $("#title-barang").text(response[0].barang + " (" + response[0].no_barang + ")");
                    $("#img-barang").attr("src", response[0].image);
                    $("#lbl-harga").text("Rp. " + response[0].harga_satuan);
                    $("#lbl-sub-total").text("Sub Total: Rp. " + response[0].sub_total);
                    $("#txt-qty").val(response[0].qty);
                    $("#text-spesifikasi").text(response[0].spesifikasi);
                    $("#id-item").val(response[0].id_item);
                    $("#id").val(response[0].id);
                    $("#id-registrasi").val(response[0].id_registrasi);
                }
            });
        });
        
        $(document.body).on("click", "#btn-save", function () {
            //alert("you clicked me!");
            var idItem = $("#id-item").val();
            var idRegistrasi = $("#id-registrasi").val();
            var qty = $("#txt-qty").val();
            var flag = $("#flag").val();
            var id = $("#id").val();
            $.ajax({
                url: url + 'backoffice/kelolabarang/save/',
                dataType: 'json',
                type: 'POST',
                data: {id: id, id_item: idItem, id_registrasi: idRegistrasi, qty: qty, flag: flag},
                success: function (response) {
                    alert(response[0].message);
                    $("#lbl-total").text("Rp. " + response[0].grand_total);
                    $("#lbl-sub-total").text("Sub Total: Rp. " + response[0].sub_total);
                    $("#cart").text(" Cart (" + response[0].count + ")");
                    //$("#btn-save").attr("disabled", "disabled");
                }
            });
            
        });
        
        $(document.body).on("click", "#btn-selesai", function(){
            var question = confirm("Anda ingin menyelesaikan input barang");
            var idRegistrasi = $("#id_registrasi").val();
            if(question){
                $.ajax({
                    url: url + 'backoffice/kelolabarang/finish/',
                    dataType: 'json',
                    type: 'POST',
                    data: {id_registrasi: idRegistrasi},
                    success: function (response) {
                        alert(response.message);
                        if(response.response==1){
                            $("#btn-selesai").attr("disabled", "disabled");
                        }
                    }
                });
            }
        });
        
        $('#modal-detail').on('hidden.bs.modal', function (e) {
            location.reload(true);
        })
    });
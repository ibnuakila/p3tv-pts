$("document").ready(function(){
    var url = $("#url").val();
    $("#evaluator").autocomplete({
            minLength: 3,
            source: function(req, add){
                $.ajax({
                    url: url+"backoffice/kelolaevaluator/autocomplete/",
                    dataType: 'json',
                    type: 'POST',
                    data: req,
                    success: function(data){
                        if(data.response =='true'){
                           add(data.message);
                        }
                    }
                });
            },
            select: function(event, ui){
                var kdeval = ui.item.kode;
                $("#idevaluator").val(kdeval);
                //alert(kdeval);
                
        }
    });
    
    $("#jns_evaluasi").change(function(){
        var x = document.getElementById("jns_evaluasi").selectedIndex;
        var y = document.getElementById("jns_evaluasi").options;
        //alert(y[x].value);
        if(y[x].value === "1"){
            $("#type").empty();
            $("#type").append("<option>~Pilih~</option>").val("-");
            $("#type").append("<option value='1'>Pertama</option>").val("1");
            $("#type").append("<option value='2'>Kedua</option>").val("2");            
        }else if(y[x].value === "2"){
            $("#type").empty();
            $("#type").append("<option>~Pilih~</option>").val("-");
            $("#type").append("<option value='1'>Reviewer</option>").val("1");
            $("#type").append("<option value='2'>Tim Teknis</option>").val("2");
        }
    });
    
    $("#tglpenugasan").datepicker({
		dateFormat:"yy-mm-dd",
                changeYear:true
    });
    
    $("#tglselesai").datepicker({
		dateFormat:"yy-mm-dd",
                changeYear:true
    });
});
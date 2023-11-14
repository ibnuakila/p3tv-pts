<div class="md-card"><i class="glyphicon glyphicon-tag"></i>
<h2></h2>
    <div class="panel panel-default">
        <div class="panel-heading">Create Form</div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="<?=  base_url().'backoffice/kelolapaket/getform/'?>" accept-charset="utf-8" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Kode PT</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="kdpti" id="kdpti"/> 
                          
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                              
                              <button type="submit" name="save" value="save" class="btn btn-success btn-sm">Get</button>
                        </div>
                    </div>
               
            </form>
        </div>
    </div>
</div>
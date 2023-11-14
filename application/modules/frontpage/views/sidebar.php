<div class="panel panel-default bg-panel">
        <div class="panel-heading">Member Login</div>
        <div class="panel-body">
          <form role="form" action="<?=base_url().'index.php/ejournal/ejournal/dologin'?>" method="POST">
           
            <div class="form-group">
                
              <label for="exampleInputEmail1">User Account</label>
              <div class="input-group">
                <div class="input-group-addon input-sm"><i class="glyphicon glyphicon-envelope"></i></div>
                <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Enter email">
              </div>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <div class="input-group">
                  <div class="input-group-addon input-sm"><i class="glyphicon glyphicon-cog"></i></div>
              <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
              </div>
            </div>                      
                
            <button type="submit" class="btn btn-primary btn-sm">Login</button>
            
          </form>
        </div>
    </div>
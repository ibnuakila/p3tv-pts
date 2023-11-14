<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">

                    <div class="panel-heading">Log In Vendor</div>
                    <div class="panel-body">

                        <!-- login form -->  
                        <form class="form-horizontal" name="login" method="post" action="<?php echo base_url('vendor/vendor/login') ?>">
                            <fieldset>
                                <legend></legend>
                                <div > <p style="color:red"> <?php if(isset($message)){ echo $message;} ?></p>

                                </div>
                                <div class="form-group ">
                                    <label for="inputuser" class="col-lg-3 control-label">User&nbspID</label>

                                    <div class="col-lg-8">
                                        <input type="text" class="form-control input-sm" name="userid" placeholder="User ID"
                                               required
                                               >
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword" class="col-lg-3 control-label">Password</label>

                                    <div class="col-lg-8">
                                        <input type="password" class="form-control input-sm" name="password" 
                                               required
                                               placeholder="Password">
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <div class="col-lg-11" align="right">
                                        <button class="btn btn-sm btn-default">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"> Log In </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</div>
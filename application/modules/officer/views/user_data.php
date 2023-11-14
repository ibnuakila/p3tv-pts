<h2 class="page-header">Data User</h2>

<div class="card col-sm-12">
    <div class="card-header text-justify">
        
        <i class="fa fa-list"></i>
    </div>
    <div class="card-body">
        <div class="row-fluid">
            <div class="table-responsive">
                <p>
                    <a href="<?= base_url() ?>/officer/officer/add" class="btn btn-sm btn-primary">Add New</a>
                </p>
                <table class="table table-condensed table-striped table-bordered">
                    <thead class="">
                        <form method="post" action="<?= base_url() ?>officer/officer/data_user/">
                        <tr class="" >
                            <th>No</th>
                            <th class="text-center">User ID</th> 
                            <th class="text-center">User Name</th> 
                            <th class="text-center">Email</th>                 
                            <th class="text-center">User Type</th>
                            <th class="text-center">Action</th>
                            
                        </tr>
                        <tr class="bg-light">                   
                            <th>Filter:</th>
                            <th><input type="text" id="keyword" name="user_id" class="form-control form-control-sm"></th>
                            <th><input type="text" id="keyword" name="user_name" class="form-control form-control-sm"></th>
                            <th><input type="text" id="keyword" name="email" class="form-control form-control-sm"></th>
                            <th><input type="text" id="keyword" name="user_ty[e" class="form-control form-control-sm"></th>
                            <th>
                                <button type="submit" name="find" class="btn btn-primary btn-sm" value="find">
                                    <i class="fa fa-search"></i>
                                </button>
                            </th>
                    
                        </tr>
                        </form>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($result)){
                            $segment = $this->uri->segment(4, 0);
                            $i = $segment + 1;
                            if ($i == '') {
                                $i = 1;
                            }
                            
                            foreach ($result->result() as $row){?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row->user_id ?></td>
                            <td><?= $row->user_name ?></td>                            
                            <td><?= $row->email ?></td>
                            <td><?= $row->user_type ?></td>
                            <td>
                                <?php
                                if($row->id_evaluator !== null){
                                ?>
                                <a href="<?= base_url() . 'backoffice/backoffice/loginasuser/' . $row->user_id ?>" title="Login As">
                                    <i class="fa fa-key"></i> 
                                </a>
                                <a href="<?= base_url() . 'officer/officer/edit/' . $row->user_id ?>" title="Edit">
                                    <i class="fa fa-edit"></i> 
                                </a>
                                <a href="<?= base_url() . 'officer/officer/delete/' . $row->user_id ?>" title="Delete">
                                    <i class="fa fa-times"></i> 
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>
            <div>
                <?php
                echo $this->pagination->create_links();
                //echo $articles->count();
                ?>
            </div>
        </div>
    </div>
</div>
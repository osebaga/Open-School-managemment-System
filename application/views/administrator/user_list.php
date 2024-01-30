<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Users List</h5>
        <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('create_user') ?>"><strong>Add New Account</strong></a>

    </div>
    <div class="ibox-content">

        <div class="col-md-12 clearfix">

            <form method="GET" action="<?php echo current_full_url(); ?>" class="form-horizontal clearfix ">
                <div class="col-md-12 " >
                    <div class=" col-lg-4 col-lg-offset-1" >
                <input type="text" class="form-control " value="<?php echo(isset($_GET['key']) ? $_GET['key'] : ''); ?>"
                       name="key" placeholder=" Search....."/>
                        </div>
<div class="col-lg-6 " >
                <select name="group_id" class="select2_search form-control " >
                 <option value=""></option>
                    <?php
                    $sel = isset($_GET['group_id']) ? $_GET['group_id']:'';
                    foreach($group_list as $key=>$value){ ?>
                        <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->description; ?></option>
                    <?php }
                    ?>
                </select>
</div>
                    <div class="col-lg-1">
                <input class="btn   btn-primary " type="submit" value="Search"/>
                        </div>
                </div>
            </form>
        </div>
        <div style="clear: both;"></div>

        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" class="table table-bordered"
                   style="" id="datatable">
                <thead>
            <tr>
                <th style="width: 50px;">S/No.</th>
                <th style="width: 200px;">Name</th>
                <th style="width: 120px;">Email</th>
                <th style="width: 120px;">Username</th>
               <th style="width: 100px;">Center Name</th>
                <th style="width: 140px;">Group</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 150px;">Last Login</th>
                <th style="width: 250px;">Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
 $current_user_id = current_user();
            $page1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 1);
            $has_edit_access = has_role($MODULE_ID,$GROUP_ID,"MANAGE_USERS",'user_list');
            $password_reset = has_role($MODULE_ID,$GROUP_ID,"MANAGE_USERS",'password_reset');
            foreach($users_list as $key => $value){
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $page1++; ?>. </td>
                     <td><?php echo $value->firstname.' '.$value->lastname;  ?></td>
                    <td><?php echo $value->email;  ?></td>
                    <td><?php echo $value->username;  ?></td>
                    <td><?php echo get_value('Center',$value->CenterRegNo,'CenterName');  ?></td>
                    <td><?php echo get_value('groups',$value->group_id,'description');  ?></td>
                    <td><?php echo ($value->active == 1 ? '<a href="'.site_url('deactivate/'.$value->id).'">Active</a>':'<a href="'.site_url('activate/'.$value->id).'">Inactive</a>');  ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->last_login);  ?></td>
                    <td>
                        <?php if($has_edit_access){ ?>
                        <a href="<?php echo site_url('create_user/'.encode_id($value->id)); ?>"><i class="fa fa-pencil"> Edit</i></a>
    <?php }if($password_reset){ ?>
                        &nbsp; | &nbsp; <a href="<?php echo site_url('reset_pass/'.encode_id($value->id)); ?>"><i class="fa fa-"> Reset Pass</i></a>
    <?php } ?>
</td>
                </tr>
                <?php
            }

            if(count($users_list) == 0){
                ?>
                <tr>
                    <td colspan="9">No data found !!</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
<!--        <div>--><?php //echo $pagination_links; ?>
<!--            <div style="clear: both;"></div>-->
<!--        </div>-->




    </div>
</div>


<script>
    $(function(){
        $(".select2_search").select2({
            theme: "bootstrap",
            placeholder: "Filter By Group",
            allowClear: true
        });

    })
</script>

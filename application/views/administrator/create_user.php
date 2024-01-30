<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo (isset($id) ? 'Edit User Information':'Add New User'); ?></h5>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group"><label class="col-lg-3 control-label">Title : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="title" class="form-control">
                    <option value="">Select Title</option>
                    <?php
                    $sel = (isset($userinfo) ? $userinfo->title :set_value('title'));
                    foreach($user_title_list as $key=>$value){
                        ?>
                        <option <?php echo ($sel == $value->title ? 'selected="selected"':''); ?> value="<?php echo $value->title; ?>"><?php echo $value->title; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('title'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">First Name : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($userinfo) ? $userinfo->firstname:set_value('firstname')); ?>" class="form-control" name="firstname">
                <?php echo form_error('firstname'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Last Name : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($userinfo) ? $userinfo->lastname:set_value('lastname')); ?>" class="form-control" name="lastname">
                <?php echo form_error('lastname'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($userinfo) ? $userinfo->phone:set_value('phone')); ?>" placeholder="Eg: 255xxxxxxxxx" class="form-control" name="phone">
                <?php echo form_error('phone'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($userinfo) ? $userinfo->email:set_value('email')); ?>" placeholder="Eg: info@ictsolutionsdesign.com" class="form-control" name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Username : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($userinfo) ? $userinfo->username:set_value('username')); ?>" class="form-control" name="username">
                <?php echo form_error('username'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Group : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="group_id" class="form-control" id="group_id">
                    <option value="">Select Group</option>
                    <?php
                    $sel1 = (isset($userinfo) ? get_user_group($userinfo->id)->id:set_value('group_id'));
                     foreach($group_list as $key=>$value) {
                         if ( $value->id != 2) {
                             ?>
                             <option <?php echo($sel1 == $value->id ? 'selected="selected"' : ''); ?>
                                 value="<?php echo $value->id; ?>"><?php echo $value->description; ?></option>
                             <?php
                         }
                     }
                    ?>
                </select>
                <?php echo form_error('group_id'); ?>
            </div>
        </div>

        <div class="form-group" id="school" style="display: none;"><label class="col-lg-3 control-label">College/School : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="school"  class="form-control" >
                    <option value="">[ Select College/School ]</option>
                <?php
                $sel = (isset($userinfo) ? ($userinfo->access_area == 1 ? $userinfo->access_area_id : ''): set_value('school'));
                foreach($school_list as $key=>$value){
                    ?>
                    <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php
                }
                ?>
                </select>
                <?php
                echo form_error('school');
                ?>

            </div>
        </div>

        <div class="form-group" id="department" style="display: none;"><label class="col-lg-3 control-label">Department : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="department"  class="form-control">
                    <option value=""> [ Select Department ]</option>
                <?php
                $sel = (isset($userinfo) ? ($userinfo->access_area == 2 ? $userinfo->access_area_id:'') : set_value('school'));
                foreach($department_list as $key=>$value){
                    ?>
                    <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                    <?php
                }
                ?>
                </select>
                <?php
                echo form_error('department');
                ?>

            </div>
        </div>


        <!-- <div class="form-group"><label class="col-lg-3 control-label">Default Campus : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="campus_id" class="form-control">
                    <option value="">Select Campus</option>
                    <?php
                    $sel = (isset($userinfo) ? $userinfo->campus_id:set_value('campus_id'));
                    foreach($campus_list as $key=>$value){
                        ?>
                        <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('campus_id'); ?>
            </div>
        </div> -->

        <div class="form-group"><label class="col-lg-3 control-label">Default Center : <span class="required">*</span></label>

<div class="col-lg-8">
    <select name="Center_id" class="form-control">
        <option value="">Select Center</option>
        <?php
        $sel = (isset($userinfo) ? $userinfo->Center_id:set_value('Center_id'));
        foreach($center_list as $key=>$value){?>
            <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->CenterName; ?></option>
            <?php
        }
        ?>
    </select>
    <?php echo form_error('Center_id'); ?>
</div>
</div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    $(function(){
       var group_id = $("#group_id").val();

        if(group_id == 3){
            $("#school").hide();
            $("#department").show();

        }else if(group_id == 100){
            $("#department").hide();
            $("#school").show();
        }else{
            $("#department").hide();
            $("#school").hide();
        }

        $("body").on("change","#group_id",function(){
            var group_id = $(this).val();

            if(group_id == 3){
                $("#school").hide();
                $("#department").show();
            }else if(group_id == 100){
                $("#department").hide();
                $("#school").show();
            }else{
                $("#department").hide();
                $("#school").hide();
            }
        });


    });
</script>
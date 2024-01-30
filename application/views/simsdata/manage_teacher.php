<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

// $year_list=$this->db->query("select * from ayear  order by AYear")->result();
$center_list=$this->db->query("select * FROM Center")->result();

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
            if (is_null($id) && !isset($action)) {
                echo 'Add New Teacher';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit Teacher Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">
        <?php
            echo form_open(current_full_url(), 'class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label">First Name : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="FirstName"
                           value="<?php echo(isset($teacherinfo) ? $teacherinfo->FirstName : set_value('FirstName')) ?>"
                           class="form-control"/>
                    <?php echo form_error('FirstName'); ?>
                </div>
            </div>


        <div class="form-group"><label class="col-lg-3 control-label">Middle Name : <span class="required">*</span></label>
            <div class="col-lg-8">
                <input type="text" name="MiddleName"
                       value="<?php echo(isset($teacherinfo) ? $teacherinfo->MiddleName : set_value('MiddleName')) ?>"
                       class="form-control"/>
                <?php echo form_error('MiddleName'); ?>
            </div>
        </div>
 
        <div class="form-group"><label class="col-lg-3 control-label">Surname : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="SurName"
                           value="<?php echo(isset($teacherinfo) ? $teacherinfo->SurName : set_value('SurName')) ?>"
                           class="form-control"/>
                    <?php echo form_error('SurName'); ?>
                </div>
            </div>
            <div class="form-group"><label class="col-lg-3 control-label">Registration No. : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="RegNo"
                           value="<?php echo(isset($teacherinfo) ? $teacherinfo->RegNo : set_value('RegNo')) ?>"
                           class="form-control"/>
                    <?php echo form_error('RegNo'); ?>
                </div>
            </div>
            <div class="form-group"><label class="col-lg-3 control-label">Center Name : <span class="required">*</span></label>
            <div class="col-lg-8">
            <select name="CenterRegNo"  id="CenterRegNo" class="form-control tag " >
                    <option  value="">Center Name</option>
                    <?php
                     $sel = (isset($teacherinfo) ? $teacherinfo->CenterRegNo: set_value('CenterRegNo'));
                     foreach($center_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->CenterRegNo ? 'selected="selected"' : ''); ?> 
                        value="<?php echo $value->CenterRegNo  ?>"><?php echo $value->CenterName; ?></option>
                        <?php
                    }
                    ?>
                </select>
                    <?php echo form_error('CenterRegNo'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Basic Salary : <span class="required">*</span></label>
            <div class="col-lg-8">
                <input type="text" name="BasicSalary"
                       value="<?php echo(isset($teacherinfo) ? $teacherinfo->BasicSalary : set_value('BasicSalary')) ?>"
                       class="form-control" onKeyPress="return numbersonly(event,this.value)" placeholder="Salary cost amount in TZS"/>


                <?php echo form_error('BasicSalary'); ?>
            </div>
        </div>
            <div class="form-group row">
            <label class="col-lg-3 control-label">Email : <span class="required">*</span></label>
            <div class="col-lg-3">
                <input type="text" name="Email"
                       value="<?php echo(isset($teacherinfo) ? $teacherinfo->Email : set_value('Email')) ?>"
                       class="form-control"/>
                <?php echo form_error('Email'); ?>
        </div>
            <label class="col-lg-2 control-label">Phone : <span class="required">*</span></label>
                <div class="col-lg-3">
                <input type="text"
                           value="<?php echo (isset($teacherinfo)) ? $teacherinfo->Phone : set_value('Phone'); ?>"
                           class="form-control" name="Phone" id="mobile" placeholder="Eg. 0xxxxxxxxx"
                           onKeyPress="return numbersonly(event,this.value)" maxlength="10"/>
                    <?php echo form_error('Phone'); ?>
                </div>
            </div>
        
        <div class="form-group row">
            <label class="col-lg-3 control-label">Qualification : <span class="required">*</span></label>
            <div class="col-lg-3">
                <!-- <input type="text" name="CenterCategory"
                       value="<?php echo(isset($teacherinfo) ? $teacherinfo->CenterCategory : set_value('CenterCategory')) ?>"
                       class="form-control"/> -->
                       <select name="Qualification"  id="CenterCategory" class="form-control tag " >
                    <option  value="">qualification</option>
                    <?php
                    foreach (center_category() as $key=>$value){
                        echo '<option '.($teacherinfo->Qualification ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('qualification'); ?>
            </div>
       
      
            <label class="col-lg-2 control-label">Status : <span class="required">*</span></label>
            <div class="col-lg-3">
                       <select name="Status"  id="Status" class="form-control tag " >
                    <option  value="">Status</option>
                    <?php
                    foreach (center_status() as $key=>$value){
                        echo '<option '.($teacherinfo->Status ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('Status'); ?>
            </div>
        </div>
  
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8 ">
                <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
            </div>
        </div>
      <?php echo form_close();
     ?>
    </div>
</div>

<script>
    $(document).ready(function(){


    });
    $(function(){
        $(".tag").select2({
            theme: "bootstrap",
            placeholder: " [ Select  ] ",
            allowClear: true
        });
    })

</script>
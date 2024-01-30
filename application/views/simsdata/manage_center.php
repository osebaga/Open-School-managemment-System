<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

$year_list=$this->db->query("select * from ayear  order by AYear")->result();

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
            if (is_null($id) && !isset($action)) {
                echo 'Add New Center';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit Center Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">
        <?php
            echo form_open(current_full_url(), 'class="form-horizontal ng-pristine ng-valid"') ?>
            <div class="form-group"><label class="col-lg-3 control-label">Center Reg. Number : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="CenterRegNo"
                           value="<?php echo(isset($centerinfo) ? $centerinfo->CenterRegNo : set_value('CenterRegNo')) ?>"
                           class="form-control"/>
                    <?php echo form_error('CenterRegNo'); ?>
                </div>
            </div>

        <div class="form-group"><label class="col-lg-3 control-label">Center Name : <span class="required">*</span></label>
            <div class="col-lg-8">
                <input type="text" name="CenterName"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->CenterName : set_value('CenterName')) ?>"
                       class="form-control"/>
                <?php echo form_error('CenterName'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Center Cost : <span class="required">*</span></label>
            <div class="col-lg-8">
                <input type="text" name="CenterCost"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->CenterCost : set_value('CenterCost')) ?>"
                       class="form-control" onKeyPress="return numbersonly(event,this.value)" placeholder="center cost amount in TZS"/>


                <?php echo form_error('CenterCost'); ?>
            </div>
        </div>

        <!-- <div class="form-group"><label class="col-lg-3 control-label">Region Code : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="RegionCode"
                           value="<?php echo(isset($centerinfo) ? $centerinfo->RegionCode : set_value('RegionCode')) ?>"
                           class="form-control"/>
                    <?php echo form_error('RegionCode'); ?>
                </div>
            </div> -->

        <div class="form-group row">
        <label class="col-lg-3 control-label">Region : <span class="required">*</span></label>
            <div class="col-lg-3">
                       <select name="Region" id="region" class="form-control tag "
                                onchange="loadDistrict    (this.value,'populate_districts','populate_districts','populate_district');">
                                <option value=""> [ Select Region]</option>
                                <?php
                                    $sel = isset($centerinfo) ? $centerinfo->Region : set_value('Region');
                                    foreach ($regions as $key => $value) { ?>
                                <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php } ?>
                            </select>
                <?php echo form_error('Region'); ?>
            </div>
       

        <label class="col-lg-2 control-label">District : <span class="required">*</span></label>
        <div class="col-lg-3"  >
            <select name="District" class="form-control tag" id="populate_districts">
                <option value=""> [ Select District ]</option>
                <?php
                    $sel = isset($centerinfo) ? $centerinfo->District : set_value('District');
                    foreach ($districts as $key => $value) { ?>
                <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                <?php } ?>
            </select>
            <?php echo form_error('District'); ?>
        </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 control-label">Year of Registration : <span class="required">*</span></label>
                <div class="col-lg-3">
                    <select name="YearOfReg"  class="form-control tag" >
                    <option  value="">Year of Registration</option>
                    <?php
                   $sel = isset($centerinfo) ? $centerinfo->YearOfReg : set_value('YearOfReg');
                    foreach($year_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?> 
                        value="<?php echo $value->AYear  ?>"><?php echo $value->AYear; ?></option>
                        <?php
                    }
                    ?>
                </select>
                    <?php echo form_error('YearOfReg'); ?>
                </div>
           

            <label class="col-lg-2 control-label">Expiry Year: <span class="required">*</span></label>
            <div class="col-lg-3">
                <!-- <input type="text" name="ExpireYear"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->ExpireYear : set_value('ExpireYear')) ?>"
                       class="form-control"/> -->

                       <select name="ExpireYear"  id="ExpireYear" class="form-control tag " >
                    <option  value="">Expiry Year</option>
                    <?php
                    foreach($year_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->ExpireYear ? 'selected="selected"' : ''); ?>
                         value="<?php echo $value->AYear  ?>"><?php echo $value->AYear; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('ExpireYear'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Center Owner : <span class="required">*</span></label>
            <div class="col-lg-8">
                <input type="text" name="CenterOwner"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->CenterOwner : set_value('CenterOwner')) ?>"
                       class="form-control"/>
                <?php echo form_error('CenterOwner'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Center Cordinator : <span class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="CenterCordnator"
                           value="<?php echo(isset($centerinfo) ? $centerinfo->CenterCordnator : set_value('CenterCordnator')) ?>"
                           class="form-control"/>
                    <?php echo form_error('CenterCordnator'); ?>
                </div>
            </div>

        <div class="form-group row">
            <label class="col-lg-3 control-label">Center Category : <span class="required">*</span></label>
            <div class="col-lg-3">
                <!-- <input type="text" name="CenterCategory"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->CenterCategory : set_value('CenterCategory')) ?>"
                       class="form-control"/> -->
                       <select name="CenterCategory"  id="CenterCategory" class="form-control tag " >
                    <option  value="">Center Category</option>
                    <?php
                    foreach (center_category() as $key=>$value){
                        echo '<option '.($sel==$key ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                    }
                    ?>
                </select>

               

                <?php echo form_error('CenterCategory'); ?>
            </div>
       

      
            <label class="col-lg-2 control-label">Status : <span class="required">*</span></label>
            <div class="col-lg-3">
                <!-- <input type="text" name="Status"
                       value="<?php echo(isset($centerinfo) ? $centerinfo->Status : set_value('Status')) ?>"
                       class="form-control"/> -->

                       <select name="Status"  id="Status" class="form-control tag " >
                    <option  value="">Status</option>
                    <?php
                    foreach (center_status() as $key=>$value){
                        echo '<option '.($sel==$key ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('Status'); ?>
            </div>
        </div>
  
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
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


    function loadDistrict(value, target_field, get_focused_field, action) {
        $.ajax({
            type: "post",
            url: "<?php echo site_url('loadDistrict') ?>",
            data: {
                target: target_field,
                id: value,
                ffocus: get_focused_field,
                action: action
            },
            datatype: "text",
            success: function (data) {
                $("#" + target_field).html(data);
            }
        });

    }

</script>
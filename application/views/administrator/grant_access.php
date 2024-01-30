<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Assign Access to group name : <?php echo   $groupinfo->description.' - ( '.$groupinfo->name.' )'; ?></h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"');

        foreach($section_role_list as $sectionkey=>$sectionvalue){
            $role_list = $this->common_model->get_module_role($this->data['groupinfo']->module_id,$sectionvalue->name);

        ?>
            <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
                <?php echo strtoupper($sectionvalue->description); ?>
            </div>
            <?php foreach($role_list as $key=>$value){ ?>
                <div class="form-group" style="border-bottom: 1px dotted #ccc; margin-left: 20px; margin-right: 20px; padding-bottom: 5px; margin-bottom:0px;">
                    <label class="col-lg-4 control-label"><?php echo $value->description; ?> :</label>

                    <div class="col-lg-1">
                        <label class="checkbox-inline">
                            <input type="checkbox" <?php echo (has_role($groupinfo->module_id,$groupinfo->id,$sectionvalue->name,$value->role) ? 'checked="checked"':''); ?> value="<?php echo $value->role; ?>" name="rolevalue[<?php echo $value->id; ?>]" class="checkbox-inline"/>
                        </label>
                    </div>
                </div>
<?php } echo '<br/>'; } ?>


        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" name="grant_access" type="submit" value="Grant Access"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

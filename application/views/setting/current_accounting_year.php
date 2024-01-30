<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title ">
        <h5> Accounting Years</h5>
    </div>
    <div class="ibox-content">
        <?php
        echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group"><label class="col-md-2 control-label"> Active Account Year:<span class="required">*</span></label>

            <div class="col-md-3">
                <input type="text" class="form-control" value="<?php echo (isset($yearinfo) ? $yearinfo->AYear : set_value('ayear')); ?>" name="ayear"/>
                <?php echo form_error('ayear'); ?>
            </div>

            <div class="col-md-1">
                <label class="checkbox-inline"> <input type="checkbox" class="checkbox-inline" name="status" value="1" <?php echo (isset($yearinfo) ? ($yearinfo->Status == 1 ? 'checked="checked"':'' ): '') ; ?> />Active</label>
            </div>
            <div class="col-lg-1">
                <input class="btn btn-sm btn-success" name="save" type="submit" value="Save Information"/>
            </div>
        </div>
        <?php echo form_close();  ?>
        <div style="border-bottom: 1px solid #ccc;"></div>
        <br/>

        <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th style="width: 50px;">S/No</th>
                <th>AYear</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($account_year as $key => $value) {  ?>
                <tr>
                    <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($key + 1); ?>.</td>
                    <td><?php echo $value->AYear; ?></td>
                    <td><?php echo ($value->Status == 0 ? 'Inactive' : 'Active'); ?></td>
                    <td>
                        <a href="<?php echo site_url('current_account_year/'.encode_id($value->id).'/?action=edit') ?>"><i class="fa fa-pencil"></i> Edit</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>


    </div>
</div>
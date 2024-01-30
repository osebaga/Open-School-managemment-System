<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title ">
        <h5>Application Rounds</h5>
    </div>
    <div class="ibox-content">


        <?php


        echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group"><label class="col-md-2 control-label">Application Type:<span class="required">*</span></label>
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="">[ Select Application Type ]</option>
                    <?php
                    $sel = (isset($roundinfo) ? $roundinfo->application_type:set_value('type'));
                    foreach(application_type_search() as $kkey=>$kvalue){
                        ?>

                        <option <?php echo ($kkey == $sel ? 'selected="selected"':'')  ?> value="<?php echo $kkey; ?>"><?php echo $kvalue; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('type'); ?>
            </div>

            <label class="col-md-1 control-label"> Round:<span class="required">*</span></label>

            <div class="col-md-3">
                <select name="round" class="form-control">
                    <option value="">[ Select Round]</option>
                    <?php
                    $sel = (isset($roundinfo) ? $roundinfo->round:set_value('round'));
                    foreach(Rounds() as $kkey=>$kvalue){
                        ?>

                        <option <?php echo ($kkey == $sel ? 'selected="selected"':'')  ?> value="<?php echo $kkey; ?>"><?php echo $kvalue; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('round'); ?>
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
                <th>Application Type</th>
                <th>Round</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($application_rounds as $key => $value) {  ?>
                <tr>
                    <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($key + 1) ?>.</td>
                    <td><?php echo application_type_search($value->application_type); ?></td>
                    <td><?php echo $value->round; ?></td>
                    <td>
                        <a href="<?php echo site_url('application_round/'.encode_id($value->id).'/?action=edit') ?>"><i class="fa fa-pencil"></i> Edit</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>


    </div>
</div>
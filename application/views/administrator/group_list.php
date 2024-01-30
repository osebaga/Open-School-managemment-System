<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Group List</h5>
    </div>
    <div class="ibox-content">



        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th style="width: 50px;">S/No.</th>
                <th style="width: 170px;">NAME</th>
                <th style="width: 170px;">DESCRIPTION</th>
                <th style="width: 150px;">MODULE</th>
                <th style="width: 100px;">ACTION</th>
            </tr>
            </thead>

            <tbody>
            <?php
              $p=1;
            foreach($group_list as $key=>$value) {
                if ($value->id != 2) {
                    ?>
                    <tr>
                        <td style="text-align: right;"><?php echo $p++; ?>. &nbsp; </td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><?php echo ucfirst(get_value('module', array('id' => $value->module_id), 'name')); ?></td>
                        <td>
                    <?php if(has_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS','create_group')){ ?>
                            <a href="<?php echo site_url('add_group/'.encode_id($value->id)); ?>"><i class="fa fa-pencil"></i> Edit</a>
                      <?php } if(has_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS','grant_access') ){ ?>  &nbsp; | &nbsp;
                            <a href="<?php echo site_url('grant_access/'.encode_id($value->id)); ?>"><i class="fa fa-lock"></i> Access</a>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>



    </div>
</div>
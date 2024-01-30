<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}
if (isset($_GET)) {
    $title1 = '';
    if (isset($_GET['key']) && $_GET['key'] <> '') {
        $title1 = " Searching Key :<strong> " . $_GET['key'] . '</strong>';
    }

    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

$has_access = has_role($MODULE_ID,'create_programme',$GROUP_ID,'SETTINGS');
?>

<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title clearfix">
                <h5>Programme List</h5>
                <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
                   href="<?php echo site_url('add_programme/') ?>"><strong>Add Programme</strong></a>

            </div>
            <div class="ibox-content">
                <?php echo form_open(site_url('programme_list'), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
                <div class="form-group clearfix">
                    <div class="col-md-1 pull-right no-padding">
                        <input type="submit" value="Search" class="btn btn-success btn-sm">
                    </div>
                    <div class="col-md-3 pull-right">
                        <select name="type" class="form-control">
                            <option value="">All Category</option>
                            <?php
                            $sel = (isset($_GET['type']) ? $_GET['type'] : '');
                            foreach (application_type() as $key1=>$value1){
                                ?>
                            <option <?php echo ($sel==$key1 ? 'selected="selected"':''); ?> value="<?php echo $key1 ?>" ><?php echo $value1; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 pull-right ">
                        <input type="text" value="<?php echo(isset($_GET['key']) ? $_GET['key'] : '') ?>" name="key"
                               class="form-control" placeholder="Search....">
                    </div>


                </div>
                <?php echo form_close();
                ?>
                <div class="row">
                    <table cellspacing="0" cellpadding="0" class="table table-bordered table-responsive"
                           style="" id="applicantlist">
                        <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">S/No</th>
                            <th style="width: 50px; text-align: center;">Code</th>
                            <th style="width: 200px;">Name</th>
                            <th style="width: 50px; text-align: center;">Department</th>
                            <th style="width: 50px; text-align: center;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = $this->uri->segment(2)+1;
                        foreach ($programme_list as $key1 => $value1) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle; padding-left: 4px; text-align: center;"><?php echo $i++; ?></td>
                                <td style="vertical-align: middle; padding-left: 4px; text-align: center;"><?php echo $value1->Code; ?></td>
                                <td style="vertical-align: middle; padding-left: 4px;"><?php echo $value1->Name; ?></td>
                                <td style="vertical-align: middle; padding-left: 4px;"><?php echo get_value('department',$value1->Departmentid,'Name'); ?></td>
                                <td style="vertical-align: middle; text-align: center"><a href="<?php echo site_url('add_programme/'.$value1->id) ?>"><i class="fa fa-pencil"></i> Edit</a></td>

                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <div><?php echo $pagination_links; ?>
                        <div style="clear: both;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

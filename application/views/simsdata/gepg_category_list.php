<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>GePG category List</h5>

       <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('manage_gepg_category') ?>"><strong>Add GePG category</strong></a>

    </div>
    <div class="ibox-content">

            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th style="width: 50px;">S/No</th>
                    <th style="width: 250px;">Name</th>
                    <th style="width: 100px; text-align: center;">GFS code</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($gepg_category_list as $sponsork => $sponsorv) {

                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($sponsork + 1) ?>.</td>
                        <td><?php echo $sponsorv->name; ?></td>
                        <td><?php echo $sponsorv->gfscode; ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('manage_gepg_category/'.encode_id($sponsorv->id)) ?>"><i class="fa fa-pencil"></i> Edit</a> ||
                            <a href="<?php echo site_url('delete_gepg_category/'.encode_id($sponsorv->id)) ?>" onclick="return confirm('Are you sure you want to delete selected GePG category !!!');" ><i class="fa fa-remove"></i>Delete
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>


    </div>
</div>

<script>
    $(function(){
        $(".select2_search").select2({
            theme: "bootstrap",
            placeholder: " [ Select Principal ] ",
            allowClear: true
        });

        $(".select2_search1").select2({
            theme: "bootstrap",
            placeholder: " [ Select College/School ] ",
            allowClear: true
        });

    })
</script>
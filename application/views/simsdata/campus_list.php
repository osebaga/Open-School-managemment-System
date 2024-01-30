<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Campus List</h5>

       <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('manage_campus') ?>"><strong>Add Campus</strong></a>

    </div>
    <div class="ibox-content" >

            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th style="width: 50px;">S/No</th>
                    <th style="width: 200px;" >Name</th>
                    <th style="width: 200px;">Location</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($campus_list as $cam => $camp) {

                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($cam + 1) ?>.</td>
                        <td><?php echo $camp->name; ?></td>
                        <td><?php echo $camp->location; ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('manage_campus/'.encode_id($camp->id)) ?>"><i class="fa fa-pencil"></i> Edit</a></td>

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

        // $(".select2_search1").select2({
        //     theme: "bootstrap",
        //     placeholder: " [ Select College/School ] ",
        //     allowClear: true
        // });

    })
</script>
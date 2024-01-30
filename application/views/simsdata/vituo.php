<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Vituo</h5>

       <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('manage_vituo') ?>"><strong>Ongeza Vituo</strong></a>

    </div>
    <div class="ibox-content">

            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Mkoa</th>
                    <th>Wilaya</th>
                    <th>Jina la kituo</th>
                    <th>Anuani</th>
                    <th>Jina la mkuu wa kituo</th>
                    <th>Number ya simu ya mkuu wa kituo</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($vituo as $sponsork => $sponsorv) {
                    $district_info=get_value('districts',$sponsorv->district,'');
                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($sponsork + 1) ?>.</td>
                        <td><?php echo get_value('regions',$district_info->region_id,'name') ?></td>
                        <td><?php echo $district_info->name; ?></td>
                        <td><?php echo $sponsorv->name; ?></td>
                        <td><?php echo $sponsorv->anuani; ?></td>
                        <td><?php echo $sponsorv->jinalamkuu; ?></td>
                        <td><?php echo $sponsorv->simuyamkuu; ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('manage_vituo/'.encode_id($sponsorv->id)) ?>"><i class="fa fa-pencil"></i> Edit</a></td>

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
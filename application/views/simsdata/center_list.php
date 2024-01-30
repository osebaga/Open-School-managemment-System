<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Center List</h5>

       <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('manage_center') ?>"><strong>Add Center</strong></a>

    </div>
    <div class="ibox-content">

            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th style="width: 50px;">S/No</th>
                    <th>CenterCode</th>
                    <th>Name</th>
                    <th>CenterCost</th>
                    <th>Region</th>
                    <th>District</th>
                    <th>YearofReg.</th>
                    <th>ExpiringYear</th>
                    <th>Owner</th>
                    <th>Cordinator</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($center_list as $center => $centerv) {
                    $region =$this->db->query("select regions.name as region,districts.name as district 
                    from regions join districts on regions.id=districts.region_id where districts.id='$centerv->District'")->row();
                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($center + 1) ?>.</td>
                        <td><?php echo $centerv->CenterRegNo; ?></td>
                        <td><?php echo $centerv->CenterName; ?></td>
                        <td><?php echo number_format($centerv->CenterCost); ?></td>
                        <td><?php echo  $region->region; ?></td>
                        <td><?php echo  $region->district; ?></td>
                        <td><?php echo $centerv->YearOfReg; ?></td>
                        <td><?php echo $centerv->ExpireYear; ?></td>
                        <td><?php echo $centerv->CenterOwner; ?></td>
                        <td><?php echo $centerv->CenterCordnator; ?></td>
                        <td><?php echo $centerv->CenterCategory; ?></td>
                        <td><?php echo $centerv->Status; ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('manage_sponsor/'.encode_id($centerv->id)) ?>"><i class="fa fa-pencil"></i> Edit</a></td>

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
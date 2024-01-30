<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins" >
    <div class="ibox-title clearfix">
        <h5>Teacher List</h5>
       <a class="btn btn-sm btn-small btn-warning pull-right" style="font-weight: bold;"
           href="<?php echo site_url('manage_teacher') ?>"><strong>Add Teacher</strong></a>

    </div>
    <div class="ibox-content" >

            <table cellpadding="0" style="margin-left: -10px" cellspacing="0" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th style="width: 10px;">S/No</th>
                    <th>CenterName</th>
                    <th>RegNo</th>
                    <th>FirstName</th>
                    <!-- <th>MiddleName</th> -->
                    <th>SurName</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Qualification</th>
                    <th>Status</th>
                    <th>BasicSalary</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($teacher_list as $center => $centerv) {
                    $centers =$this->db->query("select * from Center where CenterRegNo='$centerv->CenterRegNo'")->row();
                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo($center + 1) ?>.</td>
                        <td><?php echo $centers->CenterName; ?></td>
                        <td><?php echo $centerv->RegNo; ?></td>
                        <td><?php echo $centerv->FirstName; ?></td>
                        <!-- <td><?php echo $centerv->MiddleName; ?></td> -->
                        <td><?php echo $centerv->SurName; ?></td>
                        <td><?php echo $centerv->Email; ?></td>
                        <td><?php echo $centerv->Phone; ?></td>
                        <td><?php echo $centerv->Qualification; ?></td>
                        <td><?php echo $centerv->Status; ?></td>
                        <td><?php echo number_format($centerv->BasicSalary); ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('manage_teacher/'.encode_id($centerv->id)) ?>"><i class="fa fa-pencil"></i> Edit</a></td>

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
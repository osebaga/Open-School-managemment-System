<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
$check = $this->db->get("run_selection")->row();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Applicant Selection</h5>
        <?php if(!$check){ ?>
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Run Selection <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <?php foreach (array(1,2,3,4,5) as $k=>$v){ ?>
                        <li><a class="dropdown-item" href="<?php echo site_url('run_selection/'.$v); ?>">Run Choice No. <?php echo $v; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="ibox-content">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 50px;  text-align: center;">S/No</th>
                <th style="">Programme Name</th>
                <th style="width: 10px;  text-align: center;">Eligible</th>
                <th style="width: 100px;  text-align: center;">Selected</th>
                <th style="width: 100px;  text-align: center;">Rejected</th>
                <th style="width: 150px;  text-align: center;">List</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ayear = $this->common_model->get_academic_year()->row()->AYear;


            foreach ($programme_list as $key=>$value){

                $current_round=$this->db->query("select * from application_round where application_type=".$value->type)->row();
                if($current_round)
                {
                    $round=$current_round->round;
                }else{
                    $round=1;
                }
                $check_row = $this->db->where('ProgrammeCode',$value->Code)->get("run_selection")->row();
                $programme_info = get_value('programme',array('Code'=>$value->Code),null);
                $duration = array(2,3);
                if($value->type == 2){
                    unset($duration[0]);
                    $duration = array_values($duration);
                }
                // foreach ($duration as $l=>$d){


                $counter_eligible = $this->db->query("SELECT count(ap.id) as counter FROM application_elegibility as ae 
                     INNER JOIN application as ap ON (ae.applicant_id=ap.id) WHERE 1=1   AND  
                      ae.ProgrammeCode='$value->Code' AND ae.status=1 AND  ap.AYear='$ayear' AND ae.round='$round'")->row();

                $counter_selected = $this->db->query("SELECT count(ap.id) as counter FROM application_elegibility as ae 
                     INNER JOIN application as ap ON (ae.applicant_id=ap.id) WHERE 1=1   AND  
                      ae.ProgrammeCode='$value->Code' AND ae.status=1 AND ae.selected=1 AND ap.AYear='$ayear' AND ae.round='$round'")->row();

                ?>
                <tr>

                    <td style="text-align: right; vertical-align: middle;"><?php echo $key+1; ?>.</td>
                    <td style="vertical-align: middle; <?php echo ($check_row ? 'color:blue;':''); ?>"><?php echo $value->Name; ?></td>

                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($counter_eligible->counter); ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?php echo  number_format($counter_selected->counter); ?></td>

                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format(($counter_eligible->counter-$counter_selected->counter)); ?></td>

                    <td style="text-align: left; vertical-align: middle;">
<!--                        <a class="view_data" title="--><?php //echo $programme_info->Name; ?><!--" PROGRAMME="--><?php //echo $value->Code;  ?><!--" APP_TYPE="--><?php //echo $value->type; ?><!--" href="javascript:void(0);"><i class="fa fa-eye"></i> View </a>-->
                        &nbsp; | &nbsp;
                        <a  href="<?php echo site_url('report/applicant_byProgramme_selected/?programme='.$value->Code.'&type='.$value->type) ?>"><i class="fa fa-download"></i> Export </a>
                    </td>
                </tr>
                <?php /*}*/ } ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    $(document).ready(function () {

        <?php if($check){ ?>
         window.location.reload();
        setInterval(function(){
            $.ajax({
                type:"post",
                url:"<?php echo site_url('run_selection_active') ?>",
                datatype:"html",
                success:function(data)
                {
                    if(data == '1'){
                        window.location.reload();
                    }
                    //do something with response data
                }
            });
        },30000);
        <?php } ?>

        $(".view_data").click(function () {
            var programme_code = $(this).attr('PROGRAMME');
            var application_type = $(this).attr('APP_TYPE');
            var title = $(this).attr('title');
            $.confirm({
                title: '<div style="font-size: 20px;">'+title+'</div>',
                content:'URL:<?php echo site_url('popup/applicant_byProgramme_selected/') ?>?programme='+programme_code+'&type='+application_type,
                confirmButton:'Export',
                columnClass:'col-md-12',
                cancelButton:'Close',
                theme:'bootstrap',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    window.location.href = '<?php echo site_url('report/applicant_byProgramme_selected/') ?>?programme='+programme_code+'&type='+application_type;
                    return false;
                },
                cancel:function () {
                    return true;
                }
            });
        });
    });
</script>
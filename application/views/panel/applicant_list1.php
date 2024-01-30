<?php

if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}
if (isset($_GET)) {
    $title1 = '';
    if (isset($_GET['key']) && $_GET['key'] <> '') {
        $title1 .= " Searching Key :<strong> " . $_GET['key'] . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['entry']) && $_GET['entry'] <> '') {
        $title1 .= " Entry Type :<strong> " . entry_type_human($_GET['entry']) . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['type']) && $_GET['type'] <> '') {
        $title1 .= " Application Type :<strong> " . application_type_search($_GET['type']) . '</strong>';
    }

    if (isset($_GET['from']) && $_GET['from'] <> '') {
        $frm  = $_GET['from'];
        $from = format_date($frm, true);
        $title1 .= " From :<strong> " .  $from . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['to']) && $_GET['to'] <> '') {
        $to  = $_GET['to'];
        $to = format_date($to, true);
        $title1 .= " Until :<strong> " . $to . '</strong>';
    }
    if (isset($_GET['status']) && $_GET['status'] <> '') {

        $title1 .= " Status :<strong> " . application_status($_GET['status'] ). '</strong>';
    }

    if (isset($_GET['round']) && $_GET['round'] <> '') {

        $title1 .= " Round :<strong> " . $_GET['round']. '</strong>';
    }
    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Applicant List</h5>
    </div>
    <div class="ibox-content">
        <?php echo form_open(site_url('applicant_list'), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
                <div class="col-md-3 " style="padding-left: 0px;">
                    <input type="text" value="<?php echo(isset($_GET['key']) ? $_GET['key'] : '') ?>" name="key"
                           class="form-control" placeholder="Search....">
                </div>
            <div class="col-md-3">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/>

            </div>

            <div class="col-md-3">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/>
            </div>
            <div class="col-md-3">
                <select name="entry" class="form-control">
                    <option value="">[ All Entry Type ]</option>
                    <?php
                    foreach (entry_type_certificate() as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['entry']) ? ($_GET['entry'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tkey; ?>"><?php echo $tvalue ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group no-padding">
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="">[ All Application Type ]</option>
                    <?php
                    foreach (application_type_search() as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['type']) ? ($_GET['type'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tkey; ?>"><?php echo $tvalue ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">[Status]</option>
                    <?php
                    foreach (application_status() as $key => $value) {
                        ?>
                        <option <?php echo(isset($_GET['status']) ? ($_GET['status'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $key; ?>"><?php echo $value ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="round" class="form-control">
                    <option value="">[Round]</option>
                    <?php
                    $max_round=$this->db->query("select max(round) as round from application_round")->row()->round;
                    for($i=1;$i<=$max_round;$i++) {
                        ?>
                        <option <?php echo(isset($_GET['round']) ? ($_GET['round'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $i; ?>"><?php echo 'Round '. $i ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>
        <?php echo form_close();
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">
            <thead>
                <tr>
                    <th style="width: 30px; text-align: center">S/No</th>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 100px; text-align: center;">Application Date</th>
                    <th style="width: 100px;">Application Type</th>
                    <th style="width: 100px;">Campus</th>
                    <th style="width: 100px;">Entry Type</th>
                    <th style="width: 100px; text-align: center;">Mobile</th>
                    <th style="width: 100px; text-align: center;">Amount</th>
                    <th style="width: 100px; text-align: center;">Nationality</th>
                    <th style="width: 80px; text-align: center;">Status</th>
                    <th style="width: 80px; text-align: center;">TCU received?</th>
                    <th style="width: 60px;">Action</th>
                    <th style="width: 60px;">Round</th>

                </tr>
                </thead>
                <tbody>
                <?php
                  $applicant_camp="";
                $page = ($this->uri->segment(2) ? ($this->uri->segment(2)+1):1 );
                foreach ($applicant_list as $applicant_key => $applicant_value) {
                    $program_choices=$this->db->query("select * from application_programme_choice where applicant_id=".$applicant_value->id." order by id DESC ")->row();

                    if($program_choices->id)
                    {
                        $round='Round'.$program_choices->round;


                    }else{
                        $round='';
                    }

                    if(isset($_GET['round']))
                    {

                      if( trim($program_choices->round)!=trim($_GET['round']) and $_GET['round']!='')
                      {

                          continue;

                      }
                    }


       
                    if($applicant_value->application_type == 2){
                        $check_tcu_status=$this->db->query("select * from tcu_records where applicant_id='".$applicant_value->id."' and  (status=200 or status=208)")->row();
                        if($check_tcu_status->status){
                            $tcu = "Yes";
                        }else{
                            $tcu = $check_tcu_status->status;
                        }
                    }else{
                        $tcu = "";
                    }
                 
                    ?>
                    <tr>
                      <td style="text-align: right;"><?php  echo $page++; ?></td>
                      <td style="text-align: left;"><?php  echo $applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName; ?></td>
                      <td style="text-align: center;"><?php  echo $applicant_value->createdon; ?></td>
                        <td><?php echo application_type_search($applicant_value->application_type); ?></td>
                        <td>
                            <?php
                            
                            if(isset($program_choices->application_campus) and $program_choices->application_campus!='')
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="applicant_campus" ID="'.$applicant_value->id.'" firstname="'.$applicant_value->FirstName.'" middlename="'.$applicant_value->MiddleName.'" lastname="'.$applicant_value->LastName.'" SELECTED_ID="'.$applicant_value->application_campus.'" SELECTED_VALUE="'.$program_choices->application_campus.'" >'.$program_choices->application_campus;

                            }
                            else
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="applicant_campus" ID="'.$applicant_value->id.'" firstname="'.$applicant_value->FirstName.'" middlename="'.$applicant_value->MiddleName.'" lastname="'.$applicant_value->LastName.'" SELECTED_ID="'.$applicant_value->application_campus.'" SELECTED_VALUE="'.$program_choices->application_campus.'" >'.'No Campus';

                            }                         
                               ?></a>
                        </td>


                        <td><?php echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_entrytype" ID="'.$applicant_value->id.'" firstname="'.$applicant_value->FirstName.'" middlename="'.$applicant_value->MiddleName.'" lastname="'.$applicant_value->LastName.'" SELECTED_ID="'.$applicant_value->entry_category.'" SELECTED_VALUE="'.entry_type_human($applicant_value->entry_category).'" >'.entry_type_human($applicant_value->entry_category); ?></a></td>
                        <td style="text-align: center;"><?php echo $applicant_value->Mobile1; ?></td>
                        <td style="text-align: center;"><?php echo number_format($applicant_value->amount); ?></td>
                        <td style="text-align: center;"><?php echo get_country($applicant_value->Nationality,'Name'); ?></td>
                      <td style="text-align: center;"><?php echo application_status($applicant_value->submitted); ?></td>
                        <td style="text-align: center;" title="<?php echo $check_tcu_status->description;  ?>" > <?php echo ($check_tcu_status->status==200) ?  $tcu : "<a href='".site_url('AddApplicantTCU/'.$applicant_value->id.'/'.$applicant_value->entry_category)."'> ".$tcu."</a>"; ?></td>
                        <td style="text-align: left;"><?php  echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_info" ID="'.encode_id($applicant_value->id).'" 
                         title="'.$applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName.'"><i class="fa fa-eye"></i> View</a>'; ?></td>
                        <td style="text-align: center;"><?php echo $round; ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>

        <a href="<?php echo site_url('report/export_applicant/?'.((isset($_GET) && !empty($_GET)) ? http_build_query($_GET):'') ); ?>" class="btn btn-sm btn-success">Export Excel</a>
    </div>
</div>

<script>
    $(document).ready(function () {


        $("body").on("click",".popup_applicant_entrytype",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var firstname = $(this).attr("firstname");
            var middlename = $(this).attr("middlename");
            var lastname = $(this).attr("lastname");


           $.confirm({
                title:'Change Entry Category for : '+firstname+' '+middlename+' '+lastname,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Selected Category :</label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Change to : <span class="required">*</span></label><div class="col-lg-8">'+
                '<select class="form-control" id="new_category" name="new_category"><option value="">--Select New Category--</option>'
                <?php foreach (entry_type_certificate() as $k=>$v){  ?>
                      +'<option value="<?php echo $k; ?>"><?php echo $v; ?></option>'
                 <?php } ?>
                +'</select></div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var new_category = this.$content.find("#new_category").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(new_category != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_entry_mode') ?>',
                            type: 'post',
                            data: {
                                new_category: new_category,
                                applicant_id: applicant_id
                            },
                            success: function () {
                                window.location.reload();
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select new entry mode...");
                    }
                    return false;
                },
                cancel:function () {
                    return true;
                }

                
            });
        });


        $("body").on("click",".applicant_campus",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var firstname = $(this).attr("firstname");
            var middlename = $(this).attr("middlename");
            var lastname = $(this).attr("lastname");


           $.confirm({
                title:'Change Campus for : '+firstname+' '+middlename+' '+lastname,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Selected Campus :</label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Change to : <span class="required">*</span></label><div class="col-lg-8">'+
                '<select class="form-control" id="application_campus" name="application_campus"><option value="">--Select New Campus--</option>'
                <?php foreach ($this->common_model->get_all_campus() as $k=>$v){  ?>

                      +'<option value="<?php echo $v->name; ?>"><?php echo $v->name; ?></option>'
                 <?php } ?>
                +'</select></div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var application_campus = this.$content.find("#application_campus").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(application_campus != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_application_campus') ?>',
                            type: 'post',
                            data: {
                                application_campus: application_campus,
                                applicant_id: applicant_id
                            },
                            success: function () {
                              window.location.reload();

                                // console.log(result)
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select new Campus...");
                    }
                    return false;
                },
                cancel:function () {
                    return true;
                }

                
            });
        });


       $("body").on("click",".popup_applicant_info",function () {
           var ID = $(this).attr("ID");
           var title = $(this).attr("title");
           $.confirm({
               title:title,
               content:"URL:<?php echo site_url('popup_applicant_info') ?>/"+ID+'/?status=1',
               confirmButton:'Print',
               columnClass:'col-md-10 col-md-offset-2',
               cancelButton:'Close',
               extraButton:'ExtraB',
               cancelButtonClass: 'btn-success',
               confirmButtonClass: 'btn-success',
               confirm:function () {
                   window.location.href = '<?php echo site_url('print_application') ?>/'+ID;
                   return false;
               },
               cancel:function () {
                   return true;
               }

           });
       })

<?php //if(!is_section_used('SUBMIT',$APPLICANT_MENU)){ ?>
//        setInterval(function(){
//            $.ajax({
//                type:"post",
//                url:"<?php //echo site_url('tcu_resubmit') ?>//",
//                datatype:"html",
//                success:function(data)
//                {
//                    if(data == '1'){
//                        window.location.reload();
//                    }
//                    //do something with response data
//                }
//            });
//        },3000)
//        <?php //} ?>



    });
</script>

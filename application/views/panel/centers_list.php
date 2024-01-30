<?php

if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}
if (isset($_GET)) {
    $title1 = '';
    // if (isset($_GET['key']) && $_GET['key'] <> '') {
    //     $title1 .= " Searching Key :<strong> " . $_GET['key'] . '</strong> &nbsp; &nbsp; &nbsp;';
    // }

    if (isset($_GET['center']) && $_GET['center'] <> '') {
        $title1 .= " Application Type :<strong> " . center_application($_GET['center']) . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['entry']) && $_GET['entry'] <> '') {
        $title1 .= " Center Premises :<strong> " . center_premises($_GET['entry']) . '</strong> &nbsp; &nbsp; &nbsp;';
    }
    // if (isset($_GET['center']) && $_GET['center'] <> '') {
    //     $center = $this->db->query("SELECT * FROM Center WHERE CenterRegNo='".$_GET['center']."' ")->row();

    //     $title1 .= " Center :<strong> " . $center->CenterName . '</strong>';
    // }

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

    // if (isset($_GET['round']) && $_GET['round'] <> '') {

    //     $title1 .= " Round :<strong> " . $_GET['round']. '</strong>';
    // }
    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Center List</h5>
    </div>
    <div class="ibox-content">
        <?php echo form_open(site_url('centers_list'), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
                <!-- <div class="col-md-3 " style="padding-left: 0px;">
                    <input type="text" value="<?php echo(isset($_GET['key']) ? $_GET['key'] : '') ?>" name="key"
                           class="form-control" placeholder="Search....">
                </div> -->
            <div class="col-md-2">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/>

            </div>

            <div class="col-md-2">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/>
            </div>
            <div class="col-md-2">
                <select name="entry" class="form-control">
                    <option value="">[ All Premises ]</option>
                    <?php
                    foreach (center_premises() as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['entry']) ? ($_GET['entry'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tkey; ?>"><?php echo $tvalue ?></option>
                        <?php
                    }
                 ?>
                </select>
            </div>
      
            <div class="col-md-2">
                <select name="center" class="form-control">
                    <option value="">[ All Type ]</option>
                    <?php
                    foreach (center_application() as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['center']) ? ($_GET['center'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tkey; ?>"><?php echo $tvalue ?></option>
                        <?php
                    }
                 ?>
                </select>
            </div>
            <div class="col-md-2">
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
            
            <div class="form-group no-padding">

            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>
        </div>
        <?php echo form_close();
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">
            <thead>
                <tr>
                    <th style="width: 30px; text-align: center">S/No</th>
                    <!-- <th style="width: 150px;">Center No.</th> -->
                    <th style="width: 300px;">Applied Date</th>
                    <th style="width: 300px;">Name</th>
                    <th style="width: 100px;">Center Owner</th>
                    <th style="width: 100px;">Cordinator</th>
                    <th style="width: 100px;">Application Type</th>
                    <th style="width: 100px;">Center Premises</th>
                    <th style="width: 100px;">Education Level</th>
                    <th style="width: 100px;">TIN</th>
                    <th style="width: 100px; text-align: center;">Mobile</th>
                    <th style="width: 100px; text-align: center;">Amount</th>
                    <!-- <th style="width: 100px; text-align: center;">Nationality</th> -->
                    <th style="width: 80px; text-align: center;">Application Status</th>
                    <!-- <th style="width: 100px;" >Approval Status</th> -->
                    <th style="width: 60px;">Action</th>
                    <!-- <th style="width: 60px;">Round</th> -->

                </tr>
                </thead>
                <tbody>
                <?php
                  $applicant_camp="";
                $page = ($this->uri->segment(2) ? ($this->uri->segment(2)+1):1 );
                foreach ($centers_list as $applicant_key => $applicant_value) { 

                    ?>
                
                    <tr>
                      <td style="text-align: right;"><?php  echo $page++; ?></td>
                      <!-- <td>
                      <?php  echo $applicant_value->CenterRegNo; ?>

                           
                            if(isset($applicant_value->RegNo) and $applicant_value->RegNo!='')
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="center_regno" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->RegNo.'" SELECTED_VALUE="'.$applicant_value->RegNo.'" >'.$applicant_value->RegNo;
                            }
                            else
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="center_regno" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->RegNo.'" SELECTED_VALUE="'.$applicant_value->RegNo.'" >'.'No Center No.';
                            }                         
                          
                        </td>                      -->
                        <td style="text-align: left;"><?php  echo $applicant_value->createdon; ?></td>

                        <td style="text-align: left;"><?php  echo $applicant_value->CenterName; ?></td>
                        <td style="text-align: left;"><?php  echo  $applicant_value->CenterOwner; ?></td>
                        <td style="text-align: left;"><?php  echo  $applicant_value->CenterCordinator; ?></td>

                        <td><?php echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_entrytype" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->application_type.'" SELECTED_VALUE="'.center_application($applicant_value->application_type).'" >'.center_application($applicant_value->application_type); ?></a></td>
                        <td><?php echo center_premises($applicant_value->Premises); ?></td>
                        <td style="text-align: center;"><?php echo $applicant_value->OwnerProfession; ?></td>
                        <td style="text-align: center;"><?php echo $applicant_value->TIN; ?></td>
                        <td style="text-align: center;"><?php echo $applicant_value->Mobile1; ?></td>
                        <td style="text-align: center;"><?php echo number_format($applicant_value->amount); ?></td>
                        <!-- <td style="text-align: center;"><?php echo get_country($applicant_value->Nationality,'Name'); ?></td> -->
                        <!-- <td style="text-align: center;"><?php echo application_status($applicant_value->submitted); ?></td> -->
                        <td>
                        <?php
                            if(isset($applicant_value->submitted) and $applicant_value->submitted!='')
                            {
                                if($applicant_value->submitted==2){
                                    echo '<a href="javascript:void(0);" style="display: block; color: red;" class="approvalstatus" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->submitted.'" SELECTED_VALUE="'.application_status($applicant_value->submitted).'" >'.application_status($applicant_value->submitted);

                                }else{
                                echo '<a href="javascript:void(0);" style="display: block;" class="approvalstatus" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->submitted.'" SELECTED_VALUE="'.application_status($applicant_value->submitted).'" >'.application_status($applicant_value->submitted);

                                }
                            }
                            else
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="approvalstatus" ID="'.$applicant_value->id.'" CenterName="'.$applicant_value->CenterName.'" CenterOwner="'.$applicant_value->CenterOwner.'" CenterCordinator="'.$applicant_value->CenterCordinator.'" SELECTED_ID="'.$applicant_value->submitted.'" SELECTED_VALUE="'.$applicant_value->submitted.'">'.'WAITING';

                            }                         
                               ?></a> 
                        
                         </td>


                        <!-- <td style="text-align: center;" title="<?php echo $check_tcu_status->description;  ?>" > <?php echo ($check_tcu_status->status==200) ?  $tcu : "<a href='".site_url('AddApplicantTCU/'.$applicant_value->id.'/'.$applicant_value->entry_category)."'> ".$tcu."</a>"; ?></td> -->
                        <td style="text-align: left;"><?php  echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_info" ID="'.encode_id($applicant_value->id).'" 
                         title="'.$applicant_value->CenterName.'"><i class="fa fa-eye"></i> View</a>'; ?></td>
                        <!-- <td style="text-align: center;"><?php echo $round; ?></td> -->
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>

        <!-- <a href="<?php echo site_url('report/export_applicant/?'.((isset($_GET) && !empty($_GET)) ? http_build_query($_GET):'') ); ?>" class="btn btn-sm btn-success">Export Excel</a> -->
    </div>
</div>

<script>
    $(document).ready(function () {


        $("body").on("click",".popup_applicant_entrytype",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var CenterName = $(this).attr("CenterName");
            var CenterOwner = $(this).attr("CenterOwner");
            var CenterCordinator = $(this).attr("CenterCordinator");


           $.confirm({
                title:'Change application_type for : '+CenterName,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Selected Category :</label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Change to : <span class="required">*</span></label><div class="col-lg-8">'+
                '<select class="form-control" id="new_category" name="new_category"><option value="">--Select New Type--</option>'
                <?php foreach (center_application() as $k=>$v){  ?>
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
                    var application_type = this.$content.find("#new_category").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(application_type != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_entry_mode') ?>',
                            type: 'post',
                            data: {
                                new_category: application_type,
                                applicant_id: applicant_id
                            },
                            success: function () {
                            console.log(new_category);
                                        
                                window.location.reload();
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select new application_type...");
                    }
                    return false;
                },
                cancel:function () {
                    return true;
                }

                
            });
        });


        $("body").on("click",".approvalstatus",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var CenterName = $(this).attr("CenterName");
            var CenterOwner = $(this).attr("CenterOwner");
            var CenterCordinator = $(this).attr("CenterCordinator");


           $.confirm({
                title:'Change approval status for : '+CenterName+''+applicant_id,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Selected Status :</label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Change to : <span class="required">*</span></label><div class="col-lg-8">'+
                '<select class="form-control" id="approval_status" name="approval_status"><option value="">--Select Status--</option>'
                <?php foreach (application_status() as $k=>$v){  ?>
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
                    var approval_status = this.$content.find("#approval_status").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(approval_status != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/center_approval_status') ?>',
                            type: 'post',
                            data: {
                                approval_status: approval_status,
                                applicant_id: applicant_id
                            },
                            success: function () {
                            console.log(approval_status);
                                        
                                window.location.reload();
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select approval status...");
                    }
                    return false;
                },
                cancel:function () {
                    return true;
                }

                
            });
        });

        $("body").on("click",".center_regno",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var CenterName = $(this).attr("CenterName");
            var CenterOwner = $(this).attr("CenterOwner");
            var CenterCordinator = $(this).attr("CenterCordinator");


           $.confirm({
                title:'Center Name : '+CenterName,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Assigned RegNo. </label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Assign RegNo. : <span class="required">*</span></label><div class="col-lg-8">'+
                '<input class="form-control" id="center_regno" name="center_regno" placeholder="--Enter Registration Number--"/>'
                +'</div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var center_regno = this.$content.find("#center_regno").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(center_regno != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_center_regno') ?>',
                            type: 'post',
                            data: {
                                center_regno: center_regno,
                                applicant_id: applicant_id
                            },
                            success: function () {
                                // console.log(center_regno);
                              window.location.reload();

                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select...");
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
               content:"URL:<?php echo site_url('popup_center_info') ?>/"+ID+'/?status=1',
               confirmButton:'Print',
               columnClass:'col-md-10 col-md-offset-2',
               cancelButton:'Close',
               extraButton:'ExtraB',
               cancelButtonClass: 'btn-success',
               confirmButtonClass: 'btn-success',
               confirm:function () {
                   window.location.href = '<?php echo site_url('center_print_application') ?>/'+ID;
                   return false;
               },
               cancel:function () {
                   return true;
               }

           });
       })


    });
</script>

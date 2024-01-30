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
        <?php echo form_open(site_url('applicant_list_iposa'), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
<!--            <div class="col-md-1" style="padding-left: 0px;">-->
<!--                <input type="text" value="--><?php //echo(isset($_GET['key']) ? $_GET['key'] : '') ?><!--" name="key"-->
<!--                       class="form-control" placeholder="Search....">-->
<!--            </div>-->
            <div class="col-md-2">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/>

            </div>

            <div class="col-md-2">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/>
            </div>


            <div class="col-md-2">
                <select name="vituo" class="form-control">
                    <option value="">[ Vituo vyote ]</option>
                    <?php

                    $vituo=$this->db->query("select * from iposa_vituo")->result();

                    foreach ($vituo as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['vituo']) ? ($_GET['vituo'] == $tvalue->id ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tvalue->id; ?>"><?php echo $tvalue->name ?></option>
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
                    <th style="width: 100px; text-align: center;">Date</th>
                    <th style="width: 200px;">RegNo</th>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 60px;">Gender</th>
                    <th style="width: 80px; text-align: center;">education</th>
                    <th style="width: 100px; text-align: center;">Region</th>
                    <th style="width: 80px; text-align: center;">District</th>
                    <th style="width: 80px; text-align: center;">Kituo</th>

<!--                    <th style="width: 60px;">Attachment</th>-->
                    <th style="width: 60px;">Action</th>
                    <th style="width: 60px;">Print</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $page = ($this->uri->segment(2) ? ($this->uri->segment(2)+1):1 );
                foreach ($applicant_list as $applicant_key => $applicant_value) {


                    ?>
                    <tr>
                      <td style="text-align: right;"><?php  echo $page++; ?></td>
                        <td style="text-align: center;"><?php  echo $applicant_value->createdon; ?></td>
                        <td style="text-align: center;"><?php  echo $applicant_value->registrationnumber; ?></td>
                      <td style="text-align: left;"><?php  echo $applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName; ?></td>
                        <td style="text-align: center;"><?php  echo $applicant_value->Gender; ?></td>

                        <td style="text-align: center;"><?php  echo iposa_eduction_type($applicant_value->education); ?></td>
                        <td style="text-align: center;"><?php  echo get_value('regions',$applicant_value->region); ?></td>
                        <td style="text-align: center;"><?php  echo get_value('districts',$applicant_value->district); ?></td>
                        <td style="text-align: center;"><?php  echo get_value('iposa_vituo',$applicant_value->kituoname); ?></td>
<!--                        <td>-->
<!--                            <a href="javascript:void(0);" class="view_image"-->
<!--                               title="--><?php //echo($applicant_value->filename)?$applicant_value->filename:'Attachment' ; ?><!--" W="900" H="500"-->
<!--                               type="--><?php //echo get_file_mimetype($applicant_value->attachment); ?><!--"-->
<!--                               url="--><?php //echo HTTP_UPLOAD_FOLDER . 'attachment/' . $applicant_value->attachment ?><!--">-->
<!--                                <i class="fa fa-eye">View</i>-->
<!--                            </a>-->
<!--                        </td>-->

                        <td >
                            <?php  echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_info" ID="'.encode_id($applicant_value->id).'" 
                      title="'.$applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName.'"><i class="fa fa-eye"></i> View</a>'; ?>
                        </td>

                        <td style="text-align: left;"><a href=" <?php echo  site_url('print_application_iposa/'.encode_id($applicant_value->id)); ?>/"<i class="fa fa-print   "></i>Print</a></td>

                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>

<!--        <a href="--><?php //echo site_url('report/export_applicant/?'.((isset($_GET) && !empty($_GET)) ? http_build_query($_GET):'') ); ?><!--" class="btn btn-sm btn-success">Export Excel</a>-->
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


       $("body").on("click",".popup_applicant_info",function () {
           var ID = $(this).attr("ID");
           var title = $(this).attr("title");
           $.confirm({
               title:title,
               content:"URL:<?php echo site_url('popup_iposa_info') ?>/"+ID+'/?status=1',
               confirmButton:'Print',
               columnClass:'col-md-10 col-md-offset-2',
               cancelButton:'Close',
               extraButton:'ExtraB',
               cancelButtonClass: 'btn-success',
               confirmButtonClass: 'btn-success',
               confirm:function () {
                   window.location.href = '<?php echo site_url('print_application_iposa') ?>/'+ID;
                   return false;
               },
               cancel:function () {
                   return true;
               }

           });
       })

<!--        --><?php //if(!is_section_used('SUBMIT',$APPLICANT_MENU)){ ?>
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

    $(".view_image").click(function () {
        var title = $(this).attr("title");
        var url = $(this).attr("url");
        var type = $(this).attr("type");
        var width = $(this).attr("W");
        var height = $(this).attr("H");

        var model = $("#myModal");
        model.find(".modal-content").css({
            height: (parseInt(height) + 120) + "px",
            width: (parseInt(width) + 5) + "px"
        });
        model.find("#model_header").html(title);
        model.find("#model_header").show();

        var object = '<object data="{FileName}" type="' + type + '" width="' + width + 'px" height="' + height + 'px">';
        object += 'If you are unable to view file, you can download from <a href="{FileName}">here</a>';
        object += '</object>';
        object = object.replace(/{FileName}/g, url);
        model.find("#modal_body").css({height: height + "px", width: width + "px", padding: 0});
        model.find("#modal_body").html(object);
        model.find("#model_footer").show();
        model.modal();
    });
</script>

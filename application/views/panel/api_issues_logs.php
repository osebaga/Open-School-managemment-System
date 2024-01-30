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

    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Applicant with API Issues</h5>
    </div>
    <div class="ibox-content">
        <?php echo form_open(site_url('logs/api_issues'), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
            <div class="col-md-5 col-md-offset-2" style="padding-left: 0px;">
                <input type="text" value="<?php echo(isset($_GET['key']) ? $_GET['key'] : '') ?>" name="key"
                       class="form-control" placeholder="Search....">
            </div>

            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>
        <?php echo form_close();
        ?>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" class="table table-bordered" style="" id="applicantlist">
                <thead>
                <tr>
                    <th style="width: 30px; text-align: center">S/No</th>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 150px;">Certificate</th>
                    <th style="width: 100px;">Authority</th>
                    <th style="width: 100px;">Index Number</th>
                    <th style="width: 100px;">AVN</th>
                    <th style="width: 250px;">Description</th>
                    <th style="width: 60px;">Action</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $page = ($this->uri->segment(3) ? ($this->uri->segment(3)+1):1 );
                foreach ($applicant_list as $applicant_key => $applicant_value) {
                    ?>
                    <tr>
                        <td style="text-align: right;"><?php  echo $page++; ?></td>
                        <td style="text-align: left;"><?php  echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_info" ID="'.encode_id($applicant_value->applicant_id).'" 
                      title="'.$applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName.'">'. $applicant_value->FirstName.' '.$applicant_value->MiddleName.' '.$applicant_value->LastName; ?></a></td>
                        <td><?php echo entry_type_certificate($applicant_value->certificate); ?></td>
                        <td><?php echo $applicant_value->exam_authority; ?></td>
                        <td><?php echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_edit" ID="'.$applicant_value->applicant_id.'" 
                      firstname="'.$applicant_value->FirstName.'" middlename="'.$applicant_value->MiddleName.'" lastname="'.$applicant_value->LastName.'">'.$applicant_value->index_number; ?></a></td>
                        <td><?php echo $applicant_value->avn; ?></td>
                        <td title='<?php echo $applicant_value->response; ?>'><?php echo $applicant_value->comment; ?></td>
                        <th style="width: 60px;"><a href="<?php echo site_url('logs/retry/'.encode_id($applicant_value->id)) ?>">Retry</a></th>

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

<script>
    $(document).ready(function () {
        $("body").on("click",".popup_applicant_edit",function () {
            var applicant_id = $(this).attr("ID");
            var firstname = $(this).attr("firstname");
            var middlename = $(this).attr("middlename");
            var lastname = $(this).attr("lastname");
            $.confirm({
                title:'Edit Applicant Names',
                content:'<div class="col-md-12 form-horizontal">' +
                 '<div class="form-group"><label class="col-lg-3 control-label">First Name : <span class="required">*</span></label><div class="col-lg-8">'+
                    '<input type="text" value="'+firstname+'" class="form-control" id="firstname" name="firstname"></div></div>'
                    + '<div class="form-group"><label class="col-lg-3 control-label">Middle Name : <span class="required">*</span></label><div class="col-lg-8">'+
                '<input type="text" value="'+middlename+'" class="form-control" id="middlename" name="middlename"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Last Name : <span class="required">*</span></label><div class="col-lg-8">'+
                '<input type="text" value="'+lastname+'" class="form-control" id="lastname" name="lastname"></div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                extraButton:'ExtraB',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                 var firstname = this.$content.find("#firstname").val();
                 var middlename = this.$content.find("#middlename").val();
                 var lastname = this.$content.find("#lastname").val();
                 this.$content.find("#errordiv").html("Please wait......");
                 $.ajax({
                     url:'<?php echo site_url('logs/change_name') ?>',
                     type:'post',
                     data:{firstname:firstname,middlename:middlename,lastname:lastname,applicant_id:applicant_id},
                     success:function () {
                         window.location.reload();
                     }
                 })
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
    });
</script>

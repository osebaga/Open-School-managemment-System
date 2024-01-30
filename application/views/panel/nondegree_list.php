<?php
$current_print_title="Non Degree LIST";
$current_file_name="nondegree_list".date("Y-m-d");
$current_pdf_orientation="portrait";//landscape or portrait
$current_column_visibility=":visible";// "" or :visible
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}


?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Non Degree Students  List</h5>
<!--        <div style="text-align: right;"><a style="font-size: 11px; text-decoration: underline;"-->
<!--                                           href="--><?php //echo site_url('renotify/?resend=1'); ?><!--">Resend notification by-->
<!--                Email</a></div>-->
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
<!--        <div class="form-group no-padding">-->
<!---->
<!---->
<!---->
<!---->
<!--            <div  class=" col-sm-offset-2 col-md-3">-->
<!--                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input"-->
<!--                       value="--><?php //echo(isset($_GET['from']) ? $_GET['from'] : '') ?><!--"/>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div class="col-md-3">-->
<!--                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input"-->
<!--                       value="--><?php //echo(isset($_GET['to']) ? $_GET['to'] : '') ?><!--"/>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-1">-->
<!--                <input type="submit" value="Search" class="btn btn-success btn-sm">-->
<!--            </div>-->
<!--        </div>-->
       
        <hr>
        <div class="row">
<!--            <div class="col-md-6">-->
<!--                <a style="float:left"-->
<!--                   href="--><?php //echo site_url('report/export_member/?' . ((isset($_GET) && !empty($_GET)) ? http_build_query($_GET) : '')); ?><!--"-->
<!--                   class="btn btn-sm btn-success">Export Excel</a>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <p style="">--><?php //echo $pagination_links; ?><!--</p>-->
<!--            </div>-->


            <div style="clear: both;"></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">

                <thead>
                    <tr>
                        <th><div>S/No</div></th>
                        <th>Date</th>
                        <th>F4 Index Number</th>
                        <th>F6 Index Number</th>
                        <th>Status Code</th>
                        <th>Descriptions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                   $i=0;
                    foreach ($nondegree_list as $key => $value) {
                        $i=$i + 1;
                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $i; ?></td>
                            <td style="text-align: left;"><?php echo $value->date; ?></td>
                            <td style="text-align: left;"><?php echo $value->f4indexno; ?></td>
                            <td style="text-align: left;"><?php echo $value->f6indexno; ?></td>
                            <td style="text-align: left;"><?php echo $value->status_code; ?></td>
                            <td style="text-align: left;"><?php echo $value->status_description; ?></td
                        </tr>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <?php echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Edit Academic Year Modal -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="title"></h4>
            </div>
            <div class="modal-body">

                <form id="form_updated_academic_term" action="" method="post">
                    <div class="form-group" style="display:none">
                        <label class="control-label" for="id">Iterm ID</label>
                        <input type="text" id="id" name="id" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id">Academic Term</label>
                        <input type="text" id="term" name="term" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id">Academic Term</label>
                        <!-- <input type="text" id="term" name="term" class="form-control" /> -->
                        <select name="professional_category" id="term" class="form-control" <?php echo(isset($professional_category) ? 'disabled' : '') ?> >
                            <option value=""> [ Select professional category ]</option>
                            <?php
                            // $cat = 1;
                            foreach (application_type() as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">No</button>
                <button type="submit" id="submit_form_term_update" class="btn btn-success pull-left crud-submit-edit">Confirm</button>
                <button type="button" id="term_update_feedback" style="display: none" class="btn btn-success pull-right"><span id="term_update_feedback_msg"></span></button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
       $("document").on("click",".print_invoice",function () {
           alert('nipooo');
           var ID = $(this).attr("ID");
                   window.location.href = '<?php echo site_url('print_invoice') ?>/'+ID;
           });
       })
    });



    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Approve application');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#id').val($(this).data('id'));
        $('#term').val($(this).data('term'));
        $('#myModalEdit').modal('show');


    });
</script>
<input type="hidden" id="txtColumnVisibility" name="txtColumnVisibility" value="<?php echo $current_column_visibility; ?>" >
<input type="hidden" id="txtCurrentFilename" name="txtCurrentFilename" value="<?php echo $current_file_name; ?>" >
<input type="hidden" id="txtPaperOrientation" name="txtPaperOrientation" value="<?php echo $current_pdf_orientation; ?>" >
<input type="hidden" id="txtCurrTitle" name="txtCurrTitle" value="<?php echo $current_print_title; ?>" >


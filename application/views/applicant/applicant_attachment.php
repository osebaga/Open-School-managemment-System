<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Attachment</h5>
            <?php
            if($APPLICANT->status == 0 && !isset($_GET['action'])) {
                ?>

                <a class="pull-right" style="text-decoration: underline; font-weight: bold;"
                   href="<?php echo site_url('applicant_attachment'); ?>/?action=new">Add New Attachment</a>


                <?php
            }

            ?>
        </div>
    </div>

    <div class="ibox-content">

        <div  style="margin-bottom: 15px; color: green; font-weight: bold;">
            Please use scanned Document in pdf format to upload.Failure to that your application will be rejected.
            
        </div>

        <style>
            #mytable thead tr th {
                background-color: transparent;
                font-weight: bold;
            }

            .mytable2_educatiobbg {
                margin-left: 20px;
            }

            .mytable2_educatiobbg tr th, .mytable2_educatiobbg tr td {
                padding: 4px;;
            }
        </style>

        <?php
       if(!$this->uri->segment(2) && (isset($action) || !isset($action)) ) {
           echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid myform"') ?>

        <div class="text-center" style="font-weight: bold;">
            <?php
             if($APPLICANT->application_category=='Center') {
              if($APPLICANT->Premises==1)
              {
                echo 'Ownership of Open School Premises : Rented';
              }elseif($APPLICANT->Premises==2)
              {
                echo 'Ownership of Open School Premises : Personal property';
              }else{
                echo 'Ownership of Open School Premises : Government/CBOs';
              }
             }
               ?>

        </div>
           <div class="form-group"><label class="col-lg-3 control-label">Certificate : <span
                       class="required">*</span></label>

               <div class="col-lg-8">
                   <select name="certificate" class="form-control">
                       <option value=""> [ Select Certificate ]</option>
                       <?php
                       $sel = set_value('certificate');
                       foreach ($certificate_list as $key => $value) {
                           ?>
                           <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                               value="<?php echo $key; ?>"><?php echo $value; ?></option>
                           <?php
                       }
                       ?>
                   </select>
                   <?php echo form_error('certificate'); ?>
               </div>
           </div>
           <!-- <div class="form-group"><label class="col-lg-3 control-label">Certificate : <span
                       class="required">*</span></label>

               <div class="col-lg-8">
               ASEP<a href="../../../uploads/docs/Import_Sponsored_Student.xlsx" download="newfilename">Download the pdf</a>

               </div>
           </div> -->
<!-- 
           <div class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
                <a href="../../../uploads/docs/Import_payment.xlsx">Download Template</a>
            </div> -->
        <!-- </div> -->
           <div class="form-group disabledata"><label class="col-lg-3 control-label">Attach Certificate <span
                       class="required">*</span> : </label>

               <div class="col-lg-8">
                   <input type="file" name="file1" class="form-control"/>
                   <?php echo(form_error('file1') ? form_error('file1') : (isset($upload_error) ? '<div class="required">' . $upload_error . '</div>' : ''));

                   ?>
               </div>
           </div>

           <div class="form-group"><label class="col-lg-3 control-label">Comment : </label>

               <div class="col-lg-8">
                   <textarea class="form-control" name="comment"><?php echo set_value('comment'); ?></textarea>
                   <?php echo form_error('comment'); ?>
               </div>
           </div>


           <div class="form-group">
               <div class="col-lg-10 clearfix">
                   <?php if ($APPLICANT->id) { ?>
                       <input class="btn  btn-success pull-right" type="submit"
                              value="Save Information"/>
                   <?php } ?>
               </div>
           </div>

           <?php echo form_close();

       }
        if (!isset($_GET['action']) && count($attachment_list) > 0) {


            ?>

            <table class="table table-bordered " id="mytable">
                <thead>
                <tr>
                    <th style="width: 50px;">S/No</th>
                    <th style="width: 150px;">Certificate</th>
                    <th>Comment</th>
                    <th style="width: 100px;">Attachment</th>
                    <?php if($APPLICANT->status == 0){  ?>
                        <th style="width: 100px;">Action</th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($attachment_list as $rowkey => $rowvalue) { ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: center;"><?php echo ($rowkey+1); ?></td>
                        <?php
                         if($APPLICANT->application_category=='Center') {?>
                        <td><?php echo center_owner_attachment($rowvalue->certificate) ?></td>
                        <?php }else{ ?>
                        <td><?php echo entry_type_certificate($rowvalue->certificate) ?></td>
                        <?php } ?>
                        <td><?php echo  $rowvalue->comment ?></td>
                        <td><a href="javascript:void(0);" class="view_image" title="<?php echo $rowvalue->filename; ?>" W="800" H="500" type="<?php echo get_file_mimetype($rowvalue->attachment) ?>" url="<?php echo HTTP_UPLOAD_FOLDER.'attachment/'.$rowvalue->attachment ?>"><i class="fa fa-eye"></i> View</a></td>
                        <?php if($APPLICANT->status == 0){  ?>
                            <td><a href="<?php echo site_url('applicant_attachment/'.encode_id($APPLICANT->id)) ?>/?rmv=<?php echo $rowvalue->id; ?>" class="remove_delete"><i class="fa fa-remove"></i> Remove</a></td>
                        <?php } ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>


            </table>


            <?php


        }

        ?>

        <!-- <?php if(is_section_used('EDUCATION',$APPLICANT_MENU)){ ?>
            <div style="text-align: right; margin-right: 30px;"><a href="<?php echo site_url('applicant_choose_programme') ?>" class="btn btn-sm btn-success"><i class="fa fa-angle-double-right"></i> Next Step</a></div>
        <?php } ?> -->


    </div>
</div>


<script>
    $(document).ready(function () {

        $("body .remove_delete").confirm({
            title:"Confirm Deletion",
            content: "Are you sure you want to remove selected data ? ",
            confirmButton:'YES',
            cancelButton:'NO',
            confirmButtonClass: 'btn-success',
            cancelButtonClass: 'btn-success'
        });


        $(".view_image").click(function () {
            var title = $(this).attr("title");
            var url = $(this).attr("url");
            var type = $(this).attr("type");
            var width = $(this).attr("W");
            var height = $(this).attr("H");

            var model = $("#myModal");
            model.find(".modal-content").css({height:(parseInt(height)+120)+"px",width:(parseInt(width)+5)+"px"});
            model.find("#model_header").html(title);
            model.find("#model_header").show();

            var object = '<object data="{FileName}" type="'+type+'" width="'+width+'px" height="'+height+'px">';
            object += 'If you are unable to view file, you can download from <a href="{FileName}">here</a>';
            object += '</object>';
            object = object.replace(/{FileName}/g, url);
            model.find("#modal_body").css({height:height+"px",width:width+"px",padding:0});
            model.find("#modal_body").html(object);
            model.find("#model_footer").show();
            model.modal();
        });

    })
</script>
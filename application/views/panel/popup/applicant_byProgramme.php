<div style=" padding: 10px 0px;">
    <table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 5%; text-align: center">S/No</th>
        <th style="width: 15%;" title="Form IV">Index No</th>
        <th style="width: 20%;">Applicant Name</th>
        <th style="width: 5%; text-align: center;">Sex</th>
        <th style="width: 10%; text-align: center;">Mobile</th>
        <th style="width: 10%;">Entry Type</th>
        <th style="width: 5%;">Duration</th>
        <th style="width: 5%; text-align: center;">Choice#</th>
        <th style="width: 5%; text-align: center;">Point</th>
        <th style="width: 5%; text-align: center;">Eligibility</th>
        <th style="width: 20%;">Remark</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($applicant_list as $key=>$value){ ?>

        <tr>
            <td style="text-align: right;"><?php echo $key+1; ?>. </td>
            <td style="text-align: left;"><?php echo '<a href="javascript:void(0);" style="display: block;" class="popup_applicant_info" ID="'.encode_id($value->id).'" 
                      title="'.$value->FirstName.' '.$value->MiddleName.' '.$value->LastName.'">'. $value->form4_index.'</a>'; ?></td>
            <td style="text-align: left;"><?php echo $value->FirstName.' '.$value->MiddleName.' '.$value->LastName; ?> </td>
            <td style="text-align: center;"><?php echo $value->Gender ; ?> </td>
            <td style="text-align: center;"><?php echo str_replace(' ','',$value->Mobile1) ; ?> </td>
            <td style="text-align: left;"><?php echo entry_type_human($value->entry_category); ?></td>
            <td style="text-align: center;"><?php echo $value->duration; ?></td>
            <td style="text-align: center;"><?php echo $value->choice; ?></td>
            <td style="text-align: center;"><?php echo $value->point; ?></td>
            <td style="text-align: center;"><?php echo ($value->eligible == 1 ? 'Yes':'No'); ?></td>
            <td style="text-align: left;"><?php echo$value->comment; ?></td>
        </tr>

        <?php } ?>
    </tbody>
</table>



</div>

<style>
      .jconfirm.jconfirm-bootstrap .jconfirm-box .buttons{
        padding: 10px;
    }
      .jconfirm.jconfirm-bootstrap .jconfirm-box .buttons button:first-child{
          margin-right: 15px;
      }

</style>


<script>
    $(document).ready(function () {
        $(".popup_applicant_info").click(function () {
            var ID = $(this).attr("ID");
            var title = $(this).attr("title");
            $.confirm({
                title:title,
                content:"URL:<?php echo site_url('popup_applicant_info') ?>/"+ID+'',
                confirmButton:'Print',
                columnClass:'col-md-10 col-md-offset-2',
                cancelButton:'Close',
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

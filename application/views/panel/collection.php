<?php
$ayear = $this->common_model->get_academic_year()->row()->AYear;

if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');


}
if (isset($_GET)) {
    $title1 = '';
    if (isset($_GET['key']) && $_GET['key'] <> '') {
        $title1 .= " Searching Key :<strong>     " . $_GET['key'] . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['from']) && $_GET['from'] <> '') {
        $title1 .= " From :<strong> " .  date_format($_GET['from']) . '</strong> &nbsp; &nbsp; &nbsp;';
    }

    if (isset($_GET['to']) && $_GET['to'] <> '') {
        $title1 .= " Until :<strong> " . date_format($_GET['to']) . '</strong>';
    }

    if (isset($_GET['ayear']) && $_GET['ayear'] <> '') {
        $title1 .= " Academic Year :<strong> " . $_GET['ayear'] . '</strong> &nbsp; &nbsp; &nbsp;';
    }else{
        $title1 .= " Academic Year :<strong> " .$ayear . '</strong> &nbsp; &nbsp; &nbsp;';

    }

    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title clearfix">
        <h5>Application Collection Fee</h5>
        <span class="pull-right" style="font-weight: bold; color: brown;">
            Amount Collected : <?php
            $query="SELECT SUM(p.amount) as amount FROM application_payment as p LEFT JOIN application as a ON (p.applicant_id=a.id) WHERE 1=1";
            if (isset($_GET['ayear']) && $_GET['ayear'] <> '')
            {
                $current_year=trim($_GET['ayear']);
                $query.=" AND a.AYear='".trim($_GET['ayear'])."'";
                          //    echo number_format($this->db->query("SELECT SUM(p.amount) as amount FROM application_payment as p INNER JOIN application as a ON (p.applicant_id=a.id) WHERE p.AYear='$ayear' AND p.msisdn <> ''")->row()->amount,2);

            }else{
                $query.=" AND a.AYear='".$ayear."'";
                $current_year=$ayear;
            }

            if (isset($_GET['from']) && $_GET['from'] <> '') {

                $query .= " AND DATE(p.createdon) >='" . format_date($_GET['from']) . "' ";

            }

            if (isset($_GET['to']) && $_GET['to'] <> '') {

                $query .= " AND DATE(p.createdon) <='" . format_date($_GET['to']) . "' ";

            }
                        echo number_format($this->db->query($query)->row()->amount,2);


            ?>
        </span>
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
            <div class="col-md-3" style="padding-left: 0px;">
                <input type="text" value="<?php echo(isset($_GET['key']) ? $_GET['key'] : '') ?>" name="key"
                       class="form-control" placeholder="Type to search....">
            </div>
            <div class="col-md-3">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/>

            </div>
            <div class="col-md-3">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input" value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/>
              </div>
              <div class="col-md-2">
                    <select name="ayear" class="form-control" value="<?php echo(isset($_GET['ayear']) ? $_GET['ayear'] : '') ?>">

                        <?php
                        $ayears =  $this->db->query("select * from ayear")->result();
                        foreach ($ayears as $key => $value) {
                            ?>
                            <option <?php echo($current_year==$value->AYear ? 'selected="selected"' : '') ?>
                             value="<?php echo $value->AYear; ?>"><?php echo $value->AYear; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php echo form_error('ayear'); ?>
              </div>
            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>
        <?php echo form_close();
        ?>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" class="table table-bordered"
                   style="" id="datatable">
                <thead>
                <tr>
                    <th style="width: 30px; text-align: center">S/No</th>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 150px; text-align: center;">Time</th>
                    <th style="width: 100px; text-align: center;">Receipt</th>
                    <th style="width: 100px; text-align: center;">Mobile Used</th>
                    <th style="width: 100px; text-align: center;">Amount</th>
                    <th style="width: 100px; text-align: center;">Charge</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $page = ($this->uri->segment(2) ? ($this->uri->segment(2)+1):1);
                foreach ($collection_list as $key => $value) {
                    ?>
                    <tr>
                        <td style="text-align: right;"><?php  echo $page++; ?></td>
                        <td style="text-align: left;"><?php  echo $value->FirstName.' '.$value->MiddleName.' '.$value->LastName; ?></td>
                        <td style="text-align: center;"><?php  echo $value->createdon; ?></td>
                        <td style="text-align: center;"><?php echo $value->receipt; ?></td>
                        <td style="text-align: center;"><?php echo $value->msisdn; ?></td>
                        <td style="text-align: right;"><?php echo number_format($value->amount); ?></td>
                        <td style="text-align: right;"><?php echo number_format($value->charges,2); ?></td>
                    </tr>

                    <?php  } ?>
                </tbody>
            </table>


            <h2 align="center" style="font-weight: bold; color: brown;"> Total Amount <?php echo number_format($total_amount,0); ?></h2>
            <h2 align="center" style="font-weight: bold; color: brown;"> Total Charges <?php echo number_format($total_charges,0); ?></h2>
           <!-- <div><?php /*echo $pagination_links; */?>
                <div style="clear: both;"></div>
            </div>-->
            <a href="<?php echo site_url('report/export_collection/?'.((isset($_GET) && !empty($_GET)) ? http_build_query($_GET):'') ); ?>" class="btn btn-sm btn-success">Export Excel</a>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
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

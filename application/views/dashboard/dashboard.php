<?php
$ayear = $this->common_model->get_academic_year()->row()->AYear;
$monthly_data = $this->db->query("select sum(paid_amount) as amount from payment where a_year='$ayear'  ")->row();
$account_year=$this->common_model->get_account_year()->row()->AYear;

?>
    <!-- GLOBAL MAINLY STYLES-->
<?php
if( get_user_group()->id!=8)
{
?>
<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="widget style1 navy-bg">
            <span style="font-size: 13px;" class="font-bold">ACCOUNT CREATED</span>
            <h2 style="font-size: 20px;" class="font-bold text-right"><?php echo number_format($this->db->query("SELECT count(id) as counter FROM application WHERE AYear='$ayear' ")->row()->counter); ?></h2>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="widget style1 blue-bg">
            <span style="font-size: 13px;" class="font-bold">APPLICATION SUBMITTED</span>
            <h2 style="font-size: 20px;" class="font-bold text-right"><?php echo number_format($this->db->query("SELECT count(id) as counter FROM application WHERE AYear='$ayear' AND submitted=1 ")->row()->counter); ?></h2>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="widget style1 yellow-bg">
            <span style="font-size: 13px;" class="font-bold">NO. OF APPLICATION PAID</span>
            <h2 style="font-size: 20px;" class="font-bold text-right"><?php echo number_format($this->db->query("SELECT count(p.id) as counter FROM payment as p inner join application as a  ON (p.student_id=a.id) WHERE a.AYear='$ayear' ")->row()->counter); ?></h2>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="widget style1 red-bg">
            <span style="font-size: 13px;" class="font-bold">FEE COLLECTED</span>
            <h2 style="font-size: 20px;" class="font-bold text-right"><?php echo number_format($this->db->query("SELECT SUM(p.paid_amount ) as amount FROM payment as p inner JOIN application as a ON (p.student_id=a.id) WHERE a.AYear='$ayear' ")->row()->amount); ?></h2>
        </div>
    </div>
</div>
<?php } ?>
<?php
if( get_user_group()->id!=8) {
    ?>

    <div class="row">

        <div class="ibox">
            <div class="ibox-content">
                <h3>Applicant Choice By Programmes</h3>
                <?php
                $programme_list = $this->common_model->get_programme()->result();
                ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">S/No</th>
                        <th>Programme Name</th>
                        <th style="width: 100px; text-align: center;">1<sup>st</sup> Choice</th>
                        <th style="width: 100px; text-align: center;">2<sup>nd</sup> Choice</th>
                        <th style="width: 100px; text-align: center;">3<sup>rd</sup> Choice</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($programme_list as $key => $value) {
                        $first_choice = $this->db->query("SELECT COUNT(id) as counter FROM application_programme_choice WHERE choice1='$value->Code' AND AYear='$ayear' ")->row();
                        $second_choice = $this->db->query("SELECT COUNT(id) as counter FROM application_programme_choice WHERE choice2='$value->Code' AND AYear='$ayear'")->row();
                        $third_choice = $this->db->query("SELECT COUNT(id) as counter FROM application_programme_choice WHERE choice3='$value->Code' AND AYear='$ayear'")->row();

                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo($key + 1) ?>.</td>
                            <td><?php echo $value->Name; ?></td>
                            <td style="text-align: right;"><?php echo number_format($first_choice->counter); ?></td>
                            <td style="text-align: right;"><?php echo number_format($second_choice->counter); ?></td>
                            <td style="text-align: right;"><?php echo number_format($third_choice->counter); ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    <?php
}
if( get_user_group()->id==8)
{
?>
<br/>
<div class="page-wrapper">

    <div >
        <!-- START PAGE CONTENT-->
        <div  >
            <div class="row mb-4">
                <div class="col-lg-4 col-sm-6">
                    <div class="card ibox ">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="73" data-bar-color="#18C5A9" data-size="80" data-line-width="8">
                                <span class="easypie-data text-success" style="font-size:28px;"><i class="ti-shopping-cart"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-success"><?PHP echo $this->db->query("select count(id) as bill_count from invoices where DATE (timestamp)='".date('Y-m-d')."'")->row()->bill_count; ?></h3>
                                <div class="text-muted">TODAY'S BIlLS CREATED</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card ibox ">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="42" data-bar-color="#5c6bc0" data-size="80" data-line-width="8">
                                <span class="easypie-data text-primary" style="font-size:32px;"><i class="la la-money"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-primary">TZS <?PHP   echo number_format($this->db->query("select sum(paid_amount) as amount from payment where  SUBSTRING(transaction_date,1,10)='".date('Y-m-d')."'")->row()->amount); ?></h3>
                                <div class="text-muted">TODAY'S COLLECTED PAYMENTS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card ibox ">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="70" data-bar-color="#ff4081" data-size="80" data-line-width="8">
                                <span class="easypie-data text-pink" style="font-size:32px;"><i class="la la-users"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-pink"><?php echo $today_upaid_bills= $this->db->query("select count(id) as bill_count from invoices where  DATE (timestamp)='".date('Y-m-d')."' and status<>2")->row()->bill_count;?></h3>
                                <div class="text-muted">TODAY'S UNPAID BILLS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .space {
                    padding-left: 13px;
                    padding-right: 0px;
                    margin-top: 10px;
                }
                div.card {
                    box-shadow: 0 1px 8px 0 rgba(0, 0, 0, 0.2), 3px 1px 2px 5px rgba(220, 220, 220, 0.19);
                    text-align: center;
                    width: 100%;
                }
                .card-body {
                    border: 2px solid #cddce2;
                }
                .highcharts-figure, .highcharts-data-table table {
                    min-width: 310px;
                    max-width: 800px;
                    margin: 1em auto;
                }

                #container {
                    height: 400px;
                }

                .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #EBEBEB;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }
                .highcharts-data-table caption {
                    padding: 1em 0;
                    font-size: 1.2em;
                    color: #555;
                }
                .highcharts-data-table th {
                    font-weight: 600;
                    padding: 0.5em;
                }
                .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
                    padding: 0.5em;
                }
                .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                }
                .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                }
                figure > div {
                    width:98%;
                }

            </style>

            <div class="row contai ner-fluid">
                <div class="col-md-6 space">
                    <div class="card card-body">
                        <figure class="highcharts-figure w-100">
                            <div id="collection_this_month"></div>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 space">
                    <div class=" card card-body">
                        <figure class="highcharts-figure w-100">
                            <div id="collection_this_month_line"></div>
                        </figure>
                    </div>
                </div>
            </div>
<!--            <div class="row">-->
<!--                <div class="col-lg-12">-->
<!--                    <div class="ibox ibox-fullheight">-->
<!--                        <div class="ibox-body">-->
<!--                            <div class="d-flex justify-content-between mb-4">-->
<!--                                <div>-->
<!--                                    <h3 class="m-0">Monthly Collected Payments Analytics</h3>-->
<!--                                    <div>SLADS collected Payments analytics</div>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <canvas id="sales_chart_1" style="height:260px;"></canvas>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--           -->
<!--            </div>-->
            <br/>
            <div class="row">
                <div class="col-lg-7">
                    <div class="ibox ibox-fullheight">
                        <div class="ibox-head">
                            <div class="ibox-title">LATEST BILLS</div>
                            <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item"> <i class="ti-pencil"></i>Create</a>
                                    <a class="dropdown-item"> <i class="ti-pencil-alt"></i>Edit</a>
                                    <a class="dropdown-item"> <i class="ti-close"></i>Remove</a>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-body">
                            <div class="flexbox mb-4">
                                <div class="flexbox">
                                    <?php
                                        $result_latest_10=$this->db->query("select *  from invoices   order by id DESC limit 0,10")->result();
                                        $count_paid=0;
                                        $count_not_paid=0;
                                        foreach ($result_latest_10 as $key=>$value)
                                        {
                                            if($value->status==2)
                                                $count_paid +=1;
                                            else
                                                $count_not_paid += 1;

                                        }

                                    ?>
                                        <span class="flexbox mr-3">
                                            <span class="mr-2 text-muted">Paid</span>
                                            <span class="h3 mb-0 text-primary font-strong"><?php echo $count_paid; ?></span>
                                        </span>
                                    <span class="flexbox">
                                            <span class="mr-2 text-muted">Unpaid</span>
                                            <span class="h3 mb-0 text-pink font-strong"><?php  echo $count_not_paid; ?></span>
                                        </span>
                                </div>
                                <a class="flexbox" href="<?php echo site_url('invoice_list'); ?>" >VIEW ALL<i class="ti-arrow-circle-right ml-2 font-18"></i></a>
                            </div>
                            <div class="ibox-fullwidth-block">
                                <table class="table table-hover">
                                    <thead class="thead-default thead-lg">
                                    <tr>
                                        <th class="pl-4">Invoice#</th>
                                        <th>Customer</th>
                                        <th>RegNo</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="pr-4" style="width:91px;">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($result_latest_10 as $key=>$invoice_value)
                                    {
                                        $paid_amount=$this->db->query("select sum(paid_amount) as total_amount from payment where control_number='". $invoice_value->control_number."' and student_id='". $invoice_value->student_id."'")->row()->total_amount;
                                    ?>
                                    <tr>
                                        <td class="pl-4">
                                            <a href="#" target="_blank">#<?php echo $invoice_value->id?></a>
                                        </td>
                                        <td><?php echo $invoice_value->student_name ?></td>
                                        <td><?php echo $invoice_value->student_id ?></td>
                                        <td><small><?php echo number_format($invoice_value->amount) ?></small></td>
                                        <td>
                                            <?php if($invoice_value->status !=2) {?>
                                                <span class="badge badge-danger badge-pill">Unpaid</span>

                                            <?php  } elseif($invoice_value->amount==$paid_amount) {?>
                                                <span class="badge badge-primary badge-pill">Full Paid</span>

                                            <?php } else {?>
                                                <span class="badge badge-success badge-pill">Partial  Paid</span>

                                            <?php } ?>
                                        </td>
                                        <td class="pr-4"><?php echo $invoice_value->timestamp ?></td>
                                    </tr>

                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
                </div>

            </div>

        </div>

    </div>
</div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            var url = "<?php echo site_url('dashboard_analytics') ?>"
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    data=JSON.parse(response)
                    Highcharts.chart('collection_this_month', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '<?php $account_year_array=explode('/',$account_year); echo $account_year ?>    Monthly Collections '
                        },
                        subtitle: {
                            text: '<b>By NTA Levels </b>'
                        },
                        xAxis: {
                            categories: ['July','August','September',
                                'October','November','December',
                                'January','February','March',
                                'April','May','June'],
                            crosshair: true,
                            title: {
                                text: 'Months'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Amount (TShs.)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:,.1f} Tsh.</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.34,
                                borderWidth: 0,
                            }
                        },
                        series:[
                                {
                                    "name":"NTA Level 4",
                                    "data": JSON.parse(data['current_account_year_data'][0]).data
                                },
                                {   "name":"NTA Level 5",
                                    "data": JSON.parse(data['current_account_year_data'][1]).data
                                },
                                {    "name":"NTA Level 6",
                                    "data":JSON.parse(data['current_account_year_data'][2]).data
                                },
                                {    "name":"NTA Level 7",
                                    "data":JSON.parse(data['current_account_year_data'][3]).data
                                },
                                {    "name":"NTA Level 8",
                                    "data":JSON.parse(data['current_account_year_data'][4]).data
                                }
                            ]

                    });
                    Highcharts.chart('collection_this_month_line', {
                        chart: {
                            type: 'line'
                        },
                        title: {
                            text: '<?php $account_year_array=explode('/',$account_year); echo $account_year ?>    Monthly Trend '
                        },
                        subtitle: {
                            text: 'Overal'
                        },
                        xAxis: {
                            categories: ['July','August','September',
                                'October','November','December',
                                'January','February','March',
                                'April','May','June'],
                            crosshair: true,
                            title: {
                                text: 'Months'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Amount (TShs.)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:,.1f} Tsh.</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.34,
                                borderWidth: 0,
                            }
                        },
                        series:[
                            {
                                "name":"Overall",
                                "data": JSON.parse(data['current_account_year_data'][5]).data
                            },

                        ]

                    });
                },
            });

        });

    </script>
<?php }?>

 
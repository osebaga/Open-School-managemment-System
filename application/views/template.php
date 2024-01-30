<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SARIS | <?php echo (isset($title) ? $title : ''); ?></title>

    <!--Datatable cdns-->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/1.4.2/css/scroller.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/keytable/2.2.1/css/keyTable.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.0.0/css/rowGroup.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/1.3.3/css/colReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/autofill/2.2.0/css/autoFill.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->


    <link href="<?php echo base_url(); ?>media/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/select2-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/jquery-confirm.min.css" rel="stylesheet">


    <link href="<?php echo base_url(); ?>media/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css"
          rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>media/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url(); ?>media/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>media/js/jquery-confirm.min.js"></script>
    <script src="<?php echo base_url(); ?>media/js/script.js"></script>
    <script src="<?php echo base_url(); ?>media/js/html-table-search.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>media/js/plugins/select2/select2.full.min.js"></script>

<!-- Select2 -->
    <script src="<?php echo base_url(); ?>media/js/easy-ticker.js"></script>
    <script src="<?php echo base_url(); ?>media/js/jquery.easing.min.js"></script>

    <?php
    $organisation_info = get_collage_info();
    $CURRENT_USER = current_user();
    ?>
</head>

<body>

<div id="wrapper">
    <div id="header_div" style="background-color: #49688e;  border-bottom: 5px solid #f4a024;">
        <?php
        include 'include/header.php';
        
        ?>
 

    </div>
    <div id="header_line"></div>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <?php
            include 'include/leftmenu.php';
            ?>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <?php
        include 'include/bscrum.php';
        ?>
        <div style="border-bottom: 1px solid #2f4050; text-align: right; padding: 2px; color: #2f4050; font-weight: bold;">
            <?php
            $active_y = $this->common_model->get_account_year()->row()->AYear;;
            echo 'Active Academic Year : '.$active_y;
            ?>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight" >
            <?php
            if (isset($content) && isset($data)) {
                $this->load->view($content, $data);
            } else {
                $this->load->view($content);
            }
            ?>
        </div>
        <div class="footer fixed" style="font-size: 11px;">
            <div class="pull-right">
                Design and Developed by <strong><a href="http://www.zalongwa.com" target="_blank">ZALONGWA TECHNOLOGIES</a></strong>.
            </div>
            <div>
                <strong> &copy; 2012- <?php echo date('Y'); ?> &nbsp; &nbsp; <a
                        href="<?php echo $organisation_info->Site; ?>"
                        target="_blank"><?php echo $organisation_info->account_name; ?></a></strong>
            </div>
        </div>

    </div>
</div>


<script src="<?php echo base_url(); ?>media/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>media/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>media/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>media/js/plugins/pace/pace.min.js"></script>

<!-- Data picker -->
<script src="<?php echo base_url(); ?>media/js/plugins/datapicker/bootstrap-datepicker.js"></script>



<script>
    $(document).ready(function(){

            $(this).bind("contextmenu", function(e) {
               // e.preventDefault();
            });

        $('.mydate_input').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $('#datatable').dataTable({
            "colReorder": true,
            "pageLength": 50 ,
            dom: "Bfrtip",
            "order": [],
            buttons:
                [

                    {
                        extend:	'csv',
                        alignment: 'center',
                        title: $("#txtCurrTitle").val(),
                        filename: $("#txtCurrentFilename").val(),
                        orientation: $("#txtPaperOrientation").val(),
                        exportOptions:
                            {
                                columns: $("#txtColumnVisibility").val()

                            }
                    },
                    {
                        extend:	'excelHtml5',
                        alignment: 'center',
                        title: $("#txtCurrTitle").val(),

                        filename: $("#txtCurrentFilename").val(),
                        orientation: $("#txtPaperOrientation").val(),
                        exportOptions:
                            {
                                columns: $("#txtColumnVisibility").val()


                            }
                    },
                    {
                        extend: 'pdf',
                        alignment: 'center',
                        title: $("#txtCurrTitle").val(),
                        filename: $("#txtCurrentFilename").val(),
                        orientation: $("#txtPaperOrientation").val(),
                        exportOptions:
                            {
                                columns: $("#txtColumnVisibility").val()


                            },
                        customize: function (doc)
                        {
                            doc.styles.title={
                                alignment:'left',
                                fontSize: '15',

                            }

                            //Remove the title created by datatTables
                            doc.content.splice(0,0);
                            //Create a date string that we use in the footer. Format is dd-mm-yyyy
                            var now = new Date();
                            var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                            // Logo converted to base64
                            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
                            // The above call should work, but not when called from codepen.io
                            // So we use a online converter and paste the string in.
                            // Done on http://codebeautify.org/image-to-base64-converter
                            // It's a LONG string scroll down to see the rest of the code !!!

                            // A documentation reference can be found at
                            // https://github.com/bpampuch/pdfmake#getting-started
                            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                            // or one number for equal spread
                            // It's important to create enough space at the top for a header !!!
                            doc.pageMargins = [100,60,10,20];
                            // Set the font size fot the entire document
                            doc.defaultStyle.fontSize = 8;
                            // Set the fontsize for the table header
                            doc.styles.tableHeader.fontSize = 10;
                            // Create a header object with 3 columns
                            // Left side: Logo
                            // Middle: brandname
                            // Right side: A document title

                            // Create a footer object with 2 columns
                            // Left side: report creation date
                            // Right side: current page and total pages
                            doc['footer']=(function(page, pages) {
                                return {
                                    columns: [
                                        {
                                            alignment: 'left',
                                            text: ['Created on: ', { text: jsDate.toString() }]
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
                                        }
                                    ],
                                    margin: 20
                                }
                            });
                            // Change dataTable layout (Table styling)
                            // To use predefined layouts uncomment the line below and comment the custom lines below
                            // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) { return .5; };
                            objLayout['vLineWidth'] = function(i) { return .5; };
                            objLayout['hLineColor'] = function(i) { return '#aaa'; };
                            objLayout['vLineColor'] = function(i) { return '#aaa'; };
                            objLayout['paddingLeft'] = function(i) { return 4; };
                            objLayout['paddingRight'] = function(i) { return 4; };
                            doc.content[0].layout = objLayout;


                        }


                    },

                    {

                        extend: 'colvis',
                        columns: ':not(.noVis)'
                    }

                ],


        });

        $(".select2_search1").select2({
                theme:'bootstrap',
                allowClear:true
            });

    })

    function numbersonly(e,value,maxvalue){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57 || value>maxvalue) //if not a number
                return false //disable key press
        }
    }
</script>
 


<!-- ******************************POP UP************************************ -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModal" aria-hidden="true"
     data-backdrop="dynamic" data-keyboard="false" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="display: none;" id="model_header">
                <h4 class="modal-title"></h4>
                </div>
            <div class="modal-body" id="modal_body" style="z-index: 999999 !important;">
            <div style="height: 100px; line-height: 100px; text-align: center;"><img
                    src="<?php echo base_url(); ?>icon/loader.gif"/> Loading....
            </div>
                </div>
            <div class="modal-footer" style="display: none;" id="model_footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/keytable/2.2.1/js/dataTables.keyTable.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.3.3/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.0/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>


</body>

</html>






<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Create Invoice</h5>      <div class=" pull-right"> <?php echo' '. form_error('amount'); ?></div>   <font color="blue">   <div  id="payment-footer" align="center" style="font-size:25px; color:#006"></div></font>
        </div>

<?Php
// database login
$dbhost_name = "localhost"; 
$database = "oas_slads";       
$username = "root";             
$password = "Zalongwa06";
//End of database details

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host='.$dbhost_name.';dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
?> 
<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Create Invoice</h5></div>
    </div>
    
	<SCRIPT language=JavaScript>
		function reload(form)
		{
			var val=form.cat.options[form.cat.options.selectedIndex].value;
			self.location='student_create_invoice?cat=' + val ;
		}
	</script>

	<?Php
        @$cat=$_GET['cat'];
        if(strlen($cat) > 0 and !is_numeric($cat)){
        echo "Data Error";
        exit;
        }

        // query the data for Fees Structure
        $quer2="SELECT DISTINCT category, cat_id FROM category order by category";

        // query data for Fees Amount
        if(isset($cat) and strlen($cat) > 0){
            $quer="SELECT DISTINCT subcategory FROM subcategory where cat_id=$cat order by subcategory";
        }else{
            $quer="SELECT DISTINCT subcategory FROM subcategory order by subcategory";
        }
    ?>
    <div class="ibox-content">
        <?php  echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group"><label class="col-lg-3 control-label">Service to Pay: <span class="required">*</span></label>
            <div class="col-lg-7">
                <?php
                echo "<select name='cat' onchange=\"reload(this.form)\"><option value=''>Select one</option>";
                foreach ($dbo->query($quer2) as $noticia2) {
                    if($noticia2['cat_id']==@$cat){
                        echo "<option selected value='$noticia2[cat_id]'>$noticia2[category]</option>"."<BR>";
                    }
                    else{
                        echo  "<option value='$noticia2[cat_id]'>$noticia2[category]</option>";
                    }
                }
                ?>
                </select>
                <?php echo form_error('cat'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Amount: <span class="required">*</span></label>
            <div class="col-lg-7">
                <select id="subcat" name="subcat">
                    <?php
                    foreach ($dbo->query($quer) as $noticia) {
                        echo  "<option value='$noticia[subcategory]'>$noticia[subcategory]</option>";
                    }
                    ?>
                </select>
                <?php echo form_error('cat'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Registraton Number or Form IV Index Number:</label>
            <div class="col-lg-7">
                <input type="text"
                       value=""
                       class="form-control"  name="regno" />
                <?php echo form_error('regno'); ?>
            </div>


<!--        <div class="form-group"><label class="col-lg-3 control-label">Invoice Amount  : <span class="required">*</span></label>-->
<!---->
<!---->
<!--            <div class="col-lg-7">-->
<!--                <input type="text"-->
<!--                       value=""-->
<!--                       class="form-control"  onKeyPress="return numbersonly(event,this.value)" name="amount"/>-->
<!--                --><?php //echo form_error('amount'); ?>
<!--            </div>-->
<!--        </div>-->

        <input type="hidden"  id="txtGrandTotal" name="amount"/>

        <!--Dynamic table start here-->
        <table class="table table-bordered table-hover" id="tab_logic">
            <thead>
            <tr >
                <th class="text-center">
                    #
                </th>


                <th class="text-center">
                   Fee Name
                </th>

                <th class="text-center">
                    Amount
                </th>

            </tr>
            </thead>
            <tbody>
            <tr id='addr0'>
                <td>
                    1
                </td>


                <td>

                    <select class="form-control" style="width: 100%;" name="txtFeeName[]" id="txtFeeName_0"  onchange="ShowAmount(this.value,'txtAmount_0')">
                        <option value="">Select Fee </option>
                            <?php


                            $fee_list=$this->db->query("select * from fee_structure")->result();

                            foreach($fee_list as $key=>$value)
                            { ?>
                        <option  value="<?php echo $value->id.'_'.$value->amount; ?>"><?php echo $value->name.' ( '.get_value('ayear',$value->a_year,'AYear').'-'.get_value('ayear',$value->a_year,'semester').' )'; ?></option>
                        <?php

                            }
                    ?>
                    </select>
                </td>


                <td>

                    <input type="text"
                           value=""
                           class="form-control payment"  onKeyPress="return numbersonly(event,this.value)" id="txtAmount_0" name="txtAmount[]" readonly/>


                </td>


            </tr>
            <tr id='addr1'></tr>
            </tbody>
        </table>


        <div class="form-group">
            <label class="control-label col-sm-3" for="Content"></label>
            <div class="col-sm-5 ">
                <br/>
                <a id="add_row_openstock" class="btn btn-default pull-left">Add ++</a><a id='delete_row_openstock' class="pull-right btn btn-default">Delete --</a>
            </div>
        </div>
        <!--Dynamic table end here-->


        <div class="form-group" style="margin-top: 10px;">
            <div class=" col-lg-12">
                <input class="btn btn-sm btn-success pull-right" type="submit" value="Create Invoice"/>
        <div class="form-group"><label class="col-lg-3 control-label">First Name: <span class="required">*</span></label>
            <div class="col-lg-7">
                <input type="text"
                       value=""
                       class="form-control"  name="fname" />
                <?php echo form_error('fname'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Surname: <span class="required">*</span></label>
            <div class="col-lg-7">
                <input type="text"
                       value=""
                       class="form-control"  name="surname" />
                <?php echo form_error('surname'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Email: <span class="required">*</span></label>
            <div class="col-lg-7">
                <input type="text"
                       value=""
                       class="form-control"  name="email" />
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile: <span class="required">*</span></label>
            <div class="col-lg-7">
                <input type="text"
                       value=""
                       class="form-control"  name="mobile" />
                <?php echo form_error('mobile'); ?>
            </div>
        </div>
        
        <div class="form-group"><label class="col-lg-3 control-label">Description:  <span class="required">*</span></label>
            <div class="col-lg-7">
                <textarea name="message" rows="3" cols="87"></textarea>
                <?php echo form_error('message'); ?>
            </div>
        </div>
        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="Get Control Number"/>
            </div>
        </div>

        <?php echo form_close(); ?>

<br/>

        <br/><br/>
        <br/><br/>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".select50").select2({
            theme:'bootstrap',
            placeholder:'[ Select Country ]',
            allowClear:true
        });
        $(".select51").select2({
            theme:'bootstrap',
            placeholder:'[ Select Nationality ]',
            allowClear:true
        });
    });


    var i=1;
    $("#add_row_openstock").click(function(){


        $('table#tab_logic tr:last').index()
        var currenttable;


            currenttable= "<td>" +
                '<select  name="txtFeeName[]"  id="txtFeeName_'+ i +'" class="form-control select2" style="width: 100%;" onchange=\'ShowAmount(this.value,"txtAmount_' +  i + '")\' required></select>'

        currenttable += "<td>" +
            '<input type="text" class="form-control payment" id="txtAmount_'+ i +'" name="txtAmount[]"  onblur=\'loadAjaxData(this.value,"txtUnit_' +  i + '","txtItemName_' + i +'","oppenitemid","txtQuantity_' + i + '")\'  required="required" readonly/>'
            +"</td>"







        $('#addr'+i).html("<td>"+ (i+1) +"</td>" + currenttable);

        var $options = $("#txtFeeName_0 > option").clone();
        $('#txtFeeName_' + i).append($options);


        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++;
        $('.select2').select2();

    });
    $("#delete_row_openstock").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
        GranTotal();
    });

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function GranTotal()
    {

        var sum = 0;
        //Loop through all the textboxes of datatable and make sum of the values of it.
        $(".payment").each(function(){
            sum = sum + parseFloat($(this).val());
        });
        //Replace the latest sum.
        if(!isNaN(sum))
        {
            $("#payment-footer").html("Total Amount=" + addCommas(sum.toFixed(0)));

            $("#txtGrandTotal").val(sum.toFixed(0));
        }

        // alert($("#txtGrandTotal").val());
    }


    function ShowAmount(data,amount_field) {
        var my_data_array;
        my_data_array= data.split("_");
        my_array_field=amount_field.split("_");
        var already;
        var i;
        already=0;
        if(my_array_field[1]>=1)
        {

            for(i=0;i<my_array_field[1];i++)
            {

                if($("#txtFeeName_" + i).val()==data)
                {

                    already=1;
                    break;
                }

            }


            if(already==0)
            {
                $("#" + amount_field).val(my_data_array[1]);
            }else{
                already=0;
            }

        }else{
            $("#" + amount_field).val(my_data_array[1]);
        }

        GranTotal();
    }

</script>

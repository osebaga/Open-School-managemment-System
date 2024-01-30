<?php

error_reporting(0);
session_start();
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$pdf->SetHTMLHeader($this->pdf->PDFHeaderBalance("STUDENT'S INSTALMENTS PAYMENT SUMMARY  FOR  ACADEMIC YEAR ".$ayear));
$pdf->SetHTMLFooter($this->pdf->PDFFooter());

$date=date('Y-m-d',strtotime($invoice->timestamp));
$this->collegeinfo = get_collage_info();


$html = '<style>
#div1
{ float: left; height:60%; width: 40%; }

#div2
{ float: right; height:60%; width: 60%; }

' . file_get_contents('./media/css/pdf_css.css') . '</style>';

//$html .= '<br><br/><h3 style="text-align: center; padding-top: 20px; margin: 0px;">INVOICE</h3>';
$html .= '<br/><br/><br/><br/><br/><div>
   </div>';
$html .= '<tr/><table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    
                    <tr nobr="true">
                        <th  style=" text-align: left;">Account  Name :</th>
                        <td >' .$invoice->name. ' </td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Registration Number :</th>
                        <td >' . $invoice->regno . '</td>
                    </tr>
                   
                </table>

 </td>


</tr>
</table>';


$html .= '

<table class="table" cellspacing="0" cellpadding="3">
<thead>
<tr>
<th>Date</th>
<th>Description/Details</th>
<th>Control number</th>
<th>Receipt Number</th>
<th>Billed Amounts</th>
<th>Amount Paid</th>
<th>Outstanding  Balance</th>
</tr>
</thead>
   
    <tbody>';
$year_array=explode("/",$ayear);
$previous_year=($year_array[0]-1).'/'.$year_array[0];

$debt_back=$this->db->query("select   sum(amount) as total from student_invoice where regno='$id' and ayear<'$ayear' and side='DR' ")->row()->total;
$credit_back=$this->db->query("select   sum(amount) as total from student_invoice where regno='$id' and ayear<'$ayear' and side='CR' ")->row()->total;

$credit_payment_back_ayear=$this->db->query("select   sum(paid_amount) as total from payment where student_id='$id' and a_year<'$ayear'  ")->row()->total;
$credit_payment_back_ayear_sponsored=$this->db->query("select   sum(spoonsored_students_invoice.amount) as total from spoonsored_students_invoice inner join invoices on invoices.id=spoonsored_students_invoice.invoice_number where regno='$id' and status=2 and a_year<'$ayear'  ")->row()->total;
$credit_payment_back_ayear += $credit_payment_back_ayear_sponsored;

$credit_back += $credit_payment_back_ayear;

$brough_forward=($debt_back-$credit_back);
$html .= ' <tr >
            <td style=""><b>'.$previous_year.'</b></td>
            <td style=""><b>BALANCE BROUGHT FORWARD</b></td>
            <td style=""></td>
            <td style=""></td>
            <td style=""></td> 
            <td style=""></td> 
            <td style=""><b>'.number_format(($debt_back-$credit_back)).'</b></td>            
        </tr>';
$invoice2=$this->db->query("select * from student_invoice where regno='$id' and side='DR' and ayear='$ayear'")->result();

foreach ($invoice2 as $key=>$value)
{
    $brough_forward +=$value->amount;
    $html .= ' <tr >
             <td style="">'.$value->ayear.'</td>   
            <td style="">'.$value->type.'</td>
            <td style=""></td>
             <td style=""></td>
            <td style="">'.number_format($value->amount).'</td> 
            <td style=""></td> 
            <td style="">'.number_format($brough_forward).'</td>            
        </tr>';
}

$paid=$this->db->query("select * from payment where student_id='$id' and a_year='$ayear'")->result();
if($paid) {

    foreach ($paid as $key => $value) {

        //print_r($value);
        $invoice_details=$this->db->query("select * from invoices where control_number='$value->control_number'")->row();

        if(trim($invoice_details->description)!='')
        {
            $fee_description=$invoice_details->description;
            $description_array=json_decode($invoice_details->description,true);
            if(is_array($description_array))
            {
                $fee_description='';
                foreach ($description_array as $key=>$value2)
                {
                    if($value2['amount']!='')
                    {
                        $fee_description.='-'.$value2['name'].': '.number_format($value2['amount'])."<br/>";

                    }
                }
            }
        }

        $invoice_details_info=(trim($invoice_details->description)=='') ? $invoice_details->type : $fee_description;
        if(trim($invoice_details_info)!=''){
            $invoice_details_info= "<i><b>Being Paid for ".NTA_Fee_Categories($invoice_details->fee_category)."</b></i>";
        }

        $brough_forward -= $value->paid_amount;
        $html .= ' <tr>
            <td style="">' .date("d-M-Y", strtotime($value->transaction_date)) . '</td>
            <td style="">'.$value->paid_for.'</td>
            <td style="">'.$value->control_number.'</td>
            <td style="">'.$value->ega_refference.'</td>
            <td style=""></td>
            <td style="">' . number_format($value->paid_amount). '</td>  
            <td style="">' . number_format($brough_forward) . '</td>            
        </tr>';
    }
}


$paid=$this->db->query("select a_year,spoonsored_students_invoice.amount,control_number from invoices inner join spoonsored_students_invoice on spoonsored_students_invoice.invoice_number=invoices.id  where regno='$id' and a_year='$ayear'")->result();
if($paid) {
    foreach ($paid as $key => $value) {
        $invoice_details=$this->db->query("select * from invoices where control_number='$value->control_number'")->row();
        $payment_details=$this->db->query("select * from payment where control_number='$value->control_number'")->row();
        if(trim($invoice_details->description)!='')
        {
            $fee_description=$invoice_details->description;
            $description_array=json_decode($invoice_details->description,true);
            if(is_array($description_array))
            {
                $fee_description='';
                foreach ($description_array as $key=>$value2)
                {
                    if($value2['amount']!='')
                    {
                        $fee_description.='-'.$value2['name'].': '.number_format($value2['amount'])."<br/>";

                    }
                }
            }
        }
        $invoice_details_info=(trim($invoice_details->description)=='') ? $invoice_details->type : $fee_description;
        $sponsor_date='';
        $billed_amount='';
        $paid_amount='';
//        if($invoice_details->status==2)
//        {
//            $brough_forward -= $paid[0]->amount;
//            $paid_amount=$paid[0]->amount;
//            $sponsor_date= $payment_details->transaction_date;
//        }else{
//            $sponsor_date= $invoice_details->timestamp;
//            $billed_amount= $paid[0]->amount;
//        }

        if($invoice_details->status==1) {
            $html .= ' 
                <tr>
                    <td style="">' . date("d-M-Y", strtotime($sponsor_date)) . '</td>
                    <td style="">Tuition Fee (' . $invoice_details->student_id . ')</td>
                    <td style="">' . $invoice_details->control_number . '</td>
                    <td style="">' . $payment_details->ega_refference . '</td>
                    <td style="">' . number_format($billed_amount) . '</td>
                    <td style="">' . number_format($paid_amount) . '</td>  
                    <td style="">' . number_format($brough_forward) . '</td>            
                </tr>
            ';
        }
    }
}

$html .= '  
            <tr >
            <td style="" colspan="6" ><div style="align-content: right"><b><font color="#a52a2a">Note:</font><font style="color:lightseagreen;align-content: right;"> The Total outstanding balance as at '.date("d/m/Y").'</font></b></div></td>
            <td style="" ><b><font color="#a52a2a">'.number_format($brough_forward).'</font></b></td>
            <td style=""></td>
             
                     
        </tr>';
    $html .= '</tbody>
</table>';


$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Amount in word(s) :</th>
                        <td ><b>' . strtoupper(convert_number_to_words((int)$brough_forward)) . ' ONLY</b></td>
                    </tr>';
$html .= '<tr nobr="true">
                        <th  style=" text-align: left;">Printed By :</th>
                        <td >' .$this->collegeinfo = get_collage_info()->account_name; '</td>
                    </tr>';
                   $html .= ' <tr nobr="true">
                        <th  style=" text-align: left;">Printed On :</th>
                        <td >' . date('d-m-Y') . '</td>
                    </tr>
                    
                     <tr nobr="true">
                        <th  style=" text-align: left;">Signature :</th>
                        <td >----------------------------------------</td>
                    </tr>
                       
                </table>

 </td>


</tr>
</table>

</table>';

$pdf->WriteHTML($html);
//Close and output PDF document
$pdf->Output('Account Statement' . '.pdf', 'D');
exit;
?>

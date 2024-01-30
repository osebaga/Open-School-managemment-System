<?php

error_reporting(0);
session_start();
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$ict_info=get_collage_info();
$pdf->SetHTMLHeader($this->pdf->PDFHeaderBill('Order Form for Electronic Funds Transfer to ' .strtoupper($ict_info->bank_name )));
$pdf->SetHTMLFooter($this->pdf->PDFFooterTransfer($ict_info->account_number,$invoice->control_number));
$date=date('Y-m-d',strtotime($invoice->timestamp));
$this->collegeinfo = get_collage_info();

$message=array(
    "opType"=>2,
    "shortCode"=>"001001",
    "billReference"=>$invoice->control_number,
    "amount"=>$invoice->amount,
    "billCcy"=>'TZS',
    "billExprDt"=>date("Y-m-d",strtotime(($date .' + 180days'))),
    "billPayOpt"=>3,
    "billRsv01"=>$this->collegeinfo->account_name."|". $payer->FirstName. ' ' . $payer->MiddleName. ' ' . $payer->LastName
);
$message=json_encode($message);

//$message='{"opType":"2","shortCode":"001001","billReference":"991237654321","amount":"50000.0","billCcy":"TZS","billExprDt":"2018-09-01","billPayOpt":"2","billRsv01":"Tanzania Forest Agency|Augustino"}';
$postdata = array(
    "title" => $message,
    "control" =>$invoice->control_number ,

);
$url='http://41.59.225.216/qr/';
$file=$invoice->control_number.'.png';
$exists = remoteFileExists($url.'/Qrcode/images/'.$file);
if (!$exists) {
    $url=$url."Qrcode/qrcode.php";
    sendDataOverPost($url,$postdata);
}
//if(!file_exists(APPPATH.'../Qrcode/images/'.$file))
//{
//    $url=base_url()."Qrcode/qrcode.php";
//    sendDataOverPost($url,$postdata);
//
//}


$html = '<style>' . file_get_contents('./media/css/pdf_css.css') . '</style>';

//$html .= '<br><br/><h3 style="text-align: center; padding-top: 20px; margin: 0px;">INVOICE</h3>';
$html .= '<br/><br/><br/><br/>    <div>
   </div>';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;"><b>Remitter/Tax Payer Details :- </th>
                        <td ></td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;">&nbsp;&nbsp;Name of Account Holder(s) :</th>
                        <td>...................................................................................................</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">&nbsp;&nbsp;Name of Commercial Bank :</th >
                        <td>...................................................................................................</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">&nbsp;&nbsp; Bank Account Number :</th>
                        <td>...................................................................................................</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">&nbsp;&nbsp;Signators</th>
                        <td >...........................................|.......................................................<br>
                        <p style="font-size: x-small">Signatore of the first Transfer &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signatore of the second Transfer</p> 
                        </td>
                    </tr>
                   
                </table>

 </td>
 


</tr>
</table>';


$html .= '<br/><table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">(b)Beneficiary Details :-</th>
                        <td ><b>'.$ict_info->account_name.'</b></td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;"></th>
                        <td><b>:'.strtoupper($ict_info->bank_name).'</b></td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">&nbsp;&nbsp;Account Number</th>
                        <td><b>'.$ict_info->account_number.'</b></td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">&nbsp;&nbsp; Swift Code :</th>
                        <td><b>'.$ict_info->swift_code.'</b></td>
                    </tr>
                    <tr nobr="true">
                        <th style=" text-align: left;font-style: normal" >&nbsp;&nbsp;Control Number:</th>
                        <td><b>'.$invoice->control_number.'</b></td>
                    </tr>
                   
                </table>

 </td>
 
<td><img src="'.$url.'Qrcode/images/'.$invoice->control_number.'.png" alt="Qr Code" width="200"> </td>

</tr>
</table>';


$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Beneficiary Account (Field 59 of MT 103) :</th>
                        <td ><b>/' . $ict_info->account_number . '</b></td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;">Payment Reference (Field 70 of MT 103) :</th>
                        <td ><b>/ROC/' . $invoice->control_number . '</b></td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Transfer Amount :</th>
                        <td><b>'.number_format($invoice->amount,2).'(TZS)</b></td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Amount in Word :</th>
                        <td ><b>' . strtoupper(convert_number_to_words((int)$invoice->amount)).' ONLY</b> </td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Being Payment for :</th>
                        <td >' . $invoice->type . '</td>
                    </tr>
                   
                </table>

 </td>
 


</tr>
</table>';



$html .= '

<table class="table" cellspacing="0" cellpadding="3">
   
    <tbody>';

$html .= ' <tr>
            <td style="text-align: right;">Bill Item(1)</td>
            <td style="text-align: center;">' . $invoice->type . '</td>
            <td style="text-align: center;">' . number_format($invoice->amount,2) . '</td>            
        </tr>
        <tr>
            <td style="text-align: right;"></td>
            <td style="text-align: center;"><b>Total Billed Amount</b></td>
            <td style="text-align: center;">' . number_format($invoice->amount,2)  . ' (TZS)</td>            
        </tr>
    </tbody>
</table>


';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Amount in word :</th>
                        <td ><b>' . strtoupper(convert_number_to_words((int)$invoice->amount)) . ' ONLY</b></td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;">Expires on :</th>
                        <td >' . date("Y-m-d",strtotime(($date .' + 180days')))  . '</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Prepared By :</th>
                        <td>' . $user->firstname. ' ' . $user->lastname. ' </td>
                    </tr>   
                    <tr nobr="true">
                        <th  style=" text-align: left;">Collection Centre :</th>
                        <td>'. $this->collegeinfo->account_name.'  </td>
                    </tr>
                    
                     <tr nobr="true">
                        <th  style=" text-align: left;">Printed By :</th>
                        <td >' . $user->firstname. ' ' . $user->lastname. '</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Printed On :</th>
                        <td >' . date('d-m-Y') . '</td>
                    </tr>
                    
                     <tr nobr="true">
                        <th  style=" text-align: left;">Signature :</th>
                        <td >:.............................................................</td>
                    </tr>
                       
                </table>

 </td>


</tr><tr>
<td>
<br>
<p><b>Note to Commercial Bank:</b>
<br/>1. Please capture above information correctly. Do not change or add any text,symbols or digits on the information</p>
</td>

</tr>

</table>';



$pdf->WriteHTML($html);
//Close and output PDF document
$pdf->Output('Electronic_Fund_Transfer' . '.pdf', 'D');
exit;
?>

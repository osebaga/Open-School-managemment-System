<?php
error_reporting(0);
session_start();
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$pdf->SetHTMLHeader($this->pdf->PDFHeaderBill('Government Bill'));
$pdf->SetHTMLFooter($this->pdf->PDFFooter());
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
    "billRsv01"=>$this->collegeinfo->account_name."|". $payer->first_name. ' ' . $payer->surname
);
$message=json_encode($message);

//$message='{"opType":"2","shortCode":"001001","billReference":"991237654321","amount":"50000.0","billCcy":"TZS","billExprDt":"2018-09-01","billPayOpt":"2","billRsv01":"Tanzania Forest Agency|Augustino"}';
$postdata = array(
    "title" => $message,
    "control" =>$invoice->control_number ,

);

$file=$invoice->control_number.'.png';

if(!file_exists(APPPATH.'../Qrcode/images/'.$file))
{
    $url=base_url()."Qrcode/qrcode.php";
    sendDataOverPost($url,$postdata);

}

$html = '<style>' . file_get_contents('./media/css/pdf_css.css') . '</style>';

//$html .= '<br><br/><h3 style="text-align: center; padding-top: 20px; margin: 0px;">INVOICE</h3>';
$html .= '<br/><br/><br/><br/>    <div>
   </div>';
$html .= '<tr/><table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Control Number :</th>
                        <td >' . $invoice->control_number . '</td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;">Payment Ref :</th>
                        <td >' . $invoice->fee_name  . '</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Service Provider Code :</th>
                        <td>'.$ega_auth->spcode.'</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Payer Name :</th>
                        <td >' . $payer->first_name. ' ' . $payer->surname. ' </td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Bill Description :</th>
                        <td >' . $invoice->fee_name . '</td>
                    </tr>
                   
                </table>';

$html .= '</td>
 <td><img src="'.base_url().'/Qrcode/images/'.$invoice->control_number.'.png" alt="Qr Code"> </td>';


$html .= '</tr>
</table>';



$html .= '

<table class="table" cellspacing="0" cellpadding="3">
   
    <tbody>';

$html .= ' <tr>
            <td style="">Bill Item(1)</td>
            <td style="">' . $invoice->fee_name. '</td>
            <td style="">' . number_format($invoice->amount,2) . '</td>            
        </tr>
        <tr>
            <td style=""></td>
            <td style=""><b>Total Billed Amount</b></td>
            <td style="">' . number_format($invoice->amount ,2) . '(TZS)</td>            
        </tr>
    </tbody>
</table>';


$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Amount in word :</th>
                        <td ><b>' . strtoupper(convert_number_to_words((int)$invoice->amount)) .' ONLY </b></td>
                    </tr>
                    <tr nobr="true">
                        <th width="240px"  style="text-align: left;">Expires on :</th>
                        <td >' . date("Y-m-d",strtotime(($date .' + 30days')))  . '</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Prepared By :</th>
                        <td>' . $user->firstname. ' ' . $user->lastname. ' </td>
                    </tr>   
                    <tr nobr="true">
                        <th  style=" text-align: left;">Collection Centre :</th>
                        <td>ICT COMMISSION </td>
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
                        <td ><img src="'.base_url().'images/signature.jpg"></td>
                    </tr>
                       
                </table>

 </td>


</tr>
</table>';


$html .= '<table class="table" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <th style="width: 50px;">Jinsi ya Kulipa</th>
        <th style="text-align: center; width: 100px;">How to Pay</th>
        
        
    </tr>
    </thead>
    <tbody>';

$html .= ' <tr>
            <td style="text-align: left;">1. Kupitia Bank:  Fika tawi lolote au wakala wa benki ya CRDB
            Number ya kumbukumbu: <b>'.$invoice->control_number.'</b>
            </td>
            <td style="text-align: left;">1. Via Bank: Visit any branch or bank agent of CRDB 
            Reference number: <b>'.$invoice->control_number.'</b>
            </td>
                      
        </tr>
        
    </tbody>
</table>';

$pdf->WriteHTML($html);
//Close and output PDF document
$pdf->Output('Bill_Information' . '.pdf', 'D');
exit;
?>

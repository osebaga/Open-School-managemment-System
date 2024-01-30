<?php
error_reporting(0);
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$pdf->SetHTMLHeader($this->pdf->PDFHeaderReceipt('Stakabadhi ya Malipo ya Serikali'));
$pdf->SetHTMLFooter($this->pdf->PDFFooter());
$html = '<style>' . file_get_contents('./media/css/pdf_css.css') . '</style>';
//$html .= '<h3 style="text-align: center; padding-top: 20px; margin: 0px;">RECEIPT</h3>';
$html .= '<br/><br/><br/><br/><br/><br/><br/><br/> <div>
        
   </div>';
   $html .= '<table style="width: 100%;">
   <tr>
   <td style="width: 80%; vertical-align: top;">
   <table  cellpadding="5" cellspacing="0">
                       <tr nobr="true">
                           <th  style=" text-align: left;">Receipt No :</th>
                           <td >' . $payment->ega_refference . '</td>
                       </tr>
                       <tr nobr="true">
                       <th width="240px"  style="text-align: left;">Registration Number  :</th>
                       <td >' . $payment->student_id  . '</td>
                   </tr>
                       <tr nobr="true">
                           <th width="240px"  style="text-align: left;">Received From  :</th>
                           <td >' . $payment->student_name  . '</td>
                       </tr>';
                     
                        if($invoice->invoice_type==1)
                       {
                       $html .= '  <tr nobr="true">
                           <th  style=" text-align: left;"> RegNo:</th>
                           <td >' .$invoice->student_id. ' </td>';
                       }
                       $html .='<tr nobr="true">
                           <th  style=" text-align: left;">Amount(TZS) :</th>
                           <td>'.number_format($payment->paid_amount,2).' </td>
                       </tr>
                       <tr nobr="true">
                           <th  style=" text-align: left;">Amount in word :</th>
                           <td >' .strtoupper(convert_number_to_words((int)$payment->paid_amount)).' ONLY </td>
                       </tr>
                       <tr nobr="true">
                           <th  style=" text-align: left;">Outstanding Balance :</th>
                           <td >0.00 </td>
                       </tr>
                      
                   </table>
   
    </td>
   
   
   </tr>
   </table>';
$html .= '<table class="table" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <th style="width: 50px;">Controll Number</th>
        <th style="width: 50px;">Item description(s)</th>
        <th style="text-align: right; width: 100px;">Item Amount</th>
        
        
    </tr>
    </thead>
    <tbody>';

$html .= ' <tr>
            <td style="text-align: left;">' . $payment->control_number.'</td>
            <td style="text-align: left;">' .$payment->fee_name. '</td>

            <td style="text-align: right;">' . number_format($payment->paid_amount,2)  . '</td>            
        </tr>
        
        <tr></tr>
        <tr>
        <td></td>
            <td style="text-align: right;"><strong>Total Billed Amount</strong></td>
            <td style="text-align: right;"><b>' . number_format($payment->paid_amount,2)  . '(TZS)</b></td>            
        </tr>
    </tbody>
</table>';


$html .= '<table style="width: 100%;">
<tr>
<td style="width: 80%; vertical-align: top;">
<table  cellpadding="5" cellspacing="0">
                    <tr nobr="true">
                        <th  style=" text-align: left;">Bill Reference :</th>
                        <td ><b>' . $payment->invoice_number . '</b></td>
                    </tr>
                   
                    <tr nobr="true">
                        <th  style=" text-align: left;">Payment Date :</th>
                        <td>' . $payment->transaction_date. ' </td>
                    </tr>   
                    <tr nobr="true">
                        <th  style=" text-align: left;">Issued By :</th>
                        <td >' . $user->firstname. ' ' . $user->lastname. '</td>
                    </tr>
                    <tr nobr="true">
                        <th  style=" text-align: left;">Date Issued:</th>
                        <td >' . date('d-m-Y') . '</td>
                    </tr>
                      
                     <tr nobr="true">
                        <th  style=" text-align: left;">Signature :</th>
                        <td >----------------------------------------</td>
                    </tr>
                       
                </table>

 </td>


</tr>
</table>';





$pdf->WriteHTML($html);
//Close and output PDF document
$pdf->Output('payment_receipt' . '.pdf', 'D');
exit;
?>

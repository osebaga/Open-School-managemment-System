<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$pdf->SetHTMLHeader($this->pdf->PDFHeader());
$pdf->SetHTMLFooter($this->pdf->PDFFooter());
$html = '<style>' . file_get_contents('./media/css/pdf_css.css') . '</style>';
$html .= '<h3 style="text-align: center; padding: 0px; margin: 0px;">APPLICATION FORM</h3>';

$html .= ' <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
         Center Informations    
     </div>';
$html .= '<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
 <label>Center Name : </label> ' . ucwords($APPLICANT->CenterName) . '<br/>
 <label>Center Owner : </label> ' . $APPLICANT->CenterOwner . '<br/>
 <label>Center Cordinator : </label> ' . $APPLICANT->CenterCordinator . '<br/>
 <label>Taxpayer Identification Number  : </label> ' . $APPLICANT->TIN . '<br/>
 <label>Country of Residence :	 </label> ' . get_value('nationality',$APPLICANT->residence_country ,'Country'). '<br/>
  <label>Region of Residence : </label> ' . get_value('regions',$APPLICANT->region,'name') . '<br/>
  <label>District of Residence : </label> ' . get_value('districts',$APPLICANT->district,'name'). '<br/>
  <label>Nationality :	 </label> ' .get_value('nationality',  $APPLICANT->Nationality,'Name'). '<br/>

 </td>
<td style="width: 50%; vertical-align: top;">
 <label>NIDA : </label> ' . $APPLICANT->national_identification_number . '<br/>
 <label>TIN : </label> ' . $APPLICANT->TIN . '<br/>
 <label>Application Year :	 </label> ' . $APPLICANT->AYear . '<br/>
 <label>Application Type :	 </label> ' . center_application($APPLICANT->application_type) . '<br/>
 <label>Center Premises:	 </label> ' . center_premises($APPLICANT->Premises) . '<br/>
 <label>Village/Street :	 </label> ' . $APPLICANT->Village . '<br/>
 <label>Plot/House Number :	 </label> ' . $APPLICANT->HouseNumber . '<br/>
 <label>City:	 </label> ' . $APPLICANT->City . '<br/>
 <label>Town:	 </label> ' . $APPLICANT->Town . '<br/>';
 

$html .= '</td>
</tr>
</table>';

$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Contact Information
        </div>';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
 <label>Mobile Number 1 : </label> ' . $APPLICANT->Mobile1 . '<br/>
 <label>Mobile Number 2 : </label> ' . $APPLICANT->Mobile2 . '<br/>
 <label>Email : </label> ' . $APPLICANT->Email . '<br/>
</td>
<td style="width: 50%; vertical-align: top;">
 <label>Postal Address : </label> ' . $APPLICANT->postal . '<br/>
 <label>Physcal Address : </label> ' . $APPLICANT->physical . '<br/>
</td>
</tr>
</table>';

$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Application Fee Payment
        </div>';

$payment_transaction = $this->db->where('student_id', $APPLICANT->id)->get("payment")->result();
$total_amount = 0;
if(!$payment_transaction)
{
    $invoice_info = $this->db->where('student_id', $APPLICANT->id)->get("invoices")->row();

    $html .= '<h4>Your Control Number for payment is : ' . $invoice_info->control_number . '</h4>';

}
$html .= '<table class="table" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <th style="width: 50px;">S/No</th>
        <th style="text-align: center; width: 100px;">Reference</th>
        <th style="text-align: center; width: 100px;">Control Number</th>
        <th style="text-align: center; width: 100px;">Receipt</th>
        <th style="text-align: center; width: 100px;">Amount</th>
        <th style="text-align: center; width: 150px;">Trans Time</th>
    </tr>
    </thead>
    <tbody>';

//$payment_transaction = $this->db->where('applicant_id', $APPLICANT->id)->get("application_payment")->result();
//$total_amount = 0;
//$total_charge = 0;

foreach ($payment_transaction as $key => $value) {
    $total_amount += $value->paid_amount;
    //$total_charge += $value->charges;

    $html .= ' <tr>
            <td style="text-align: right;">' . ($key + 1) . '.</td>
            <td style="text-align: center;">' . $value->ega_refference . '</td>
            <td style="text-align: center;">' . $value->control_number . '</td>
             <td style="text-align: center;">' . $value->receipt_number . '</td>           
            <td style="text-align: right;">' . number_format($value->paid_amount , 2) . '</td>
            <td style="text-align: center;">' . $value->transaction_date . '</td>
        </tr>';
}
$html .= ' <tr>
        <td style="text-align: right;" colspan="4">Total</td>
        <td style="text-align: right;">' . number_format($total_amount , 2) . '</td>
        <td style="text-align: center;"></td>
    </tr>
    </tbody>
</table>';

$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Education Background
        </div>';

$html .= "<table style='width: 100%;'>
<tr>
<td style='width: 50%; vertical-align: top;'>
    <label>Owner's Education Level : </label>$APPLICANT->OwnerProfession<br/>
  
</td>

</tr>
</table> <br>";
foreach ($education_bg as $rowkey => $rowvalue) {


    $html .= '<div style="font-size: 16px; margin-bottom: 10px; border-bottom: 1px solid blue; width: 70%; color: blue; font-weight: bold;">' . administrator($rowvalue->certificate) . '</div>

        <table style="width: 100%;" cellspacing="3">

            <tr>
                <th style="width: 30%; text-align: left;">Name :</th>
                <td>' . $rowvalue->exam_authority . '</td>
            </tr>';

    $html .= '<tr>
         <th style="width: 30%; text-align: left;">Phone Number :</th>
            <td>' . $rowvalue->division . '</td>
            </tr>
            <tr>
                <th  style="text-align: left;"> Education Level :</th>
                <td>' . $rowvalue->school . '</td>
            </tr>';

    $html .= '</table>

        <br/>';
    if ($rowvalue->certificate == 4) {
        $html .= '<h4 style="padding: 0px; margin: 0px;">SUBJECT LIST</h4>
            <table class="table" cellpadding="3" cellspacing="0"   style="width: 100%">
                <thead>
                <tr>
                    <th style="width: 70px;">S/No.</th>
                    <th style="width: 150px; text-align: center;">Pre-vocational Courses</th>
                    <th style="width: 150px; text-align: center;">Academic Subjects</th>
                    <th style="width: 150px; text-align: center;">Generic Skills</th>
                </tr>
                </thead>
                <tbody>';
        $sno = 1;
        $subject_saved = $this->applicant_model->get_education_subject($rowvalue->applicant_id, $rowvalue->id);
        foreach ($subject_saved as $k => $v) {
            $html .= '<tr nobr="true">
                        <td style="vertical-align: middle; text-align: center">' . ($k + 1) . '</td>
                        <td style="text-align: center">' . $v->grade . '</td>

                        <td>' . get_value('secondary_subject', $v->subject, 'name') . '</td>
                        <td style="text-align: center">' . $v->year . '</td>
                    </tr>';
            $sno++;
        }
        $html .= '</tbody>
            </table>';
    }


}





$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Attachment
        </div>';
$html .= '<table class="table" cellspacing="0" cellpadding="3">
            <thead>
            <tr nobr="true">
                <th style="width: 50px;">S/No</th>
                <th style="width: 250px;">Certificate</th>
                <th>Comment</th>

            </tr>
            </thead>
            <tbody>';

foreach ($attachment_list as $rowkey => $rowvalue) {
    $html .= '<tr nobr="true">
                    <td style="vertical-align: middle; text-align: center;">' . ($rowkey + 1) . '</td>
                    <td>' . center_owner_attachment($rowvalue->certificate) . '</td>
                    <td>' . $rowvalue->comment . '</td>

                </tr>';

}

$html .= '</tbody></table>';


$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
    Declaration
</div>';
$html .= 'I, ' . $APPLICANT->FirstName . ' ' . $APPLICANT->LastName . ' hereby declare that the information given in this form  is  true
        to the best of my knowledge.';


$pdf->WriteHTML($html);
$fileArray = array();
foreach ($attachment_list as $rowkey => $rowvalue) {
    $extension = getExtension($rowvalue->attachment);
    if ($extension == 'pdf') {
        $fileArray[] = UPLOAD_FOLDER . 'attachment/' . $rowvalue->attachment;
    } else {
        $pdf->AddPage();
        $pdf->WriteHTML('<img src="' . UPLOAD_FOLDER . 'attachment/' . $rowvalue->attachment . '"/>');
    }
}


$outputName = UPLOAD_FOLDER . 'attachment/' . current_user()->id . '_MERGE.pdf';
if (file_exists($outputName)) {
    unlink($outputName);
}
$cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName ";

if (count($fileArray) > 0) {
    foreach ($fileArray as $file) {
        $cmd .= $file . " ";
    }

    $result = shell_exec($cmd);

    $pdf->AddPage();
    $pdf->SetImportUse();
    $pagecount = $pdf->SetSourceFile($outputName);
    for ($i = 1; $i <= $pagecount; $i++) {
        $tplId = $pdf->ImportPage($i);
        $pdf->UseTemplate($tplId, 5, 17, 200);
        if ($i < $pagecount)
            $pdf->AddPage();
    }


}

if (file_exists($outputName)) {
    unlink($outputName);
}

//Close and output PDF document
$pdf->Output('CENTER APPLICATION_FORM' . '.pdf', 'D');
exit;
?>
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once APPPATH . '/third_party/mpdf/mpdf.php';

class Pdf {

    public $collegeinfo;
 function __construct()
 {
     $this->collegeinfo = get_collage_info();
 }

    public function __get($var)
    {
        return get_instance()->$var;
    }


    function startPDF($param="A4",$font=10){
       return new mPDF('',$param,$font,'',10,10,22,20,5,2);
    }
    function PDFHeaderBill($title){
        $header='
<table width="100%;" style="border-bottom: 2px solid #000;">
<tr>
<th width="100%">    
<img style="height: 60px;" src="'.base_url().'images/ict_tanzania.jpg">
</th>
</tr>
<tr>
<td align="center">The Institute of Adult Education</td>
</tr>
<tr>
<td width="" align="center"><h3>'.$this->collegeinfo->account_name.' </h3></td>
</tr>

<tr>
<td align="center">'.$title.'</td>
</tr>
</table><br/><br/>';

        return $header;
    }

    function PDFHeaderReceipt($title){
        $header='
<table width="100%;" style="border-bottom: 2px solid #000;">
<tr>    
<th width="100%">    
<img style="height: 60px;" src="'.base_url().'images/ict_tanzania.jpg">
</th>
</tr>
<tr>
<td align="center">The Institute of Adult Education</td>
</tr>
<tr>
<td align="center">The Institute of Adult Education</td>
</tr>

<tr>
<td width="" align="center"><h3>'.$this->collegeinfo->account_name.' </h3></td>
</tr>
<tr>
<td align="center">Exchequer Receipts </td>
</tr>

<tr>
<td align="center">'.$title.'</td>
</tr>
</table><br/><br/>';

        return $header;
    }


    function PDFHeader(){

        $header = '
<table width="100%;" style="border-bottom: 2px solid #000;">
<tr>
<th width="15%">
<img style="height: 45px; width: 70px;" src="./images/logo.jpg">
</th>
<td width="90%" ><h3>'.$this->collegeinfo->account_name.' </h3><div style="font-size:12px;">'.
            $this->collegeinfo->PostalAddress.' '.
            $this->collegeinfo->City.' . Email : '.$this->collegeinfo->Email.' , Website : '.$this->collegeinfo->Site.'</div></td>

</tr>
</table>';

        return $header;
    }

    function PDFHeaderBalance($title){

        $header='
<table width="100%;" style="border-bottom:  solid #000;">
<tr>
<th width="100%">    
<img style=" height: 80px" src="'.base_url().'images/logo.jpg">
</th>
</tr>
<tr>
<td width="" align="center"><h3>'.$this->collegeinfo->account_name.' </h3></td>
</tr>

<tr>
<td align="center">'.$title.'</td>
</tr>
</table>';

        return $header;
    }

    function PDFFooter(){
        $footer = '<table width="100%;" style="border-top: 2px solid #000;">
<tr>
<td width="33%" style="font-style: italic; font-size: 6pt;">'.$this->collegeinfo->account_name.'<br/>Printed on :'.date('d/m/Y , H:i:s').'</td>
<td width="33%" style="text-align:center; font-style: italic; font-size: 8pt;">Page {PAGENO}/{nb}</td>
<td width="33%" style="text-align:right; font-style: italic; font-size: 6pt;">SARIS SOFTWARE V2</td>
</tr>
</table>';

        return $footer;
    }

    function PDFFooterTransfer($accountnumber,$control){
        $footer = '<table width="100%;" style="border-top: 2px solid #000;">
<tr><td colspan="3" style="font-style: italic; font-size: 7pt;">Provided<br/>
2. Field 59 of MT 103 is an <b>"Account Number "</b> With value: <b>/'.$accountnumber.'</b> Must be captured correctly<br/>
2. Field 70 of MT 103 is a <b>"Control Number "</b> With value: <b>/ROC/'.$control.'</b> Must be captured correctly
</td></tr>
<tr>
<td colspan="3"></td>
</tr>
<tr>

<td width="33%" style="font-style: italic; font-size: 6pt;">'.$this->collegeinfo->account_name.'<br/>Printed on :'.date('d/m/Y , H:i:s').'</td>
<td width="33%" style="text-align:center; font-style: italic; font-size: 8pt;">Page {PAGENO}/{nb}</td>
<td width="33%" style="text-align:right; font-style: italic; font-size: 6pt;">ZALONGWA SOFTWARE V2</td>
</tr>
</table>';

        return $footer;
    }



}

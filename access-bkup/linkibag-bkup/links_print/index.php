<?php
error_reporting(0);
ini_set('max_execution_time', 120);
include('../config/DB.class.php');
include('../classes/common.class.php');
include('../classes/user.class.php');
$co = new userClass();
$co->__construct();
/*
if(!$co->is_userlogin()){ 
	echo '<script language="javascript">window.location="index.php";</script>';      		
	exit(); 
}
*/
$current = $co->getcurrentuser_profile();


$uid = $current['uid'];

if(isset($_GET['preview_linkibook'])){
    $print_file = 'pdf_linkbook_output.php';
    $print_pdf_name = 'previewlinkbook.pdf';
}elseif(isset($_GET['create_linkibook'])){
    $print_file = 'pdf_linkbook_output.php';
    $print_pdf_name = '../files/linkibook_'.$_GET['id'].'.pdf';
}else{
    $print_file = 'pdf_links_output.php';
    $print_pdf_name = $company_name.'links.pdf';
}

//$business = $co->query_first("SELECT * FROM `business` WHERE `uid`=:uid", array('uid'=>$uid));
$company_name = 'links';

if(isset($print_file)){
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/'.$print_file);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 0);		
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));		
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		if (isset($_GET['download']) and $_GET['download']==1)
        {
            $html2pdf->Output($print_pdf_name, 'D');
            echo '<script type="text/javascript">window.close()</script>';
        }elseif (isset($_GET['savefile']) and $_GET['savefile']==1)
        {
            $html2pdf->Output($print_pdf_name, 'F');
            $co->query_update('linkibooks', array('pdf_size'=>filesize($print_pdf_name)), array('id'=>$_GET['id']), 'id=:id');
            if(isset($_GET['create_linkibook'])){
                echo '<script type="text/javascript">window.location.href= "../index.php?p=linkibook";</script>';
            }else{
                echo '<script type="text/javascript">window.close()</script>';
            }
            
        }else{
			$html2pdf->Output($print_pdf_name);
		}
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
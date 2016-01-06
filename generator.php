<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/15
 * Time: 10:02 AM
 */
include 'phpqrcode/qrlib.php';
require('fpdf/fpdf.php');

//QRcode::png('PHP QR Code :)');

if(isset($_POST) AND isset($_POST['prefix']) AND isset($_POST['begin']) AND isset($_POST['amount'])){
    $begin=$_POST['begin'];
    $amount=$_POST['amount'];
    $prefixUse=$_POST['prefix'];
    if($_POST['prefix']==""){
        $prefixUse="T'AS RIEN MIS";
    }
    if($amount<4){
        header("Location:index.php");
    }

   // header("Content-type: image/png");
    $imagePNG = imagecreate(827,1170);

    $fondBlanc= imagecolorallocate($imagePNG,255,255,255);
    imagepng($imagePNG,"fond.png");

    $fist_image=imagecreatefrompng("fond.png");


$pdf=new FPDF('P','pt','A4');






$page=$amount/20;
for($c=0;$c<$page;$c++){
    $pdf->AddPage();

    for ($i=0;$i<4;$i++){
        for($j=0;$j<5;$j++){
           // $currentQR=QRcode::png($prefixUse.$i.$j,"image.png", QR_ECLEVEL_L, 10);
            ++$begin;
            $currentQR=QRcode::png($prefixUse.$begin,"image.png", QR_ECLEVEL_L, 7);

            $im = imagecreate(185,220);
            $bg=imagecolorallocatealpha($im,255,255,255,127);
            $textcolor=imagecolorallocate($im,0,0,0);
            //imagecolortransparent($im);
            imagepng($im,"trans.png");
            imagestring($im,5,50,180,$prefixUse.$begin,$textcolor);
            imagepng($im,"color.png");
            imagecopymerge($im,imagecreatefrompng("image.png"),0,0,0,0,185,200,99);
            imagestring($im,5,50,180,$prefixUse.$begin,$textcolor);
            imagecopymerge($fist_image,$im,$i*200,$j*220,5,5,200,200,99);
        }
        if($begin==$amount){
            break;
        }
        imagepng($fist_image,"fin".$c.".png");
    }


    $pdf->Image("fin".$c.".png",10,40,-100);

}
    $pdf->Output();

	
   // imagepng($fist_image);

}else{
    header("Location:index.php");
}



?>


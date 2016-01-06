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
//    $imagePNG = imagecreate(827,1170);
//
//    $fondBlanc= imagecolorallocate($imagePNG,255,255,255);
//    imagepng($imagePNG,"fond.png");
//
//    $fist_image=imagecreatefrompng("fond.png");


    $pdf=new FPDF('P','pt','A4');

$count=0;
    $pdf->AddPage();
    for($m=0;$m<$amount;$m++){
    $m=$m+19;

for($i=0;$i<4;$i++){
    $begin=$begin+1;
    for($j=0;$j<5;$j++){
            $count=$i+$j;

        $currentQR=QRcode::png($prefixUse.$begin,"image.png", QR_ECLEVEL_L, 7);
        $im = imagecreate(185,200);
        $bg=imagecolorallocatealpha($im,255,255,255,127);
            $textcolor=imagecolorallocate($im,0,0,0);
            //imagecolortransparent($im);
            imagepng($im,"trans.png");
            imagestring($im,5,50,180,$prefixUse.$begin,$textcolor);
            imagepng($im,"color.png");
            imagecopymerge($im,imagecreatefrompng("image.png"),0,0,0,0,200,200,80);
            imagepng($im,"qr.png");
        $pdf->Image('qr.png',$i*150,$j*150,150,150);


    }

}
        $i=0;
        $j=0;
        $pdf->AddPage();
    }

  //  $pdf->AddPage();

//
//    for ($i=0;$i<4;$i++){
//        for($j=0;$j<$amount/4;$j++){
//            // $currentQR=QRcode::png($prefixUse.$i.$j,"image.png", QR_ECLEVEL_L, 10);
//            ++$begin;
//            $currentQR=QRcode::png($prefixUse.$begin,"image.png", QR_ECLEVEL_L, 7);
//
//            $im = imagecreate(185,200);
//            $bg=imagecolorallocatealpha($im,255,255,255,127);
//            $textcolor=imagecolorallocate($im,0,0,0);
//            //imagecolortransparent($im);
//            imagepng($im,"trans.png");
//            imagestring($im,5,50,180,$prefixUse.$begin,$textcolor);
//            imagepng($im,"color.png");
//            imagecopymerge($im,imagecreatefrompng("image.png"),0,0,0,0,185,200,80);
//
//            imagecopymerge($fist_image,$im,$i*200,$j*200,5,5,200,200,99);
//        }
//        if($begin==$amount){
//            break;
//        }
//        imagepng($fist_image,"fin.png");
//    }


//    $pdf->Image('fin.png',0,0,-100);


    $pdf->Output();


    // imagepng($fist_image);

}else{
    header("Location:index.php");
}



?>


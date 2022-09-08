<?php
include 'db/maria_db.php';;
include 'db/ms_db.php';

$ms = new ms_db();
$maria = new maria_db();

$data = $ms->readTable('dbo.Person', '');
//echo count($data)."</br>";

$i=0;
while ($data[$i]->KndNr != '13749'){
    $i ++;
}
$dok = $ms->readTable('dbo.Dokument', "PersonID = '".$data[$i]->PersonID."' AND DokumentID = '5B16E5B5-C2F0-45D9-BD16-F9026C1CDE5D'");

$str = $dok[0]->DateiBytes;
//echo $dok[0]->PersonID;
file_put_contents($dok[0]->Dateiname, $str);

$dateiname = explode('.',$dok[0]->Dateiname);

//$dest = imagecreatetruecolor(4032/4, 3024/4);
$neuedatei = imagecreatefrombmp($dok[0]->Dateiname);
//imagecopyresized($dest, $neuedatei, 0,0,0,0,4032/4, 3024/4, 4032, 3024);

imagejpeg($neuedatei,$dateiname[0] . '.jpg', 50);
imagedestroy($neuedatei);

$name = $dateiname[0] . '.jpg';
showSource($name);


function showSource($file){
    ob_clean();
    flush();
    $handle = fopen($file, "rb");
    header("Content-type: image/jpg");
    header('Content-Transfer-Encoding: binary');
    while (!feof($handle)){
        echo fread($handle, 8192);
    }
    fclose($handle);
    return true;
}
function readSource($file){
    ob_clean();
    flush();
    $handle = fopen($file, "rb");
    $str = "";
    while (!feof($handle)){
        $str .=  fread($handle, 8192);
    }
    fclose($handle);
    return $str;
}
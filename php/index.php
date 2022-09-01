<?php

$t1=microtime(true);
$x=(float)$_GET['x'];
$y=(float)$_GET['y'];
$R=(float)$_GET['R'];
$result="";
$filename=".\history";

function options(): void
{
    header('Access-Control-Allow-Origin: *');
    date_default_timezone_set("Europe/Moscow");
}

function checkSet($x,$y,$R): string
{
    if($x<=0.0 and $x>=-$R and $y<=$R/2.0 and $y>=0.0)$result= 'rectangle';
    else if($x<=0.0 and $x+$y>=-$R/2.0 and $y<=0.0)$result= 'triangle';
    else if($x>=0.0 and $x**2.0+$y**2.0<=($R/2.0)**2.0 and $y<=0.0)$result= 'circle';
    else $result='false';
    return $result;
}

options();
$result=checkSet($x,$y,$R);

$handleR= fopen($filename,'r+');
$connect=fread($handleR,filesize($filename));

$t2=microtime(true)-$t1;
$str='
    <tr>
        <td>'.$x.'</td>
        <td>'.$y.'</td>
        <td>'.$R.'</td>
        <td>'.$result.'</td>
        <td>'.date('H:i',time()).'</td>
        <td>'.$t2.'</td>
    </tr>';

fwrite($handleR,$str);
fclose($handleR);
echo $connect.$str.'</table>';
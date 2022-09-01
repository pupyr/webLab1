<?php
options();
$t1=microtime(true);
$x=(float)$_GET['x'];
$y=$_GET['y'];
$R=(float)$_GET['R'];
$result="";
$filename=".\history";
$result=checkODZ($x,$y,$R,$result);

function checkODZ($x,$y,$R,$result){
    $ost=0;
    $cel=explode('.',$y)[0];
    if(sizeof(explode('.',$y))>1)$ost=(float) explode('.',$y)[1];
    if( !(($x==-5||$x==-4||$x==-3||$x==-2||$x==-1||$x==0||$x==1||$x==2||$x==3)&&
        (($cel>=-5&&$cel<3)||($cel==3&&$ost==0))&&
        ($R==1||$R==1.5||$R==2||$R==2.5||$R==3)
    )){
        $result="err";
    }
    return $result;
}


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
if($result!="err") {
    $result = checkSet($x, $y, $R);

    $handleR = fopen($filename, 'r+');
    $connect = fread($handleR, filesize($filename));

    $t2 = microtime(true) - $t1;
    $str = '
    <tr>
        <td>' . $x . '</td>
        <td>' . $y . '</td>
        <td>' . $R . '</td>
        <td>' . $result . '</td>
        <td>' . date('H:i', time()) . '</td>
        <td>' . $t2 . '</td>
    </tr>';

    fwrite($handleR, $str);
    fclose($handleR);
    echo $connect . $str . '</table>';
    echo '<input class="button" id="back" type="submit" value="назад" style="margin-top: 10px">';
}
else echo "invalid values";

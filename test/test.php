<?php
function mosaic($var1, $var2, $var3='c', $var4='d'){

    return $var1.$var2.$var3.$var4;
}
$parm_fir = '1';
$parm_sec = 'b';
$parm_three = 'c';
$parm_four = 'd';
// echo mosaic($parm_fir , $parm_sec);    //输出'ab'
echo mosaic($parm_fir, $parm_sec, $var4=$parm_three); //输出'abc'
// echo mosaic($parm_fir, $parm_sec, $parm_three, $parm_four);//输出'abcd'
// echo mosaic($parm_fir);      //出错:必须给出第二个必填参数
// echo mosaic($parm_fir, $parm_sec, , $parm_three);//出错:不能跳过任何一个可选参数而给出列表中后面的可选参数
?>
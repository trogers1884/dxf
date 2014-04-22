<?php
$frmctrldebug = true;
/*********************************/
$debugstatus = $frmctrldebug ? 'text' : 'hidden';
$dxfid = isset($dxfid) ? $dxfid : 0;
//$sid = isset($sid) ? $sid : 0;
$frmctrl = '<form id="frmCtrl" name="frmCtrl">' . PHP_EOL;
$frmctrl .= '<input type="' . $debugstatus . '" id="dxfid" name="dxfid" value="' . $dxfid . '">' . PHP_EOL;
$frmctrl .= '<input type="' . $debugstatus . '" id="sid" name="sid" value="' . $_SESSION['sid'] . '">' . PHP_EOL;
$frmctrl .= '<input type="' . $debugstatus . '" id="dxajax" name="dxajax" value="">' . PHP_EOL;
//$frmctrl .= '<input type="' . $debugstatus . '" id="phpsessid" name="phpsessid" value="' . $_SESSION['phpsessid'] . '">' . PHP_EOL;
//$frmctrl .= '<input type="' . $debugstatus . '" id="currentsid" name="currentsid" value="' . $currentsid . '">' . PHP_EOL;
//$frmctrl .= '<input type="' . $debugstatus . '" id="oldsid" name="oldsid" value="' . $oldsid . '">' . PHP_EOL;

$frmctrl .= '</form>' . PHP_EOL;
print $frmctrl;
?>


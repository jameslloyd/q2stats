<?php
$log = _dbquery("SELECT * FROM `log`");
$smarty->assign('log', $log);
$smarty->assign('html', $html);
$smarty->display('showlog.tpl');
?>
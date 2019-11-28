<?php
unset($app);
unset($method);
unset($strvars);
unset($value);
unset($class);
unset($form);
unset($file);
unset($var);
unset($urlvars);
unset($jsonfile1);
unset($jsonfile2);
$arr = get_defined_vars();
echo json_encode($arr);
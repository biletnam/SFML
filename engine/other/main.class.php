<?php
/*
 * @author ������� ��������
 */
function __autoload($class_name) {
    $class_name=strtolower($class_name);
    if(!file_exists(ADMIN.'engine/other/'.$class_name.'.class.php')) {
        exit('����� '.$class_name.' �� �������');
    }
    require($class_name.'.class.php');
    return $other->$class_name = new $class_name;
}
class other {}
$other=new other;
?>
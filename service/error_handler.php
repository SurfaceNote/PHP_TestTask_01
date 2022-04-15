<?php
function Send_Error_ICO_LOG($ico)
{
    $db_info = Database::InfoForConnection();
    class_alias('\RedBeanPHP\R', '\R');
    R::setup($db_info['dsn'], $db_info['username'], $db_info['password']);

    $error_log = R::dispense('errorsico');
    $error_log->ico = $ico;
    $error_log->date_time_search = date("d-m-Y H:i:s");
    R::store($error_log);
    R::close();
}
?>
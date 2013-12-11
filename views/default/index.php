<?php

// set the status
$status_header = 'HTTP/1.1 ' . $status . ' ' . $status_msg;

header($status_header);
// and the content type
header('Content-type: text/html');
echo CJSON::encode($data);
?>

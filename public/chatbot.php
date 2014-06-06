<?php

$url = 'http://sheepridge.pandorabots.com/pandora/talk?botid=b69b8d517e345aba&skin=custom_input';
$data = file_get_contents($url);
$code = get_string_between($data, '<input type="hidden" name="botcust2" value="', '"');
$postdata = http_build_query(
    array(
        'input' => $_POST['text'],
        'botcust2' => $code,
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result = file_get_contents($url, false, $context);
$response = get_string_between($result, '<b>A.L.I.C.E.:</b> ', '<br');
echo $response;
exit;

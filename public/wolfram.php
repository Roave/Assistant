<?php
//$text = 'what is the circumference of earth?';
$text = 'weather in gilbert, az';
$wolframurl = 'http://api.wolframalpha.com/v2/query?appid=2LEWXX-9V8Y9YPHRK&format=plaintext&input=' . urlencode($text);
$response = file_get_contents($wolframurl);
echo $response;
$obj = new SimpleXMLElement($response);
if (isset($obj->pod->subpod->plaintext)){
    $answer = $obj->pod->subpod->plaintext;
    echo $answer;
}

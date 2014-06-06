<?php
$query = $_POST['text'];

$url = 'https://www.google.com/search?q=' . urlencode($query);

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36\r\n"
  )
);

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

$text = strip_tags(get_string_between($response, '<div class="_iA">','</div>'));
if (!$text) {
    $text = strip_tags(get_string_between($response, '<div class="_uq">', '</div>'));
}

if ($text) {
    echo $text;
    exit;
}

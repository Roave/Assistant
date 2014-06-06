<?php

class Matcher
{
    public function __construct($text)
    {
        $this->text = $text;
    }

    public function match($patterns)
    {
        foreach ($patterns as $pattern) {
            if (preg_match('/' . $pattern . '/i', $this->text, $matches)) {
                return $matches;
            }
        }
        return false;
    }
}

$matcher = new Matcher($_POST['text']);

$patterns = [
    'start a timer for (?<client>) doing (?<task>)',
];



function get_string_between($haystack, $startNeedle, $stopNeedle)
{
    $ini = mb_strpos($haystack,$startNeedle);
    if ($ini == 0) return false;
    $ini += mb_strlen($startNeedle);
    $len = mb_strpos($haystack,$stopNeedle,$ini) - $ini;
    return mb_substr($haystack,$ini,$len);
}

require_once 'google-answer.php';

require_once 'chatbot.php';

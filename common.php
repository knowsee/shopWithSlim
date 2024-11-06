<?php

function siteUrl($name = '')
{
    if ($name == 'Upload') {
        return $_ENV['siteUploadUrl'];
    }
    return $_ENV['siteUrl'];
}
function excUrl($url)
{
    if ($url[0] == '/') {
        $url = substr($url, 1);
    }
    return $_ENV['siteUrl'] . $url;
}

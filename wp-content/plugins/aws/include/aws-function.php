<?php

//unparse url
function unparse_url($parsed_url)
{
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
}

//delete query string url
function delete_query_string($uri = '', $query_string = array())
{
    $parsed_url = parse_url($uri);
    parse_str($parsed_url['query'], $parsed_query);

    foreach($query_string as $s){
        unset($parsed_query[$s]);
    }

    $parsed_url['query'] = http_build_query($parsed_query);
    return $parsed_url;
}

//check image filename exist
function aws_s3_check_image_exists($bucket = '', $file = '', $s3 = array(),$directory)
{
    $filename = $directory . '/' . uniqid() . '.jpeg';
    // $filename = $file['name'];
    $i = 1;
    while ($s3->doesObjectExist($bucket, $filename)) {
        $data = pathinfo($file["name"]);
        $name = $data['filename'];
        $ext = $data['extension'];

        $filename = $name . ' (' . $i . ').' . $ext;
        $i++;
    }

    return $filename;
}

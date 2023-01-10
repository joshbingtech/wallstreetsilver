<?php
function character_limiter($str, $n = 500, $end_char = '&#8230;')
{
    $str = strip_tags($str);
    if (strlen($str) < $n)
    {
        return html_entity_decode($str);
    }

    $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n", "&nbsp;"), ' ', $str));

    if (strlen($str) <= $n)
    {
        return html_entity_decode($str);
    }

    $out = "";
    foreach (explode(' ', trim($str)) as $val)
    {
        $out .= $val.' ';

        if (strlen($out) >= $n)
        {
            $out = trim($out);
            return (strlen($out) == strlen($str)) ? html_entity_decode($out) : html_entity_decode($out.$end_char);
        }
    }
}

function convertDateTimeTo($tstamp)
{
    return date('F j, Y',strtotime($tstamp));
}

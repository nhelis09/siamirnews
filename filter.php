<?php
function filter($string)
{
    $hasil = preg_replace('~[\;<>{"}]~', '', $string);
    $hasil2 = str_replace("'", '', $hasil);
    return $hasil2;
}
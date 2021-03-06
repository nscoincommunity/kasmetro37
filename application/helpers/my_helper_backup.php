<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function print_recursive_list($data)
{
    $str = "";
    foreach($data as $list)
    {
        $str .= "<li>".anchor($list['link'],$list['nama']);
        $subchild = print_recursive_list($list['child']);
        if($subchild != '')
            $str .= "<ul>".$subchild."</ul>";
        $str .= "</li>";
    }
    return $str;
}
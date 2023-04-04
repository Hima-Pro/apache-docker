<?php
$path = '../../cdn';
$path2 = 'assets';
$real = realpath($path);
$real2 = realpath($path2);
echo strpos($real2, $real);
echo $real;
echo $real2;

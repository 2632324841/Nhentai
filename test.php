<?php
require_once 'vendor/autoload.php';

use Nhentai\Search;
use Nhentai\Works;

$Works = new Works();
$Search = new Search();

// $data = $Works->works('349895');
$data = $Search->search('azur lane');
print_r($data);
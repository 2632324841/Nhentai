<?php
namespace Nhentai;

class Nhentai{
    public static function create($class)  
    {  
        switch($class){
            case 'Search': return new \Nhentai\Search();
            case 'Tags': return new \Nhentai\Tags();
            case 'Works': return new \Nhentai\Works();
            default: return null;
        }
    }
}
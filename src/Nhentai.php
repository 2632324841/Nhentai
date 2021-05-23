<?php
namespace Nhentai;

class Nhentai{
    public static function create($class)  
    {  
        switch(strtolower($class)){
            case 'search': return new \Nhentai\Search();
            case 'tags': return new \Nhentai\Tags();
            case 'works': return new \Nhentai\Works();
            default: return null;
        }
    }
}
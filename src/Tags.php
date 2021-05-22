<?php
namespace Nhentai;

use QL\QueryList;
use Nhentai\Tool;
class Tags extends Tool{
    public function tags($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'tags/popular/';
        }else{
            $url = $this->Domain.'tags/';
        }

        $html = $this->Get($url, ['page'=>$page]);

        return $this->result($html, $popular);
    }

    public function artists($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'artists/popular/';
        }else{
            $url = $this->Domain.'artists/';
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->result($html, $popular);
    }

    public function characters($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'characters/popular/';
        }else{
            $url = $this->Domain.'characters/';
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->result($html, $popular);
    }

    public function parodies($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'parodies/popular/';
        }else{
            $url = $this->Domain.'parodies/';
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->result($html, $popular);
    }

    public function groups($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'groups/popular/';
        }else{
            $url = $this->Domain.'groups/';
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->result($html, $popular);
    }

    public function result($html, $popular){
        $ql = QueryList::html($html);

        $section_length = $ql->find('#tag-container section')->length();
        $section = $ql->find('#tag-container section');
        
        $data = [];

        if($popular){
            $section_length = $ql->find('#tag-container a')->length();
            $section = $ql->find('#tag-container a');
            for($i = 0;$i < $section_length; $i++){
                $id = $section->eq($i)->attr('class');
                preg_match_all("/\d+/", $id, $arr);
                $id = $arr[0][0];
                $data[] = [
                    'tag_id'=>$id,
                    'name'=> $section->eq($i)->find('.name')->text(),
                    'count'=> $section->eq($i)->find('.count')->text(),
                ];
            }
        }else{
            $section_length = $ql->find('#tag-container section')->length();
            $section = $ql->find('#tag-container section');

            for($i = 0;$i < $section_length; $i++){
                $a_length = $section->eq($i)->find('a')->length();
                $tag_name = $section->eq($i)->find('h2')->text();
                $tags = [];
                for($j = 0;$j < $a_length; $j++){
                    $tag_a = $section->find('.tag');
                    $id = $tag_a->eq($j)->attr('class');
                    preg_match_all("/\d+/", $id, $arr);
                    $id = $arr[0][0];
                    $tags[] = [
                        'tag_id'=>$id,
                        'name'=>$tag_a->eq($j)->find('.name')->text(),
                        'count'=>$tag_a->eq($j)->find('.count')->text(),
                    ];
                }
                $data[$tag_name] = $tags;
            }
        }

        return $data;
    }
}
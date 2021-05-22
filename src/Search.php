<?php
namespace Nhentai;

use QL\QueryList;
use Nhentai\Tool;

class Search extends Tool{

    public function search($query, $page=1){

        $query = urlencode($query);

        $url = $this->Domain.'search/';

        $html = $this->Get($url, ['q'=>$query,'page'=>$page]);

        return $this->searchResult($html);
    }

    public function parody($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'parody/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'parody/'. $query;
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }
    
    public function character($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'character/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'character/'. $query;
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }
    
    public function artist($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'artist/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'artist/'. $query;
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }

    public function language($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'language/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'language/'. $query;
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }

    public function category($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'category/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'category/'. $query;
        }
       
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }


    public function group($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'group/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'group/'. $query;
        }
        
        $html = $this->Get($url, ['page'=>$page]);

        return $this->typeResult($html);
    }

    public function typeResult($html){
        $ql = QueryList::html($html);

        $gallery = $ql->find('.gallery');

        $len = $gallery->length();

        $count = $ql->find('.count')->text();
        $last = $ql->find('.last')->attr('href');
            
        preg_match_all('/page=[0-9]+/', $last, $arr);
        $last = $arr[0][0];

        $data = [];
        
        for($i = 0; $i < $len; $i++){
            $image = $gallery->eq($i)->find('.lazyload')->attr('data-src');
            $title = $gallery->eq($i)->find('.caption')->text();
            $tags_ids = $gallery->eq($i)->attr('data-tags');

            $tags_ids = explode(' ', $tags_ids);
            if(in_array(6346, $tags_ids)){
                $lang = 'jp';
            }else if(in_array(12227, $tags_ids)){
                $lang = 'en';
            }else if(in_array(29963, $tags_ids)){
                $lang = 'zh';
            }else{
                $lang = 'null';
            }

            $id = $gallery->eq($i)->find('.cover')->attr('href');
            preg_match_all("/\d+/", $id, $arr);
            $id = $arr[0][0];
            $data[] = [
                'id'=>$id,
                'title'=>$title,
                'image'=>$image,
                'tags_ids'=>$tags_ids,
                'lang'=>$lang,
            ];
        }

        return ['data'=>$data,'last'=>$last,'count'=>$count];
    }

    public function searchResult($html){
        $ql = QueryList::html($html);

        $gallery = $ql->find('.gallery');

        $len = $gallery->length();

        $count = $ql->find('h1')->text();
        $last = $ql->find('.last')->attr('href');
            
        preg_match_all('/page=[0-9]+/', $last, $arr);
        $last = $arr[0][0];
        
        $count = str_replace(',', '', $count);
        preg_match_all("/\d+/", $count, $arr);
        $count = $arr[0][0];

        $data = [];
        
        for($i = 0; $i < $len; $i++){
            $image = $gallery->eq($i)->find('.lazyload')->attr('data-src');
            $title = $gallery->eq($i)->find('.caption')->text();
            $tags_ids = $gallery->eq($i)->attr('data-tags');
            $tags_ids = explode(' ', $tags_ids);
            if(in_array('6346', $tags_ids)){
                $lang = 'jp';
            }else if(in_array('12227', $tags_ids)){
                $lang = 'en';
            }else if(in_array('29963', $tags_ids)){
                $lang = 'zh';
            }else{
                $lang = 'null';
            }

            $id = $gallery->eq($i)->find('.cover')->attr('href');
            preg_match_all("/\d+/", $id, $arr);
            $id = $arr[0][0];
            $data[] = [
                'id'=>$id,
                'title'=>$title,
                'image'=>$image,
                'tags_ids'=>$tags_ids,
                'lang'=>$lang,
            ];
        }

        return ['data'=>$data,'last'=>$last,'count'=>$count];
    }
}
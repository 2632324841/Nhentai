<?php 
require_once 'vendor/autoload.php';

use QL\QueryList;
use GuzzleHttp\Client;

class Nhentai{
    protected $Client;
    protected $Domain = 'https://nhentai.net/';
    public $Headers = [
        'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36',
        'upgrade-insecure-requests'=>1,
        'referer'=>'https://nhentai.net',
    ];
    protected $Tapi = 'https://t.nhentai.net/galleries/';
    protected $Iapi = 'https://i.nhentai.net/galleries/';

    public function __construct()
    {
        $this->Client = new Client(['verify'=>false,'http_errors'=>false]);
    }

    public function search($query, $page=1){
        $query = str_replace(' ','+', $query);
        $url = $this->Domain.'search/';
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'q'=>$query,
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function parody($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'parody/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'parody/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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
    
    public function character($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'character/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'character/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function tag($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'tag/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'tag/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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
    
    public function artist($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'artist/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'artist/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function language($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'language/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'language/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function category($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'category/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'category/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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


    public function group($query, $Popular = null, $page = 1){
        $query = str_replace(' ','-', $query);
        
        if(array_key_exists($Popular, ['popular-today','popular-week','popular'])){
            $url = $this->Domain.'group/'. $query.'/'.$Popular;
        }else{
            $url = $this->Domain.'group/'. $query;
        }
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    

    public function random(){
        $url = $this->Domain.'random/';
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
        ]);

        $html = (string)$r->getBody();

        $ql = QueryList::html($html);

        $script_count = $ql->find('script')->length();

        $script = $ql->find('script')->eq((int)$script_count - 1)->text();

        $json = substr($script, strpos($script, '"') + 1 , strrpos($script, '"') - strpos($script, '"')- 1);
        $json = $this->UnicodeDecode($json);
        $json = json_decode($json, true);
        
        foreach($json['images']['pages'] as $key=>&$image){
            $original_url = $this->Iapi.$json['id'].'/'.($key + 1);
            $thumbnail_url = $this->Tapi.$json['id'].'/'.($key + 1);
            $image['original'] = $this->imageType($original_url, $image['t']);
            $image['thumbnail'] = $this->imageType($thumbnail_url, $image['t']);
        }
        $original_url = $this->Iapi.$json['id'].'/cover';
        $json['images']['cover']['original'] = $this->imageType($original_url, $json['images']['cover']['t']);

        return $json;
    }

    public function tags($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'tags/popular/';
        }else{
            $url = $this->Domain.'tags/';
        }
        
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

        $ql = QueryList::html($html);

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

    public function artists($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'artists/popular/';
        }else{
            $url = $this->Domain.'artists/';
        }
        
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function characters($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'characters/popular/';
        }else{
            $url = $this->Domain.'characters/';
        }
        
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function parodies($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'parodies/popular/';
        }else{
            $url = $this->Domain.'parodies/';
        }
        
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    public function groups($page = 1, $popular = false){
        if($popular){
            $url = $this->Domain.'groups/popular/';
        }else{
            $url = $this->Domain.'groups/';
        }
        
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>[
                'page'=>$page,
            ]
        ]);

        $html = (string)$r->getBody();

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

    private function imageType($url, $key){
        if($key == 'j'){
            return $url.'.jpg';
        }else if($key == 'p'){
            return $url.'.png';
        }else{
            return $url.'.gif';
        }
    }

    private function UnicodeEncode($str){
        //split word
        preg_match_all('/./u',$str,$matches);
        $unicodeStr = "";
        foreach($matches[0] as $m){
            //拼接
            $unicodeStr .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
        }
        return $unicodeStr;
    }

    private function UnicodeDecode($unicode_str){
        $json = '{"str":"'.$unicode_str.'"}';
        $arr = json_decode($json,true);
        if(empty($arr)) return '';
        return $arr['str'];
    }
}



$Nhentai = new Nhentai();
//$data = $Nhentai->parody('azur lane');
$data = $Nhentai->tags();
print_r($data);

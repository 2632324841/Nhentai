<?php
namespace Nhentai;

use QL\QueryList;
use Nhentai\Tool;

class Works extends Tool{
    public function works($id){
        $url = $this->Domain.'/g/'.$id.'/';

        $html = $this->Get($url);

        return $this->result($html);
    }

    public function random(){
        $url = $this->Domain.'random/';
        
        $html = $this->Get($url);

        return $this->result($html);
    }

    public function result($html){
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
}
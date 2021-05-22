<?php
namespace Nhentai;

use GuzzleHttp\Client;
class Tool{
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

    protected function imageType($url, $key){
        if($key == 'j'){
            return $url.'.jpg';
        }else if($key == 'p'){
            return $url.'.png';
        }else{
            return $url.'.gif';
        }
    }

    protected function UnicodeEncode($str){
        //split word
        preg_match_all('/./u',$str,$matches);
        $unicodeStr = "";
        foreach($matches[0] as $m){
            //拼接
            $unicodeStr .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
        }
        return $unicodeStr;
    }

    protected function UnicodeDecode($unicode_str){
        $json = '{"str":"'.$unicode_str.'"}';
        $arr = json_decode($json,true);
        if(empty($arr)) return '';
        return $arr['str'];
    }

    protected function Get($url, $param = []){
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>$param
        ]);
        if($r->getStatusCode() == 200){
            $html = (string)$r->getBody();
            return $html;
        }
        else{
            throw new \Exception('请求异常');
        }
    }

    protected function Post($url, $param = [], $data = []){
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>$param,
            'form_params'=>$data
        ]);
        if($r->getStatusCode() == 200){
            $html = (string)$r->getBody();
            return $html;
        }
        else{
            throw new \Exception('请求异常');
        }
    }

    protected function Json($url, $param = [], $data = []){
        $this->headers['Content-Type'] = 'application/json';
        $r = $this->Client->request('GET', $url, [
            'headers'=>$this->headers,
            'query'=>$param,
            'json'=>$data
        ]);
        if($r->getStatusCode() == 200){
            $html = (string)$r->getBody();
            return $html;
        }
        else{
            throw new \Exception('请求异常');
        }
    }
}
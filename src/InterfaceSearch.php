<?php
namespace Nhentai;

interface InterfaceSearch{
    public function search($query, $page=1);
    public function parody($query, $Popular = null, $page=1);
    public function character($query, $Popular = null, $page=1);
    public function artist($query, $Popular = null, $page=1);
    public function language($query, $Popular = null, $page=1);
    public function category($query, $Popular = null, $page=1);
    public function group($query, $Popular = null, $page=1);
}
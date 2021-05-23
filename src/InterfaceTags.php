<?php
namespace Nhentai;

interface InterfaceTags{
    public function tags($page = 1, $popular = false);
    public function artists($page = 1, $popular = false);
    public function characters($page = 1, $popular = false);
    public function parodies($page = 1, $popular = false);
    public function groups($page = 1, $popular = false);
}
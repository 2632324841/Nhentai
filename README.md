# Nhentai Api

```php
# 安装
composer require deadlymous/nhentai

# 搜索
use Nhentai\Search;
$Search = new Search();
$Search->search($query, $page = 1);
$Search->parody($query, $page = 1);
$Search->character($query, $page = 1);
$Search->artist($query, $page = 1);
$Search->language($query, $page = 1);
$Search->category($query, $page = 1);
$Search->group($query, $page = 1);

# 标签列表
use Nhentai\Tags;
$Tags = new Tags():
$Tags->tags($page = 1, $popular = 1);
$Tags->artists($page = 1, $popular = 1);
$Tags->characters($page = 1, $popular = 1);
$Tags->parodies($page = 1, $popular = 1);
$Tags->groups($page = 1, $popular = 1);

# 作品内容
use Nhentai\Works;
$Works = new Works();
# 作品 参数id
$Works->works($id);
# 随机作品
$Works->random();

# 创建搜索工厂
$Search = Nhentai::create('Search');
$data = $Search->search('azur lane');
print_r($data);
```


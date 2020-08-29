<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

$submenu['content'] = $lang_module['add'];
$submenu['level'] = $lang_module['level'];
$submenu['sector'] = $lang_module['sector'];

$allow_func = array(
    'main',
    'content',
    'level',
    'sector'
);

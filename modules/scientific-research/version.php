<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = [
    'name' => 'Scientific Research',
    'modfuncs' => 'main,level,sector,rss,detail,search',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.4.02',
    'date' => 'Saturday, August 29, 2020 15:29:55 GMT+07:00',
    'author' => 'PHAN TAN DUNG <phantandung92@gmail.com>',
    'note' => '',
    'uploads_dir' => [
        $module_upload,
        $module_upload . '/files',
        $module_upload . '/images'
    ]
];

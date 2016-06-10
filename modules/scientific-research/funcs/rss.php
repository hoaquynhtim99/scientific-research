<?php

/**
 * @Project VIDEO SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_MOD_SCIENTIFIC_RESEARCH'))
    die('Stop!!!');

$channel = array();
$items = array();

$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = !empty($module_info['description']) ? $module_info['description'] : $global_config['site_description'];

$db->sqlreset()->select('id, title, alias, leader, member, addtime')->order('id DESC')->limit(30);

$db->from(NV_PREFIXLANG . '_' . $module_data . '_rows')->where('status=1');

if ($module_info['rss']) {
    $result = $db->query($db->sql());
    while (list($id, $title, $alias, $leader, $member, $publtime) = $result->fetch(3)) {
        $items[] = array(
            'title' => $title,
            'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias . $global_config['rewrite_exturl'], //
            'guid' => $module_name . '_' . $id,
            'description' => $lang_module['content_leader'] . ': ' . $leader . '. ' . $lang_module['content_member'] . ': ' . $member,
            'pubdate' => $publtime
        );
    }
}

nv_rss_generate($channel, $items);
die();

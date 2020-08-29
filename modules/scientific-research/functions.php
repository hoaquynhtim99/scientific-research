<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

define('NV_MOD_SCIENTIFIC_RESEARCH', true);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level ORDER BY weight ASC';
$global_array_level = $nv_Cache->db($sql, 'levelid', $module_name);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector ORDER BY weight ASC';
$global_array_sector = $nv_Cache->db($sql, 'sectorid', $module_name);

$array_mod_title = [];

// Xac dinh RSS
if ($module_info['rss']) {
    $rss[] = [
        'title' => $module_info['site_title'],
        'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']
    ];
}

$page = 1;
$per_page = 30;

if ($op == 'main' and isset($array_op[0])) {
    if (isset($array_op[2])) {
        $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
    } elseif (preg_match("/^page\-([0-9]+)$/i", $array_op[0], $m)) {
        $page = intval($m[1]);
    } else {
        $op = 'detail';
    }
}

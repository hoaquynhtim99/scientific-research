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

// Các đơn vị
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_agencies ORDER BY weight ASC';
$global_array_agencies = $nv_Cache->db($sql, 'id', $module_name);

$array_mod_title = $global_array_agency_alias = [];

// Xac dinh RSS
if ($module_info['rss']) {
    $rss[] = [
        'title' => $module_info['site_title'],
        'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']
    ];
}

foreach ($global_array_agencies as $agency) {
    if (!empty($agency['status'])) {
        $rss[] = [
            'title' => $agency['title'],
            'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss'] . '/' . $agency['alias']
        ];
        $global_array_agency_alias[$agency['alias']] = $agency['id'];
    }
}

$page = 1;
$per_page = 2;

if ($op == 'main' and isset($array_op[0])) {
    if (isset($array_op[2])) {
        $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
    } elseif (preg_match("/^page\-([0-9]+)$/i", $array_op[0], $m)) {
        $page = intval($m[1]);
    } elseif (isset($global_array_agency_alias[$array_op[0]])) {
        if (isset($array_op[1])) {
            if (preg_match("/^page\-([0-9]+)$/i", $array_op[1], $m)) {
                $page = intval($m[1]);
            } else {
                $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
                nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
            }
        }

        $catid = $global_array_agency_alias[$array_op[0]];
        $op = 'viewcat';
        $array_mod_title[] = [
            'catid' => $catid,
            'title' => $global_array_agencies[$catid]['title'],
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_agencies[$catid]['alias']
        ];
    } else {
        $op = 'detail';

        if ((isset($array_op[1]) and $array_op[1] != 'download') or isset($array_op[2])) {
            $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
            nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
        }
    }
}

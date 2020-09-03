<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_MOD_SCIENTIFIC_RESEARCH')) {
    die('Stop!!!');
}

// Chống điền trực tiếp link viewcat
if (empty($catid)) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $lang_module['content_title1'] . ' ' . $global_array_agencies[$catid]['title'];
$key_words = $module_info['keywords'];

$db->sqlreset()->select('COUNT(*)')->from(NV_PREFIXLANG . '_' . $module_data . '_rows')->where('status=1 AND agencyid=' . $catid);

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, levelid, sectorid, agencyid, title, alias, leader, member, scienceid, down_filepath, down_groups, doyear, addtime, edittime');
$db->order('id DESC')->limit($per_page)->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array = [];
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_agencies[$catid]['alias'];

// Phân đề tài theo năm
$stt = (($page - 1) * $per_page) + 1;
while ($row = $result->fetch()) {
    $row['stt'] = $stt++;
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];
    $row['download_href'] = '';

    if (!empty($row['down_filepath'])) {
        $row['download_href'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . '/download';

        if (!defined('NV_IS_USER')) {
            $row['download_href'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($row['download_href']);
        }
    }

    unset($row['down_filepath'], $row['down_groups']);

    $array[$row['doyear']][] = $row;
}

if ($page > 1) {
    $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
}

$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
$contents = nv_main_theme($array, $generate_page, false, $num_items);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_MOD_SCIENTIFIC_RESEARCH'))
    die('Stop!!!');

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

$page = $nv_Request->get_int('p', 'get', 1);

$search = array();
$search['key'] = $nv_Request->get_title('q', 'get', '');
$search['levelid'] = $nv_Request->get_int('l', 'get', 0);
$search['sectorid'] = $nv_Request->get_int('s', 'get', 0);

if (empty($search['key']) and $nv_Request->isset_request('q', 'get')) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
}

$request_uri = $_SERVER['REQUEST_URI'];
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

if (!empty($search['key'])) {
    $base_url .= '&q=' . urlencode($search['key']);
}
if (!empty($search['levelid'])) {
    $base_url .= '&l=' . $search['levelid'];
}
if (!empty($search['sectorid'])) {
    $base_url .= '&s=' . $search['sectorid'];
}

$base_url_rewrite = nv_url_rewrite($base_url . ($page > 1 ? '&p=' . $page : ''), true);

if ($request_uri != $base_url_rewrite and NV_MAIN_DOMAIN . $request_uri != $base_url_rewrite) {
    nv_redirect_location($base_url_rewrite);
}

// Check get data
if (($search['levelid'] > 0 and !isset($global_array_level[$search['levelid']])) or ($search['sectorid'] > 0 and !isset($global_array_sector[$search['sectorid']]))) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . $base_url_rewrite . '" />';
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
}

$db->sqlreset()->select('COUNT(*)')->from(NV_PREFIXLANG . '_' . $module_data . '_rows');

$sql = array('status = 1');

$dbkey = $db->dblikeescape($search['key']);

$sql[] = "(title LIKE '%" . $dbkey . "%' OR hometext LIKE '%" . $dbkey . "%' OR leader LIKE '%" . $dbkey . "%')";

if (!empty($search['levelid'])) {
    $sql[] = "levelid = " . $search['levelid'];
}
if (!empty($search['sectorid'])) {
    $sql[] = "sectorid = " . $search['sectorid'];
}

$db->where(implode(' AND ', $sql));

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, levelid, sectorid, title, alias, leader, member, scienceid, down_filepath, down_groups, doyear, addtime, edittime')->order('id DESC')->limit($per_page)->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array = array();

$stt = 1;
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

if (empty($search['key'])) {
    $page_title = $lang_module['search_title'];
} else {
    $page_title = $search['key'] . ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_module['search_title'];

    if ($page > 1) {
        $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
    }
}

$key_words = $description = 'no';

$generate_page = nv_generate_page(array('link' => $base_url, 'amp' => '&p='), $num_items, $per_page, $page);

$contents = nv_main_theme($array, $generate_page, true, $num_items);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

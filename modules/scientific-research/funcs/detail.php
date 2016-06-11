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

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status = 1 AND alias = :alias';
$sth = $db->prepare($sql);
$sth->bindParam(':alias', $array_op[0], PDO::PARAM_STR);
$sth->execute();

$row = $sth->fetch();

if (empty($row)) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
}

$page_title = $row['title'];
$description = empty($row['hometext']) ? 'no' : $row['hometext'];

$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];

if (isset($array_op[1]) and $array_op[1] == 'download') {
    if (empty($row['down_filepath']) or !file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/files/' . $row['down_filepath'])) {
        $contents = nv_info_theme($lang_module['down_no_file'], NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);
    } elseif (!defined('NV_IS_USER')) {
        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($client_info['selfurl']);
        $contents = nv_info_theme($lang_module['down_login'], $link, 'info');
    } elseif (!nv_user_in_groups($row['down_groups'])) {
        $contents = nv_info_theme($lang_module['down_not_allow'], NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);
    } else {
        $contents = nv_info_theme($lang_module['down_ok'], NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, 'success');

        $file_src = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/files/' . $row['down_filepath'];
        $file_basename = ucfirst(nv_strtolower(change_alias($row['title']) . '.' . nv_getextension($row['down_filepath'])));
        $directory = NV_UPLOADS_REAL_DIR;

        $download = new NukeViet\Files\Download($file_src, $directory, $file_basename, true, 0);
        $download->download_file();
    }
} else {
    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];
    $base_url_rewrite = nv_url_rewrite($base_url, true);
    $request_uri = $_SERVER['REQUEST_URI'];

    if (!($home or $request_uri == $base_url_rewrite or $request_uri == $page_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $base_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $page_url_rewrite)) {
        header('Location: ' . $base_url_rewrite);
        die();
    }

    $row['download_href'] = '';
    $row['download_filename'] = '';

    if (!empty($row['down_filepath'])) {
        $row['download_href'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . '/download';

        if (!defined('NV_IS_USER')) {
            $row['download_href'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($row['download_href']);
        }

        $row['download_filename'] = ucfirst(change_alias($row['title'])) . '.' . nv_getextension($row['down_filepath']);
    }

    unset($row['down_filepath'], $row['down_groups']);

    $contents = nv_detail_theme($row);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

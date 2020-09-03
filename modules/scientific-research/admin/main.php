<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

// Change alias
if ($nv_Request->isset_request('changealias', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $id = $nv_Request->get_int('id', 'post', 0);

    $alias = change_alias($title);

    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id !=' . $id . ' AND alias = :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(id) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows')->fetchColumn();
        $weight = intval($weight) + 1;
        $alias = $alias . '-' . $weight;
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo $alias;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Change status
if ($nv_Request->isset_request('changestatus', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);

    if (empty($id))
        nv_htmlOutput("NO");

    $sql = "SELECT title, status FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
    $result = $db->query($sql);
    list($title, $status) = $result->fetch(3);

    if (empty($title))
        nv_htmlOutput('NO');
    $status = $status == 1 ? 0 : 1;

    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET status = " . $status . " WHERE id = " . $id;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    nv_htmlOutput("OK");
}

// Xóa bỏ 1 hoặc nhiều
if ($nv_Request->isset_request('delete', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $listid = $nv_Request->get_title('listid', 'post', '');
    $listid = $listid . ',' . $id;
    $listid = array_filter(array_unique(array_map('intval', explode(',', $listid))));

    foreach ($listid as $id) {
        // Kiểm tra tồn tại
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id;
        $array = $db->query($sql)->fetch();
        if (!empty($array)) {
            // Xóa
            $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id;
            $db->query($sql);

            nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_DELETE_ROW', $id . ': ' . $array['title'], $admin_info['admin_id']);
        }
    }

    $nv_Cache->delMod($module_name);
    nv_htmlOutput("OK");
}

$page_title = $lang_module['list'];
$per_page = $nv_Request->get_int('per_page', 'get', 20);
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

$array_search = [];
$array_search['q'] = $nv_Request->get_title('q', 'get', '');

$db->sqlreset()->select('COUNT(*)')->from(NV_PREFIXLANG . '_' . $module_data . '_rows');

$where = [];

if (!empty($array_search['q'])) {
    $base_url .= '&amp;q=' . urlencode($array_search['q']);
    $dblikekey = $db->dblikeescape($array_search['q']);
    $where[] = "(title LIKE '%" . $dblikekey . "%')";
}

if (!empty($where)) {
    $db->where(implode(' AND ', $where));
}

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('*')->order('id DESC')->limit($per_page)->offset(($page - 1) * $per_page);
$result = $db->query($db->sql());

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('LINK_ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content');
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

while ($row = $result->fetch()) {
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $row['id'];
    $row['status_render'] = $row['status'] ? ' checked="checked"' : '';

    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

if (!empty($generate_page)) {
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

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

$page_title = $lang_module['sector'];

// Change alias
if ($nv_Request->isset_request('changealias', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $id = $nv_Request->get_int('id', 'post', 0);

    $alias = change_alias($title);

    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid !=' . $id . ' AND alias = :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(sectorid) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector')->fetchColumn();
        $weight = intval($weight) + 1;
        $alias = $alias . '-' . $weight;
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo $alias;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Change sector weight
if ($nv_Request->isset_request('changeweight', 'post')) {
    $sectorid = $nv_Request->get_int('sectorid', 'post', 0);

    $sql = 'SELECT sectorid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid=' . $sectorid;
    $sectorid = $db->query($sql)->fetchColumn();
    if (empty($sectorid))
        nv_htmlOutput('NO_' . $sectorid);

    $new_weight = $nv_Request->get_int('new_weight', 'post', 0);
    if (empty($new_weight))
        nv_htmlOutput('NO_' . $module_name);

    $sql = 'SELECT sectorid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid!=' . $sectorid . ' ORDER BY weight ASC';
    $result = $db->query($sql);

    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        if ($weight == $new_weight)
            ++$weight;

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sector SET weight=' . $weight . ' WHERE sectorid=' . $row['sectorid'];
        $db->query($sql);
    }

    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sector SET weight=' . $new_weight . ' WHERE sectorid=' . $sectorid;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $sectorid;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Delete sector
if ($nv_Request->isset_request('delete', 'post')) {
    $sectorid = $nv_Request->get_int('sectorid', 'post', 0);

    $sql = 'SELECT sectorid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid=' . $sectorid;
    $sectorid = $db->query($sql)->fetchColumn();

    if (empty($sectorid))
        nv_htmlOutput('NO_' . $sectorid);

    $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid = ' . $sectorid;

    if ($db->exec($sql)) {
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete', 'ID: ' . $sectorid, $admin_info['userid']);

        $sql = 'SELECT sectorid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;

        while ($row = $result->fetch()) {
            ++$weight;
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sector SET weight=' . $weight . ' WHERE sectorid=' . $row['sectorid'];
            $db->query($sql);
        }

        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET sectorid = 0 WHERE sectorid =' . $sectorid);

        $nv_Cache->delMod($module_name);
    } else {
        nv_htmlOutput('NO_' . $sectorid);
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $sectorid;
    include NV_ROOTDIR . '/includes/footer.php';
}

$data = array();
$error = '';

$sectorid = $nv_Request->get_int('sectorid', 'post,get', 0);

if (!empty($sectorid)) {
    $sql = 'SELECT sectorid, title, alias, description FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE sectorid = ' . $sectorid;
    $result = $db->query($sql);
    $data = $result->fetch();

    if (empty($data)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $caption = $lang_module['sector_edit'];
} else {
    $data = array(
        'sectorid' => 0,
        'title' => '',
        'alias' => '',
        'description' => '',
    );

    $caption = $lang_module['sector_add'];
}

if ($nv_Request->isset_request('submit', 'post')) {
    $data['title'] = $nv_Request->get_title('title', 'post', '', true);
    $data['alias'] = $nv_Request->get_title('alias', 'post', '', true);
    $data['description'] = $nv_Request->get_title('description', 'post', '', true);

    $data['alias'] = empty($data['alias']) ? change_alias($data['title']) : change_alias($data['alias']);

    if (empty($data['title'])) {
        $error = $lang_module['sector_error_title'];
    } else {
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector WHERE alias = :alias' . ($sectorid ? ' AND sectorid != ' . $sectorid : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['sector_error_exists'];
        } else {
            if (!$sectorid) {
                $sql = 'SELECT MAX(weight) weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector';
                $result = $db->query($sql);
                $weight = $result->fetch();
                $weight = $weight['weight'] + 1;

                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_sector (title, alias, description, weight, add_time, edit_time) VALUES (
                    :title, :alias, :description, ' . $weight . ', ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . '
                )';
            } else {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sector SET title = :title, alias = :alias, description = :description, edit_time = ' . NV_CURRENTTIME . ' WHERE sectorid = ' . $sectorid;
            }

            try {
                $sth = $db->prepare($sql);
                $sth->bindParam(':title', $data['title'], PDO::PARAM_STR);
                $sth->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
                $sth->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $sth->execute();

                if ($sth->rowCount()) {
                    if ($sectorid) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit', 'ID: ' . $sectorid, $admin_info['userid']);
                    } else {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Add', ' ', $admin_info['userid']);
                    }

                    $nv_Cache->delMod($module_name);
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
                } else {
                    $error = $lang_module['errorsave'];
                }
            } catch (PDOException $e) {
                $error = $lang_module['errorsave'];
            }
        }
    }
}

$xtpl = new XTemplate('sector.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('CAPTION', $caption);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DATA', $data);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector ORDER BY weight ASC';
$array = $db->query($sql)->fetchAll();
$num = sizeof($array);

foreach ($array as $row) {
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sector&amp;sectorid=' . $row['sectorid'] . "#addedit";

    for ($i = 1; $i <= $num; ++$i) {
        $xtpl->assign('WEIGHT', array('w' => $i, 'selected' => ($i == $row['weight']) ? ' selected="selected"' : ''));

        $xtpl->parse('main.loop.weight');
    }

    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

if (empty($data['alias'])) {
    $xtpl->parse('main.getalias');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

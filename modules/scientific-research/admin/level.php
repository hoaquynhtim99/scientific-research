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

$page_title = $lang_module['level'];

// Change alias
if ($nv_Request->isset_request('changealias', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $id = $nv_Request->get_int('id', 'post', 0);

    $alias = change_alias($title);

    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid !=' . $id . ' AND alias = :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(levelid) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level')->fetchColumn();
        $weight = intval($weight) + 1;
        $alias = $alias . '-' . $weight;
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo $alias;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Change level weight
if ($nv_Request->isset_request('changeweight', 'post')) {
    $levelid = $nv_Request->get_int('levelid', 'post', 0);

    $sql = 'SELECT levelid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid=' . $levelid;
    $levelid = $db->query($sql)->fetchColumn();
    if (empty($levelid))
        die('NO_' . $levelid);

    $new_weight = $nv_Request->get_int('new_weight', 'post', 0);
    if (empty($new_weight))
        die('NO_' . $module_name);

    $sql = 'SELECT levelid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid!=' . $levelid . ' ORDER BY weight ASC';
    $result = $db->query($sql);

    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        if ($weight == $new_weight)
            ++$weight;

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_level SET weight=' . $weight . ' WHERE levelid=' . $row['levelid'];
        $db->query($sql);
    }

    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_level SET weight=' . $new_weight . ' WHERE levelid=' . $levelid;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $levelid;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Delete level
if ($nv_Request->isset_request('delete', 'post')) {
    $levelid = $nv_Request->get_int('levelid', 'post', 0);

    $sql = 'SELECT levelid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid=' . $levelid;
    $levelid = $db->query($sql)->fetchColumn();

    if (empty($levelid))
        die('NO_' . $levelid);

    $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid = ' . $levelid;

    if ($db->exec($sql)) {
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete', 'ID: ' . $levelid, $admin_info['userid']);

        $sql = 'SELECT levelid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;

        while ($row = $result->fetch()) {
            ++$weight;
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_level SET weight=' . $weight . ' WHERE levelid=' . $row['levelid'];
            $db->query($sql);
        }

        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET levelid = 0 WHERE levelid =' . $levelid);

        $nv_Cache->delMod($module_name);
    } else {
        die('NO_' . $levelid);
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $levelid;
    include NV_ROOTDIR . '/includes/footer.php';
}

$data = array();
$error = '';

$levelid = $nv_Request->get_int('levelid', 'post,get', 0);

if (!empty($levelid)) {
    $sql = 'SELECT levelid, title, alias, description FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE levelid = ' . $levelid;
    $result = $db->query($sql);
    $data = $result->fetch();

    if (empty($data)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $caption = $lang_module['level_edit'];
} else {
    $data = array(
        'levelid' => 0,
        'title' => '',
        'alias' => '',
        'description' => '',
    );

    $caption = $lang_module['level_add'];
}

if ($nv_Request->isset_request('submit', 'post')) {
    $data['title'] = $nv_Request->get_title('title', 'post', '', true);
    $data['alias'] = $nv_Request->get_title('alias', 'post', '', true);
    $data['description'] = $nv_Request->get_title('description', 'post', '', true);

    $data['alias'] = empty($data['alias']) ? change_alias($data['title']) : change_alias($data['alias']);

    if (empty($data['title'])) {
        $error = $lang_module['level_error_title'];
    } else {
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level WHERE alias = :alias' . ($levelid ? ' AND levelid != ' . $levelid : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['level_error_exists'];
        } else {
            if (!$levelid) {
                $sql = 'SELECT MAX(weight) weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level';
                $result = $db->query($sql);
                $weight = $result->fetch();
                $weight = $weight['weight'] + 1;

                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_level (title, alias, description, weight, add_time, edit_time) VALUES (
                    :title, :alias, :description, ' . $weight . ', ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . '
                )';
            } else {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_level SET title = :title, alias = :alias, description = :description, edit_time = ' . NV_CURRENTTIME . ' WHERE levelid = ' . $levelid;
            }

            try {
                $sth = $db->prepare($sql);
                $sth->bindParam(':title', $data['title'], PDO::PARAM_STR);
                $sth->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
                $sth->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $sth->execute();

                if ($sth->rowCount()) {
                    if ($levelid) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit', 'ID: ' . $levelid, $admin_info['userid']);
                    } else {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Add', ' ', $admin_info['userid']);
                    }

                    $nv_Cache->delMod($module_name);
                    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
                    die();
                } else {
                    $error = $lang_module['errorsave'];
                }
            } catch (PDOException $e) {
                $error = $lang_module['errorsave'];
            }
        }
    }
}

$xtpl = new XTemplate('level.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('CAPTION', $caption);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DATA', $data);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level ORDER BY weight ASC';
$array = $db->query($sql)->fetchAll();
$num = sizeof($array);

foreach ($array as $row) {
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=level&amp;levelid=' . $row['levelid'] . "#addedit";

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

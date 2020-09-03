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

$groups_list = nv_groups_list();

$id = $nv_Request->get_int('id', 'post,get', 0);
$error = '';

if (!empty($id)) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id = ' . $id;
    $result = $db->query($sql);
    $array = $result->fetch();

    if (empty($array)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $array['hometext'] = nv_br2nl($array['hometext']);
    $array['bodytext'] = nv_editor_br2nl($array['bodytext']);
    $array['down_groups'] = $array['down_groups'] ? array_map("trim", array_filter(array_unique(explode(',', $array['down_groups'])))) : array();

    $page_title = $lang_module['edit'];
} else {
    $array = array(
        'id' => 0,
        'levelid' => 0,
        'sectorid' => 0,
        'agencyid' => 0,
        'post_id' => $admin_info['userid'],
        'title' => '',
        'alias' => '',
        'leader' => '',
        'member' => '',
        'scienceid' => '',
        'down_filepath' => '',
        'down_groups' => array(1),
        'doyear' => nv_date('Y', NV_CURRENTTIME),
        'hometext' => '',
        'bodytext' => ''
    );

    $page_title = $lang_module['add'];
}

if ($nv_Request->isset_request('submit', 'post')) {
    $array['levelid'] = $nv_Request->get_int('levelid', 'post', 0);
    $array['sectorid'] = $nv_Request->get_int('sectorid', 'post', 0);
    $array['agencyid'] = $nv_Request->get_int('agencyid', 'post', 0);
    $array['title'] = $nv_Request->get_title('title', 'post', '', true);
    $array['alias'] = $nv_Request->get_title('alias', 'post', '', true);
    $array['leader'] = $nv_Request->get_title('leader', 'post', '', true);
    $array['member'] = $nv_Request->get_string('member', 'post', '', true);
    $array['scienceid'] = $nv_Request->get_string('scienceid', 'post', '', true);
    $array['down_filepath'] = $nv_Request->get_string('down_filepath', 'post', '', true);
    $array['down_groups'] = $nv_Request->get_array('down_groups', 'post', array());
    $array['doyear'] = $nv_Request->get_int('doyear', 'post', nv_date('Y', NV_CURRENTTIME));
    $array['hometext'] = $nv_Request->get_textarea('hometext', '', NV_ALLOWED_HTML_TAGS);
    $array['bodytext'] = $nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS);

    $array['alias'] = empty($array['alias']) ? change_alias($array['title']) : change_alias($array['alias']);
    $array['down_groups'] = $array['down_groups'] ? array_intersect($array['down_groups'], array_keys($groups_list)) : array();

    if (empty($array['down_groups'])) {
        $array['down_groups'] = array(1);
    }

    if (!empty($array['down_filepath'])) {
        $array['down_filepath'] = substr($array['down_filepath'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/files/'));
    }

    if ($array['doyear'] < $global_array_config['min_year'] or $array['doyear'] > $global_array_config['max_year']) {
        $array['doyear'] = $global_array_config['min_year'];
    }

    if (empty($array['levelid'])) {
        $error = $lang_module['content_error_level'];
    } elseif (empty($array['sectorid'])) {
        $error = $lang_module['content_error_sector'];
    } elseif (empty($array['agencyid'])) {
        $error = $lang_module['content_error_agency'];
    } elseif (empty($array['title'])) {
        $error = $lang_module['content_error_title'];
    } elseif (empty($array['leader'])) {
        $error = $lang_module['content_error_leader'];
    } elseif (empty($array['member'])) {
        $error = $lang_module['content_error_member'];
    } else {
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias = :alias' . ($array['id'] ? ' AND id != ' . $array['id'] : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['content_error_alias'];
        } else {
            if (!$array['id']) {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows (
                    post_id, levelid, sectorid, agencyid, title, alias, leader, member, scienceid, down_filepath, down_groups,
                    doyear, hometext, bodytext, addtime, edittime, status
                ) VALUES (
                    ' . $array['post_id'] . ', :levelid, :sectorid, :agencyid, :title, :alias,
                    :leader, :member, :scienceid, :down_filepath, :down_groups,
                    :doyear, :hometext, :bodytext, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', 1
                )';
            } else {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
                    levelid = :levelid, sectorid = :sectorid, agencyid=:agencyid, title = :title, alias = :alias,
                    leader = :leader, member = :member, scienceid = :scienceid, down_filepath = :down_filepath, down_groups = :down_groups,
                    doyear = :doyear, hometext = :hometext, bodytext = :bodytext, edittime = ' . NV_CURRENTTIME . '
                WHERE id = ' . $array['id'];
            }

            $array['hometext'] = nv_nl2br($array['hometext']);
            $array['bodytext'] = nv_editor_nl2br($array['bodytext']);

            try {
                $down_groups = implode(',', $array['down_groups']);

                $sth = $db->prepare($sql);
                $sth->bindParam(':levelid', $array['levelid'], PDO::PARAM_INT);
                $sth->bindParam(':sectorid', $array['sectorid'], PDO::PARAM_INT);
                $sth->bindParam(':agencyid', $array['agencyid'], PDO::PARAM_INT);
                $sth->bindParam(':title', $array['title'], PDO::PARAM_STR);
                $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
                $sth->bindParam(':leader', $array['leader'], PDO::PARAM_STR);
                $sth->bindParam(':member', $array['member'], PDO::PARAM_STR);
                $sth->bindParam(':scienceid', $array['scienceid'], PDO::PARAM_STR);
                $sth->bindParam(':down_filepath', $array['down_filepath'], PDO::PARAM_STR);
                $sth->bindParam(':down_groups', $down_groups, PDO::PARAM_STR);
                $sth->bindParam(':doyear', $array['doyear'], PDO::PARAM_INT);
                $sth->bindParam(':hometext', $array['hometext'], PDO::PARAM_STR, strlen($array['hometext']));
                $sth->bindParam(':bodytext', $array['bodytext'], PDO::PARAM_STR, strlen($array['bodytext']));
                $sth->execute();

                if ($sth->rowCount()) {
                    if ($array['id']) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit', 'ID: ' . $array['id'], $admin_info['userid']);
                    } else {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Add', ' ', $admin_info['userid']);
                    }

                    $nv_Cache->delMod($module_name);
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
                } else {
                    $error = $lang_module['errorsave'];
                }
            } catch (PDOException $e) {
                $error = $lang_module['errorsave'];
            }
        }
    }
}

if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';

if (!empty($array['hometext']))
    $array['hometext'] = nv_htmlspecialchars($array['hometext']);
if (!empty($array['bodytext']))
    $array['bodytext'] = nv_htmlspecialchars($array['bodytext']);

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $array['bodytext'] = nv_aleditor('bodytext', '100%', '300px', $array['bodytext']);
} else {
    $array['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $array['bodytext'] . '</textarea>';
}

if (!empty($array['down_filepath'])) {
    $array['down_filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/files/' . $array['down_filepath'];
}

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DATA', $array);
$xtpl->assign('UPLOADS_DIR', NV_UPLOADS_DIR . '/' . $module_upload . '/files');

foreach ($groups_list as $group_id => $group_title) {
    $down_groups = array(
        'key' => $group_id,
        'checked' => in_array($group_id, $array['down_groups']) ? ' checked="checked"' : '',
        'title' => $group_title
    );

    $xtpl->assign('DOWN_GROUPS', $down_groups);
    $xtpl->parse('main.down_groups');
}

if (empty($array['alias'])) {
    $xtpl->parse('main.getalias');
}

for ($i = $global_array_config['max_year']; $i >= $global_array_config['min_year']; $i--) {
    $doyear = array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array['doyear'] ? ' selected="selected"' : ''
    );

    $xtpl->assign('DOYEAR', $doyear);
    $xtpl->parse('main.doyear');
}

foreach ($global_array_level as $level) {
    $level['selected'] = $level['levelid'] == $array['levelid'] ? ' selected="selected"' : '';

    $xtpl->assign('LEVEL', $level);
    $xtpl->parse('main.level');
}

foreach ($global_array_sector as $sector) {
    $sector['selected'] = $sector['sectorid'] == $array['sectorid'] ? ' selected="selected"' : '';

    $xtpl->assign('SECTOR', $sector);
    $xtpl->parse('main.sector');
}

foreach ($global_array_agencies as $agency) {
    $agency['selected'] = $agency['id'] == $array['agencyid'] ? ' selected="selected"' : '';

    $xtpl->assign('AGENCY', $agency);
    $xtpl->parse('main.agency');
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

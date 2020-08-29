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

/**
 * nv_main_theme()
 *
 * @param mixed $array
 * @param mixed $generate_page
 * @param mixed $is_search
 * @param mixed $num_items
 * @return
 */
function nv_main_theme($array, $generate_page, $is_search, $num_items)
{
    global $lang_module, $module_info, $global_array_level, $global_array_sector;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);

    foreach ($array as $year => $rows) {
        $xtpl->assign('YEAR', $year);

        foreach ($rows as $row) {
            $row['addtime'] = nv_date("d/m/Y", $row['addtime']);
            $row['edittime'] = nv_date("d/m/Y", $row['edittime']);
            $row['level'] = isset($global_array_level[$row['levelid']]) ? $global_array_level[$row['levelid']]['title'] : 'N/A';
            $row['sector'] = isset($global_array_sector[$row['sectorid']]) ? $global_array_sector[$row['sectorid']]['title'] : 'N/A';

            $xtpl->assign('ROW', $row);

            if (!empty($row['download_href'])) {
                $xtpl->parse('main.year.loop.download');
            }

            $xtpl->parse('main.year.loop');
        }

        $xtpl->parse('main.year');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    if (!empty($is_search)) {
        $xtpl->assign('RESULT', $num_items);
        $xtpl->parse('main.result');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_info_theme()
 *
 * @param mixed $message
 * @param mixed $link
 * @param string $type
 * @return
 */
function nv_info_theme($message, $link, $type = 'info')
{
    global $lang_module, $module_info;

    $xtpl = new XTemplate('info.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MESSAGE', $message);
    $xtpl->assign('LINK', $link);

    if ($type == 'error') {
        $xtpl->parse('main.error');
    } else {
        $xtpl->parse('main.info');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_detail_theme()
 *
 * @param mixed $row
 * @return
 */
function nv_detail_theme($row)
{
    global $lang_module, $module_info, $global_array_level, $global_array_sector;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);

    $row['addtime'] = nv_date("d/m/Y", $row['addtime']);
    $row['edittime'] = nv_date("d/m/Y", $row['edittime']);
    $row['level'] = isset($global_array_level[$row['levelid']]) ? $global_array_level[$row['levelid']]['title'] : 'N/A';
    $row['sector'] = isset($global_array_sector[$row['sectorid']]) ? $global_array_sector[$row['sectorid']]['title'] : 'N/A';
    $row['scienceid'] = empty($row['scienceid']) ? 'N/A' : $row['scienceid'];

    $xtpl->assign('ROW', $row);

    if (!empty($row['download_href'])) {
        $xtpl->parse('main.download');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

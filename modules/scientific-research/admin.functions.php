<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_FILE_ADMIN', true);

$global_array_config = [
    'min_year' => 2000,
    'max_year' => 2100
];

// Cấp độ đề tài
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_level ORDER BY weight ASC';
$global_array_level = $nv_Cache->db($sql, 'levelid', $module_name);

// Các lĩnh vực
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sector ORDER BY weight ASC';
$global_array_sector = $nv_Cache->db($sql, 'sectorid', $module_name);

// Các đơn vị
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_agencies ORDER BY weight ASC';
$global_array_agencies = $nv_Cache->db($sql, 'id', $module_name);

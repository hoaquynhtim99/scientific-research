<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_agencies WHERE status=1 ORDER BY weight ASC';
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $array_item[$row['id']] = [
        'parentid' => 0,
        'groups_view' => '6',
        'key' => $row['id'],
        'title' => $row['title'],
        'alias' => $row['alias']
    ];
}

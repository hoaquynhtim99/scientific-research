<?php

/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = [];
$array_table = [
    'agencies',
    'level',
    'sector',
    'rows'
];
$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (preg_match('/^([0-9]+)$/', $name) or in_array($name, $array_table) or preg_match('/^bodyhtml\_([0-9]+)$/', $name))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$sql_create_module = $sql_drop_module;

// Đơn vị
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_agencies (
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL,
  description text NOT NULL,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
  PRIMARY KEY (id),
  KEY weight (weight),
  KEY status (status),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_level (
  levelid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  alias varchar(250) NOT NULL,
  description text NOT NULL,
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (levelid),
  UNIQUE KEY alias(alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sector (
  sectorid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  alias varchar(250) NOT NULL,
  description text NOT NULL,
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (sectorid),
  UNIQUE KEY alias(alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
 id int(11) unsigned NOT NULL auto_increment,
 levelid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp độ đề tài',
 sectorid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Lĩnh vực',
 agencyid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Đơn vị',
 post_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ID người đăng',
 title varchar(250) NOT NULL DEFAULT '' COMMENT 'Tên đề tài',
 alias varchar(250) NOT NULL DEFAULT '',
 leader varchar(255) NOT NULL DEFAULT '' COMMENT 'Chủ nhiệm',
 member varchar(255) NOT NULL DEFAULT '' COMMENT 'Thành viên',
 scienceid varchar(255) NOT NULL DEFAULT '' COMMENT 'Số đề tài',
 doyear int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Năm thực hiện',
 down_filepath varchar(255) NOT NULL DEFAULT '' COMMENT 'File tải về',
 down_groups varchar(255) DEFAULT '' COMMENT 'Phân quyền tải file',
 hometext mediumtext NOT NULL,
 bodytext mediumtext NOT NULL,
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 edittime int(11) unsigned NOT NULL DEFAULT '0',
 status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
 PRIMARY KEY (id),
 KEY post_id (post_id),
 KEY title (title),
 KEY status (status),
 KEY doyear (doyear),
 KEY agencyid (agencyid),
 UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

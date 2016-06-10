<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (! defined('NV_ADMIN')) {
    die('Stop!!!');
}

/**
 * Note:
 * 	- Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * 	- Accept global var: $db, $db_config, $global_config
 */

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_level (levelid, title, alias, description, weight, add_time, edit_time) VALUES
(1, 'Cấp bộ', 'Cap-bo', 'Đề tài nghiên cứu khoa học cấp bộ', 1, 1448585408, 1448585408),
(2, 'Cấp tỉnh', 'Cap-tinh', 'Đề tài nghiên cứu khoa học cấp tỉnh', 2, 1448585423, 1448585423),
(3, 'Cấp Đại học Đà Nẵng', 'Cap-Dai-hoc-Da-Nang', 'Đề tài nghiên cứu khoa học cấp Đại học Đà Nẵng', 4, 1448585439, 1448585439),
(5, 'Cấp cơ sở', 'Cap-co-so', 'Đề tài nghiên cứu khoa học cấp cơ sở', 5, 1448585492, 1448585492),
(6, 'Khác', 'Khac', '', 6, 1448610849, 1448610849),
(7, 'Cấp thành phố', 'Cap-thanh-pho', '', 3, 1448611306, 1448611306);
");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (id, levelid, sectorid, post_id, title, alias, leader, member, scienceid, doyear, down_filepath, down_groups, hometext, bodytext, addtime, edittime, status) VALUES
(4, 6, 4, 1, 'Mạng lưới Thương mại Đà Nẵng&#x3A; Cấu trúc và động thái trong quá trình đô thị hóa', 'Mang-luoi-Thuong-mai-Da-Nang-Cau-truc-va-dong-thai-trong-qua-trinh-do-thi-hoa', 'Đặng Văn Mỹ', 'Đặng Văn Mỹ', 'TV-2003', 2003, '', '1', 'Đặng Văn Mỹ (2003), Mạng lưới Thương mại Đà Nẵng: Cấu trúc và động thái trong quá trình đô thị hóa', 'Đặng Văn Mỹ (2003),&nbsp;<strong>Mạng lưới Thương mại Đà Nẵng: Cấu trúc và động thái trong quá trình đô thị hóa</strong>', 1448611072, 1448611072, 1),
(3, 1, 5, 1, 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 'Ung-dung-tien-bo-ky-thuat-xay-dung-mo-hinh-san-xuat-giong-lua-DR2-va-tham-canh-lua-DR2-trong-san-xuat-tai-cac-dia-phuong-vung-dong-Truong-Son-tinh-Kon-Tum', 'Ban chủ nhiệm dự án', 'N/A', 'DANTMN', 2002, '', '1', 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 1448610967, 1448611084, 1),
(5, 1, 5, 1, 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 'Ung-dung-tien-bo-ky-thuat-xay-dung-mo-hinh-san-xuat-giong-lua-DR2-va-tham-canh-lua-DR2-trong-san-xuat-tai-cac-dia-phuong-vung-dong-Truong-Son-tinh-Kon-Tum-5', 'Ban chủ nhiệm dự án', 'N/A', 'DANTMN', 2004, '', '1', 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 'Ứng dụng tiến bộ kỹ thuật xây dựng mô hình sản xuất giống lúa DR2 và thâm canh lúa DR2 trong sản xuất tại các địa phương vùng đông Trường Sơn, tỉnh Kon Tum', 1448611163, 1448611163, 1),
(6, 6, 4, 1, 'Contribution à létude de la relation coopérative entre les producteurs et les distributeurs des produits alimentaires du Viet nam', 'Contribution-a-letude-de-la-relation-cooperative-entre-les-producteurs-et-les-distributeurs-des-produits-alimentaires-du-Viet-nam', 'Đặng Văn Mỹ', 'Đặng Văn Mỹ', 'MBA-8801', 2006, '', '1', 'Đặng Văn Mỹ (2006), ‘’Contribution à létude de la relation coopérative entre les producteurs et les distributeurs des produits alimentaires du Viet nam‘’, Mémoire de fin détude du programme de MBA-Recherche, UQÀM, Canada', '', 1448611218, 1448611218, 1),
(2, 6, 4, 1, 'Mô hình chi phí và vấn đề áp dụng trong các doanh nghiệp thương mại’', 'Mo-hinh-chi-phi-va-van-de-ap-dung-trong-cac-doanh-nghiep-thuong-mai', 'Đặng Văn Mỹ', 'Đặng Văn Mỹ', 'TV-2001', 2001, '', '1', 'Đặng Văn Mỹ (2001), ‘’Mô hình chi phí và vấn đề áp dụng trong các doanh nghiệp thương mại’’', 'Đặng Văn Mỹ (2001), ‘’<strong>Mô hình chi phí và vấn đề áp dụng trong các doanh nghiệp thương mại</strong>’’', 1448610873, 1448610981, 1),
(7, 7, 4, 1, 'Thực trạng và tiềm năng thị trường cho các sản phẩm Nông nghiệp, phi Nông nghiệp và từ nguồn tự nhiên trên địa bàn tỉnh Kon Tum', 'Thuc-trang-va-tiem-nang-thi-truong-cho-cac-san-pham-Nong-nghiep-phi-Nong-nghiep-va-tu-nguon-tu-nhien-tren-dia-ban-tinh-Kon-Tum', 'Trương Bá Thanh', 'Đặng Văn Mỹ, Đỗ Ngọc Mỹ', 'DAGN-2007', 2007, '', '1', 'Trương Bá Thanh, Đỗ Ngọc Mỹ, Đặng Văn Mỹ (2007), Thực trạng và tiềm năng thị trường cho các sản phẩm Nông nghiệp, phi Nông nghiệp và từ nguồn tự nhiên trên địa bàn tỉnh Kon Tum , Đề án nghiên cứu thực tiễn theo chương trình xóa đói giảm nghèo Miền Trung', 'Trương Bá Thanh, Đỗ Ngọc Mỹ, Đặng Văn Mỹ (2007), Thực trạng và tiềm năng thị trường cho các sản phẩm Nông nghiệp, phi Nông nghiệp và từ nguồn tự nhiên trên địa bàn tỉnh Kon Tum , Đề án nghiên cứu thực tiễn theo chương trình xóa đói giảm nghèo Miền Trung', 1448611325, 1448611325, 1),
(8, 6, 4, 1, 'Đổi mới mô hình siêu thị bán lẻ&#x3A; Trường hợp Bài Thơ Rosa', 'Doi-moi-mo-hinh-sieu-thi-ban-le-Truong-hop-Bai-Tho-Rosa', 'Đặng Văn Mỹ', 'Đặng Văn Mỹ', 'BT-2007-05', 2007, '', '1', 'Đặng Văn Mỹ, (2007), Đổi mới mô hình siêu thị bán lẻ: Trường hợp Bài Thơ Rosa , Đề án nghiên cứu Tư vấn cho Công ty Bài Thơ Rosa', '&nbsp;Đặng Văn Mỹ, (2007), Đổi mới mô hình siêu thị bán lẻ: Trường hợp Bài Thơ Rosa , Đề án nghiên cứu Tư vấn cho Công ty Bài Thơ Rosa', 1448611383, 1448611383, 1),
(9, 5, 5, 1, 'Phân lập và xác định một số yếu tố gây bệnh của vi khuẩn Salmonella phân lập được trên trâu bò nuôi tại Thành Phố Buôn Ma Thuột - Tỉnh Đăklăk', 'Phan-lap-va-xac-dinh-mot-so-yeu-to-gay-benh-cua-vi-khuan-Salmonella-phan-lap-duoc-tren-trau-bo-nuoi-tai-Thanh-Pho-Buon-Ma-Thuot-Tinh-Daklak', 'Thái Thị Bích Vân', 'Thái Thị Bích Vân', '60 62 50', 2007, '', '1', 'Phân lập và xác định một số yếu tố gây bệnh của vi khuẩn Salmonella phân lập được trên trâu bò nuôi tại Thành Phố Buôn Ma Thuột - Tỉnh Đăklăk', 'TÓM TẮT BẰNG TIẾNG VIỆT Sau khi kiểm tra 93 mẫu, chúng tôi thấy rằng trâu bò ở Thành Phố Buôn Ma Thuột nhiễm Salmonella 22,58%, trong đó trâu bò bình thường ≤12 tháng tuổi nhiễm Salmonella 27,45% và trâu bò &gt;12 tháng tuổi nhiễm 16,67%. Vào mùa mưa, trâu bò nhiễm Salmonella 25,45% và vào mùa khô nhiễm 18,42%. Vi khuẩn Salmonella giết chết chuột với tỷ lệ 63,09%, trong đó Salmonella lấy từ mẫu phân trâu bò bình thường làm chết chuột với tỷ lệ 55,00% và Salmonella lấy từ trâu bò tiêu chảy là 70,45%. Có 23,81% số mẫu vi khuẩn Salmonella phân lập được thể hiện khả năng sản sinh độc tố và không có mẫu Salmonella nào phân lập từ trâu bò bình thường thể hiện khả năng này. Vi khuẩn Salmonella phân lập được có khả năng xâm nhập vào niêm mạc mắt chuột lang với tỷ lệ là 52,38%, trong đó Salmonella từ trâu bò bình thường là 30,00% và Salmonella từ trâu bò tiêu chảy là 72,73%. Salmonella mẫn cảm cao nhất với Ciprofloxacin, Neomycin (100%) và kháng cao nhất với Ampycilin (72,73%). TÓM TẮT BẰNG TIẾNG ANH Subject’s name: Subdivide and define in some factor pathogenic of Salmonella bacteria on cattles in Buon Ma Thuot City-Daklak Province. SUMMARY After examing 93 samples, we find that: cattles in Buon Ma Thuot City infected Samonella 22,58%, in there cattles lower than 12 months age was 27,45% and cattles upper than 12 months age was16,67%. Health cattles infected Salmonella 18,87% and diarrheic cattles infected 27,50%. In rainy season, cattles infected 25,45% and in dry season 18,42%. Salmonella bacteria died the rats with rate 63,09%, in there: Salmonella of faeces samples health cattles was 55,00% and salmonella of faeces samples diarrheic was 70,45%. The ability to generate toxin enteritis of Salmonella was 23,81% and nothing Salmonella subdivited by faeces samples health cattles. The ability of break into mucous membrance of guinea-pig was 52,38%, in there Salmonella of faeces samples health cattles with rate 30,00% and salmonella of faeces samples diarrheic was 72,73%. Salmonella was highest sensitiving with Ciprofloxacin, Neomycin (100%) and Ampycilin was highest resisting rate (72,73%).&nbsp;<br  />- Sản phẩm là tìm ra được những biện pháp phòng trị hội chứng tiêu chảy ở trâu, bò. - Địa chỉ ứng dụng: Tại Thành phố Buôn Ma Thuộc, tỉnh Đắk Lắk.', 1448611458, 1448613689, 1);
");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sector (sectorid, title, alias, description, weight, add_time, edit_time) VALUES
(1, 'Khoa học, Công nghệ', 'Khoa-hoc-Cong-nghe', '', 1, 1448585861, 1448585861),
(2, 'Kinh tế', 'Kinh-te', '', 2, 1448585874, 1448585874),
(4, 'Xã hội nhân văn', 'Xa-hoi-nhan-van', '', 3, 1448610861, 1448610861),
(5, 'Nông lâm ngư', 'Nong-lam-ngu', '', 4, 1448610944, 1448610944);
");

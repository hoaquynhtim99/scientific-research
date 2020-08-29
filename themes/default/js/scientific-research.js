/**
 * @Project SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

$(document).ready(function(){
    $('#scien-fearch-form').submit(function(e){
        if( $(this).find('[name="q"]').val() == '' ){
            e.preventDefault();
            alert($(this).data('notice'));
        }else{
            return 1;
        }
    });
});

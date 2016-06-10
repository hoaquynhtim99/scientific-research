/**
 * @Project VIDEO SCIENTIFIC RESEARCH 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jun 2016 02:20:31 GMT
 */

function nv_change_weight_res(res) {
    var r_split = res.split("_");
    if (r_split[0] != 'OK') {
        alert(nv_is_change_act_confirm[2]);
        clearTimeout(nv_timer);
    } else {
        window.location.href = window.location.href;
    }
    return;
}

function nv_change_level_weight(levelid) {
    var nv_timer = nv_settimeout_disable('change_weight_' + levelid, 5000);
    var new_weight = $('#change_weight_' + levelid).val();
    $.post(
        script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=level&nocache=' + new Date().getTime(), 
        'changeweight=1&levelid=' + levelid + '&new_weight=' + new_weight, function(res) {
        nv_change_weight_res(res);
    });
    return;
}
function nv_del_level(levelid) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=level&nocache=' + new Date().getTime(),
            'delete=1&levelid=' + levelid, function(res) {
            var r_split = res.split("_");
            if (r_split[0] == 'OK') {
                window.location.href = window.location.href;
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}
function get_level_alias(id){
    var title = strip_tags(document.getElementById('idtitle').value);
    if (title != '') {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=level&nocache=' + new Date().getTime(), 
            'changealias=1&title=' + encodeURIComponent(title) + '&id=' + id, function(res) {
            if (res != "") {
                document.getElementById('idalias').value = res;
            } else {
                document.getElementById('idalias').value = '';
            }
        });
    }
}

function nv_change_sector_weight(sectorid) {
    var nv_timer = nv_settimeout_disable('change_weight_' + sectorid, 5000);
    var new_weight = $('#change_weight_' + sectorid).val();
    $.post(
        script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sector&nocache=' + new Date().getTime(), 
        'changeweight=1&sectorid=' + sectorid + '&new_weight=' + new_weight, function(res) {
        nv_change_weight_res(res);
    });
    return;
}
function nv_del_sector(sectorid) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sector&nocache=' + new Date().getTime(),
            'delete=1&sectorid=' + sectorid, function(res) {
            var r_split = res.split("_");
            if (r_split[0] == 'OK') {
                window.location.href = window.location.href;
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}
function get_sector_alias(id){
    var title = strip_tags(document.getElementById('idtitle').value);
    if (title != '') {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sector&nocache=' + new Date().getTime(), 
            'changealias=1&title=' + encodeURIComponent(title) + '&id=' + id, function(res) {
            if (res != "") {
                document.getElementById('idalias').value = res;
            } else {
                document.getElementById('idalias').value = '';
            }
        });
    }
}

function get_alias(id){
    var title = strip_tags(document.getElementById('idtitle').value);
    if (title != '') {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(), 
            'changealias=1&title=' + encodeURIComponent(title) + '&id=' + id, function(res) {
            if (res != "") {
                document.getElementById('idalias').value = res;
            } else {
                document.getElementById('idalias').value = '';
            }
        });
    }
}

function nv_change_status( id ){
    var nv_timer = nv_settimeout_disable( 'change_status' + id, 4000 );
    $.post(
        script_name + '?' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(), 
        'changestatus=1&id=' + id, function(res){
            if( res != 'OK' ){
                alert( nv_is_change_act_confirm[2] );
                window.location.href = window.location.href;
            }
    });
}

function nv_del_row(id) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(
            script_name + '?' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(),
            'delete=1&id=' + id, function(res) {
            var r_split = res.split("_");
            if (r_split[0] == 'OK') {
                window.location.href = window.location.href;
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
}

$(document).ready(function(){
    $("#select-file").click(function(){
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=post-file&alt=&path=" + $(this).data('path') + "&type=file&currentpath=" + $(this).data('path'), "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    });
});
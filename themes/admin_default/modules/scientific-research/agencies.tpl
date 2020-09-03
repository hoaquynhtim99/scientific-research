<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col class="w100">
        </colgroup>
        <thead>
            <tr>
                <th style="width: 10%" class="text-nowrap">{LANG.order}</th>
                <th style="width: 65%" class="text-nowrap">{LANG.direction_title}</th>
                <th style="width: 15%" class="text-center text-nowrap">{LANG.status}</th>
                <th style="width: 10%" class="text-center text-nowrap">{LANG.function}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">
                    <select id="change_weight_{ROW.id}" onchange="nv_change_agencies_weight('{ROW.id}');" class="form-control input-sm">
                        <!-- BEGIN: weight -->
                        <option value="{WEIGHT.w}"{WEIGHT.selected}>{WEIGHT.w}</option>
                        <!-- END: weight -->
                    </select>
                </td>
                <td>
                    <strong>{ROW.title}</strong>
                </td>
                <td class="text-center">
                    <input name="status" id="change_status{ROW.id}" value="1" type="checkbox"{ROW.status_render} onclick="nv_change_agencies_status('{ROW.id}');">
                </td>
                <td class="text-center text-nowrap">
                    <a class="btn btn-sm btn-default" href="{ROW.url_edit}"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="nv_delele_agencies('{ROW.id}');"><i class="fa fa-trash"></i> {GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<h2><i class="fa fa-th-large" aria-hidden="true"></i> {CAPTION}</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{FORM_ACTION}" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-6 control-label">{LANG.agencie_title} <span class="text-danger">(<em class="fa fa-asterisk"></em>)</span>:</label>
                <div class="col-sm-18 col-lg-10">
                    <input type="text" id="idtitle" name="title" value="{DATA.title}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">{LANG.alias}:</label>
                <div class="col-sm-18 col-lg-10">
                    <div class="input-group">
                        <input type="text" id="idalias" name="alias" value="{DATA.alias}" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="get_agencies_alias('{DATA.id}')"><i class="fa fa-retweet"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">{LANG.description}:</label>
                <div class="col-sm-18 col-lg-10">
                    <textarea class="form-control" rows="3" name="description">{DATA.description}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-18 col-sm-offset-6">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">{GLANG.submit}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- BEGIN: getalias -->
<script type="text/javascript">
$(document).ready(function(){
    $("#idtitle").change(function(){
        get_agencies_alias('{DATA.id}');
    });
});
</script>
<!-- END: getalias -->
<!-- END: main -->

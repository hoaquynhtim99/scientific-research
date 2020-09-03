<!-- BEGIN: main -->
<div class="row">
    <div class="col-sm-12">
        <form method="get" action="{NV_BASE_ADMINURL}index.php" class="form-inline">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
            <div class="form-group">
                <input type="text" class="form-control minw200" name="q" value="{SEARCH.q}" placeholder="{LANG.enter_search_key}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> {GLANG.search}</button>
            </div>
        </form>
    </div>
    <div class="col-sm-12">
        <div class="form-group clearfix">
            <a href="{LINK_ADD_NEW}" class="btn btn-success pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {LANG.add}</a>
        </div>
    </div>
</div>
<form>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 1%" class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"></th>
                    <th>{LANG.title}</th>
                    <th class="w150 text-center ">{LANG.status}</th>
                    <th class="w150 text-center">{LANG.function}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">
                        <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]">
                    </td>
                    <td><a href="{ROW.link}">{ROW.title}</a></td>
                    <td class="text-center">
                        <input name="status" id="change_status{ROW.id}" value="1" type="checkbox"{ROW.status_render} onclick="nv_change_status('{ROW.id}');" />
                    </td>
                    <td class="text-center">
                        <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
                        <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_row('{ROW.id}');">{GLANG.delete}</a>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="4">
                        {GENERATE_PAGE}
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
        </table>
    </div>
    <div class="form-group form-inline">
        <div class="form-group">
            <select class="form-control" id="action-of-content">
                <option value="delete">{GLANG.delete}</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="nv_content_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')">{GLANG.submit}</button>
    </div>
</form>
<!-- END: main -->

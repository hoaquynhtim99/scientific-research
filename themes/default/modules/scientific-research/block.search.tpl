<!-- BEGIN: main -->
<div class="well">
    <form id="scien-fearch-form" role="form" class="form-horizontal mb0" method="get" action="{FORM_ACTION}" data-notice="{LANG.search_error_q}">
        <!-- BEGIN: no_rewrite -->
        <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}">
        <!-- END: no_rewrite -->
        <div class="row clearfix">
            <div class="col-sm-8">
                <input type="text" class="form-control mb0" name="q" value="{SEARCH_KEY}" placeholder="{LANG.search_q}">
            </div>
            <div class="col-sm-6">
                <select class="form-control mb0" name="l">
                    <option value="0">{LANG.search_level_all}</option>
                    <!-- BEGIN: level --><option value="{LEVEL.levelid}"{LEVEL.selected}>{LEVEL.title}</option><!-- END: level -->
                </select>
            </div>
            <div class="col-sm-6">
                <select class="form-control mb0" name="s">
                    <option value="0">{LANG.search_sector_all}</option>
                    <!-- BEGIN: sector --><option value="{SECTOR.sectorid}"{SECTOR.selected}>{SECTOR.title}</option><!-- END: sector -->
                </select>
            </div>
            <div class="col-sm-4">
                <input type="submit" name="submit" value="{LANG.search}" class="btn btn-warning btn-block">
            </div>
        </div>
    </form>
</div>
<!-- END: main -->

<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form method="post" action="{FORM_ACTION}">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <col class="w200"/>
            <tbody>
                <tr>
                    <td class="text-right text-strong">{LANG.level}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <select name="levelid" class="form-control w300">
                            <!-- BEGIN: level --><option value="{LEVEL.levelid}"{LEVEL.selected}>{LEVEL.title}</option><!-- END: level -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.sector}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <select name="sectorid" class="form-control w300">
                            <!-- BEGIN: sector --><option value="{SECTOR.sectorid}"{SECTOR.selected}>{SECTOR.title}</option><!-- END: sector -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_title}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <input type="text" id="idtitle" name="title" value="{DATA.title}" class="form-control w500">
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.alias}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <div class="input-group w500">
                            <input type="text" id="idalias" name="alias" value="{DATA.alias}" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="get_alias('{DATA.id}');"><i class="fa fa-retweet"></i></button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_doyear}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <select name="doyear" class="form-control w300">
                            <!-- BEGIN: doyear --><option value="{DOYEAR.key}"{DOYEAR.selected}>{DOYEAR.title}</option><!-- END: doyear -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_leader}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <input type="text" name="leader" value="{DATA.leader}" class="form-control w500">
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_member}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
                    <td>
                        <input type="text" name="member" value="{DATA.member}" class="form-control w200">
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_scienceid}</td>
                    <td>
                        <input type="text" name="scienceid" value="{DATA.scienceid}" class="form-control w500">
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_down_filepath}</td>
                    <td>
                        <div class="input-group w500">
                            <input type="text" id="post-file" name="down_filepath" value="{DATA.down_filepath}" class="form-control">
                            <span class="input-group-btn">
                                <button data-path="{UPLOADS_DIR}" id="select-file" class="btn btn-default" type="button"><i class="fa fa-file-pdf-o"></i></button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_down_groups}</td>
                    <td>
                        <!-- BEGIN: down_groups -->
                        <div class="row">
                            <label><input name="down_groups[]" type="checkbox" value="{DOWN_GROUPS.key}" {DOWN_GROUPS.checked} />{DOWN_GROUPS.title}</label>
                        </div>
                        <!-- END: down_groups -->
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_hometext}</td>
                    <td>
                        <textarea name="hometext" class="form-control">{DATA.hometext}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="text-right text-strong">{LANG.content_bodytext}</td>
                    <td>
                        {DATA.bodytext}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="{DATA.id}">
                        <input type="submit" name="submit" value="{GLANG.submit}" class="btn btn-primary">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</form>
<!-- BEGIN: getalias -->
<script type="text/javascript">
$(document).ready(function(){
    $("#idtitle").change(function(){
        get_alias('{DATA.id}');
    });
});
</script>
<!-- END: getalias -->
<!-- END: main -->
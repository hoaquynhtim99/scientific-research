<!-- BEGIN: main -->
<h1 class="mb20">{ROW.title}</h1>
<table class="table mb20 table-bordered table-striped table-condensed">
    <tbody>
        <tr>
            <th class="text-right">{LANG.content_leader}</th>
            <td>{ROW.leader}</td>
            <th class="text-right">{LANG.content_member}</th>
            <td>{ROW.member}</td>
        </tr>
        <tr>
            <th class="text-right">{LANG.content_scienceid}</th>
            <td>{ROW.scienceid}</td>
            <th class="text-right">{LANG.content_doyear}</th>
            <td>{ROW.doyear}</td>
        </tr>
        <tr>
            <th class="text-right">{LANG.content_level}</th>
            <td>{ROW.level}</td>
            <th class="text-right">{LANG.content_sector}</th>
            <td>{ROW.sector}</td>
        </tr>
        <tr>
            <th class="text-right">{LANG.agency}</th>
            <td colspan="3">
                <a href="{ROW.agency_link}">{ROW.agency}</a>
            </td>
        </tr>
    </tbody>
</table>
<div class="bodytext">{ROW.bodytext}</div>
<!-- BEGIN: download -->
<div class="alert alert-success mt15">
    <div class="message-box-title"><strong>{LANG.download}</strong>:</div>
    <div class="message-box-content">
        <a href="{ROW.download_href}" title="{LANG.download}" rel="nofollow"><i class="icon-download-alt"></i> {ROW.download_filename}</a>
    </div>
</div>
<!-- END: download -->
<!-- END: main -->

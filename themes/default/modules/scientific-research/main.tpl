<!-- BEGIN: main -->
<!-- BEGIN: result -->
<div class="m-bottom text-right">
    {LANG.search_result}: <strong class="text-danger">{RESULT}</strong> {LANG.search_result1}.
</div>
<!-- END: result -->
<!-- BEGIN: year -->
<div class="h2"><strong>{LANG.year} {YEAR}</strong></div>
<div class="gdl-divider gdl-border-x top mb15"><div class="scroll-top"></div></div>
<!-- BEGIN: loop -->
<div class="scien-list-item">
    <div class="shortcode-dropcap circle bgorange">{ROW.stt}</div>
    <h3><a href="{ROW.link}">{ROW.title}</a></h3>
    <p>
        <strong>{LANG.content_leader}: </strong>{ROW.leader}
        <strong>{LANG.content_member}: </strong>{ROW.member}
        <strong>{LANG.content_scienceid}: </strong>{ROW.scienceid}
        <strong>{LANG.content_doyear}: </strong>{ROW.doyear}
        <strong>{LANG.content_level}: </strong>{ROW.level}
        <strong>{LANG.content_sector}: </strong>{ROW.sector}
        <!-- BEGIN: download -->
        <a href="{ROW.download_href}" title="{LANG.download}" rel="nofollow"><i class="fa fa-download"></i> {LANG.download}</a>
        <!-- END: download -->
    </p>
</div>
<!-- END: loop -->
<!-- END: year -->
<!-- BEGIN: generate_page -->
<div class="text-center">{GENERATE_PAGE}</div>
<!-- END: generate_page -->
<!-- END: main -->

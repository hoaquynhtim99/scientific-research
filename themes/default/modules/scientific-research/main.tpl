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
    <div class="item-stt">
        <div class="shortcode-dropcap circle bgorange">{ROW.stt}</div>
    </div>
    <div class="item-content">
        <h3 class="mb-2"><a href="{ROW.link}">{ROW.title}</a></h3>
        <div class="row row-item-detail">
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_leader}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.leader}</div>
                </div>
            </div>
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_member}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.member}</div>
                </div>
            </div>
        </div>
        <div class="row row-item-detail">
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_scienceid}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.scienceid}</div>
                </div>
            </div>
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_doyear}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.doyear}</div>
                </div>
            </div>
        </div>
        <div class="row row-item-detail">
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_level}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.level}</div>
                </div>
            </div>
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_sector}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.sector}</div>
                </div>
            </div>
        </div>
        <div class="row row-item-detail">
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.agency}:</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">{ROW.agency}</div>
                </div>
            </div>
            <!-- BEGIN: download -->
            <div class="col-xs-24 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 text-right"><strong>{LANG.content_file}</strong></div>
                    <div class="col-xs-12 col-sm-14 col-md-16">
                        <a href="{ROW.download_href}" title="{LANG.download}" rel="nofollow"><i class="fa fa-download"></i> {LANG.download}</a>
                    </div>
                </div>
            </div>
            <!-- END: download -->
        </div>
    </div>
</div>
<!-- END: loop -->
<!-- END: year -->
<!-- BEGIN: generate_page -->
<div class="text-center">{GENERATE_PAGE}</div>
<!-- END: generate_page -->
<!-- END: main -->

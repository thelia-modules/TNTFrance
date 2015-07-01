{default_translation_domain domain='tntfrance.fo.default'}

{include file="util-days-name.tpl"}


        <div class="u-tnt-pt">

            {* <h3>{block name="title"}{/block}</h3> *}

            {strip}
            {capture name="form"}
            {block name="form"}{/block}
            {/capture}
            {/strip}

            {if $smarty.capture.form}
                {$smarty.capture.form nofilter}
            {/if}

            {block name="body"}{/block}

            {block name="postage"}<div>{$postage}</div>{/block}

        </div>

    <div class="row hidden">
        <div class="col-md-12 u-tnt-pb u-tnt-pt">
            <button class="js-tnt-save-configuration btn btn-primary pull-right">{intl l='Use this delivery service'}</button>
        </div>
    </div>
    <div id="tnt-faisability"></div>
    <div id="tnt-validate-delivery" class="row hidden">
        <div class="col-md-12 u-tnt-pb u-tnt-pt">
            <button class="js-tnt-select btn btn-primary pull-right">{intl l='Validate this delivery service'}</button>
        </div>
    </div>

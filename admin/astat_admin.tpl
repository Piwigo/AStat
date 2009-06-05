<div class="titrePage">
  <h2 style="position:absolute;right:0px;top:32px;height:auto;font-size:12px;font-weight:normal;">:: {$plugin.ASTAT_VERSION} ::</h2>
  <h2>{'AStat_title_page'|@translate} <span style="font-size:-1;font-weight:normal;">{$TABSHEET_TITLE}</span></h2>

  {$tabsheet}
</div>

{if isset($datas)}
  {$datas.ASTAT_NFO_STAT}
  <h3>{$datas.L_STAT_TITLE}</h3>

  {if isset($f_AStat_catfilter_list_values) and count($f_AStat_catfilter_list_values)
         and isset($plugin.ASTAT_PAGE) and $plugin.ASTAT_PAGE != "config" and $plugin.ASTAT_PAGE != "tools"}
    <center>
      <form method="GET" action="{$plugin.ASTAT_LINK}" class="general">

          {if isset($f_AStat_parameters) and count($f_AStat_parameters)}
            {foreach from=$f_AStat_parameters key=name item=data}
              <INPUT type="hidden" name="{$data.NAME}" value="{$data.VALUE}">
            {/foreach}
          {/if}
          <fieldset>
            <legend>{'AStat_catfilter_list'|@translate}</legend>
            <select name="fAStat_catfilter" onchange="this.form.submit();">
              {html_options values=$f_AStat_catfilter_list_values output=$f_AStat_catfilter_list_labels selected=$f_AStat_catfilter_selected}
            </select>
          </fieldset>
      </form>
    </center>
  {/if}

{/if}

{$ASTAT_BODY_PAGE}


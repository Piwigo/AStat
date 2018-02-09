
  {if isset($datas)}
    <h2>{$datas.L_STAT_TITLE}</h2>
    {if isset($datas.ASTAT_NFO_STAT)}<p>{$datas.ASTAT_NFO_STAT}</p>{/if}


    {if isset($f_AStat_catfilter_list_values) and count($f_AStat_catfilter_list_values)
           and isset($plugin.ASTAT_PAGE) and $plugin.ASTAT_PAGE != "config" and $plugin.ASTAT_PAGE != "tools"}
      <center>
        <form method="GET" action="{$ASTAT_LINK}" class="general">

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


{$datas.ASTAT_SORT_LABEL}
<table class="table2 littlefont" id="dailyStats">
  <tr class="throw">
    <th>{$datas.ASTAT_LABEL_IP_label}</th>
    <th>{$datas.ASTAT_LABEL_Pages_seen}<span class="MiniSquare1">&nbsp;&diams;</span></th>
    <th>{$datas.ASTAT_LABEL_Pictures_seen}<span class="MiniSquare2">&nbsp;&diams;</span></th>
    <th>&nbsp;</th>
  </tr>
  {if isset($datarows) and count($datarows)}
    {foreach from=$datarows key=name item=data}
      <tr class="StatTableRow">
        <td style="white-space: nowrap">{$data.ASTAT_IP_BLACKLIST} {$data.ASTAT_IP_GEOLOCALISATION} {$data.ASTAT_IP_ADRESS}</td>
        <td class="number">{$data.PAGES}</td>
        <td class="number">{$data.PICTURES}</td>
        <td>
          <div class="AStatBar1" style="width:{$data.WIDTH2}px" />
          <div class="AStatBar2" style="width:{$data.WIDTH1}px" />
        </td>
      </tr>
    {/foreach}
  {/if}
</table>
{$datas.NB_TOTAL_IP}
{if isset($datas.ASTAT_TIME_REQUEST)}
  <div class='time_request'>{$datas.ASTAT_TIME_REQUEST}</div>
{/if}

{if isset($datas.PAGES_LINKS)}
  <h3>{$datas.PAGES_LINKS}</h3>
{/if}


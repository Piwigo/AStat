<table class="table2 littlefont" id="dailyStats">
  <tr class="throw">
    <th>{$datas.PERIOD_LABEL}</th>
    <th>{'Pages seen'|@translate}<span class="MiniSquare1">&nbsp;&diams;</span></th>
    <th>{'Pictures_seen'|@translate}<span class="MiniSquare2">&nbsp;&diams;</span></th>
    <th>{'Categories_seen'|@translate}<span class="MiniSquare4">&nbsp;&diams;</span></th>
    <th>{'IP_visit'|@translate}<span class="MiniSquare3">&nbsp;&diams;</span></th>
    <th></th>
  </tr>

  {if isset($datarows) and count($datarows)}
    {foreach from=$datarows key=name item=data}
      <tr class="StatTableRow">
        <td style="white-space: nowrap">{$data.VALUE}</td>
        <td class="number">{$data.PAGES}</td>
        <td class="number">{$data.PICTURES}</td>
        <td class="number">{$data.CATEGORIES}</td>
        <td class="number">{$data.IPVISIT}</td>
        <td>
          <div class="AStatBar1" style="width:{$data.WIDTH3}px" />
          <div class="AStatBar2" style="width:{$data.WIDTH2}px" />
          <div class="AStatBar4" style="width:{$data.WIDTH4}px" />
          <div class="AStatBar3" style="width:{$data.WIDTH1}px" />
        </td>
      </tr>
    {/foreach}
  {/if}
</table>

{if isset($datas.ASTAT_TIME_REQUEST)}
  <div class='time_request'>{$datas.ASTAT_TIME_REQUEST}</div>
{/if}

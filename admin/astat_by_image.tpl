{literal}
<script type="text/javascript">

 var mouseX, mouseY; 

 window.onmousemove = function (evt) 
 {
	mouseX = evt.clientX;
	mouseY = evt.clientY;
 }

 function load_thumb(thumbjpg)
 {
	var thumbobj = document.getElementById('thumb_view');

	if(thumbjpg!='')
	{ thumbobj.innerHTML = "<img class='img_thumb' src='"+thumbjpg+"'/>";
	  thumbobj.style.visibility = 'visible'; }
 }


 function display_thumb()
 {
	var thumbobj = document.getElementById('thumb_view');

	thumbobj.style.left = (mouseX + 15 + window.pageXOffset)+"px";
	thumbobj.style.top = (mouseY + 5 + window.pageYOffset)+"px";
 }

 function unload_thumb()
 {
	var thumbobj = document.getElementById('thumb_view');

	thumbobj.style.visibility = 'hidden';
 }
</script>
{/literal}

<div class="window_thumb" id="thumb_view"></div>
{$datas.ASTAT_SORT_LABEL}
<table class="table2 littlefont" id="dailyStats">
  <tr class="throw">
    <th>{$datas.ASTAT_LABEL_AStat_RefImageLabel}</th>
    <th>{$datas.ASTAT_LABEL_Pictures_seen}<span class="MiniSquare1">&nbsp;&diams;</span></th>
    <th>{$datas.ASTAT_LABEL_pct_Pictures_seen}<span class="MiniSquare2">&nbsp;&diams;</span></th>
    <th>&nbsp;</th>
  </tr>
  {if isset($datarows) and count($datarows)}
    {foreach from=$datarows key=name item=data}
      <tr class="StatTableRow" onmouseover="load_thumb('{$data.THUMBJPG}')" onmousemove="display_thumb()" onmouseout="unload_thumb()">
        <td style="white-space: nowrap"  >{$data.IMAGE}</td>
        <td class="number">{$data.NBPICTURES}</td>
        <td class="number">{$data.PCTPICTURES}</td>
        <td>
          <div class="AStatBarX" style="width:{$datas.MAX_WIDTH}px" />
          <div class="AStatBar1" style="width:{$data.WIDTH2}px" />
          <div class="AStatBar2" style="width:{$data.WIDTH1}px" />
        </td>
      </tr>
    {/foreach}
  {/if}
</table>

{$datas.NB_TOTAL_IMAGE}

{if isset($datas.ASTAT_TIME_REQUEST)}
  <div class='time_request'>{$datas.ASTAT_TIME_REQUEST}</div>
{/if}

{if isset($datas.PAGES_LINKS)}
  <h3>{$datas.PAGES_LINKS}</h3>
{/if}



{include file='include/datepicker.inc.tpl'}

{footer_script}{literal}

 function enabled_purge()
 {
  re = /\d{2}\/\d{2}\/\d{4}/i;

  if(($('#purge_history_confirm').is(':checked')&&$('#purge_history_type0').is(':checked')&&re.test($('#purge_history_date').val()))||
     ($('#purge_history_confirm').is(':checked')&&!$('#purge_history_type0').is(':checked')))
  {
    $('#purge_history_button').attr('disabled', false);
  }
  else
  {
    $('#purge_history_button').attr('disabled', true);
  }
 }

 function enabled_deleted_picture()
 {
  var objconfirm = document.getElementById('deleted_picture_confirm_resync');
  var objbutton = document.getElementById('deleted_picture_resync_button');

  if($('#deleted_picture_confirm_resync').is(':checked'))
  {
    $('deleted_picture_resync_button').attr('disabled', false);
  }
  else
  {
    $('deleted_picture_resync_button').attr('disabled', true);
  }
 }

 function init()
 {
   $("#purge_history_date").datepicker({
     dateFormat: 'dd/mm/yy',
     constrainInput: true,
     defaultDate:"-12m",
     maxDate:0,
     minDate:new Date({/literal}"{$datas.ASTAT_MINDATE}"{literal})
   });
 }

 init();

{/literal}{/footer_script}

{if isset($datas.ASTAT_RESULT_OK)}{$datas.ASTAT_RESULT_OK}{/if}

<fieldset class='formtable'>
  <legend>{'AStat_tools_general_nfo'|@translate}</legend>
  <p>{$datas.ASTAT_GENERAL_NFO}</p>
</fieldset>



<form method="post" action="" class="general">
  <fieldset class='formtable'>
    <legend>{'AStat_tools_deleted_user'|@translate}</legend>
    <p>{'AStat_tools_deleted_user_nfo0'|@translate}</p>
    <p>{$datas.ASTAT_DELETED_USER_NFO}</p>
    {if isset($datas.AStat_deleted_user_submit) and $datas.AStat_deleted_user_submit == 'yes'}
      <p class='formtable'>
        <input type="submit" value="{'AStat_tools_deleted_user_apply'|@translate}" name="apply_tool_deleted_user"/>
      </p>
    {/if}
  </fieldset>
</form>


<fieldset class='formtable'>
  <legend>{'AStat_tools_deleted_picture'|@translate}</legend>
  <p>{'AStat_tools_deleted_picture_nfo0'|@translate}</p>
  <p>{$datas.ASTAT_DELETED_PICTURE_NFO}</p>
  <form method="post" action="" class="general">
    {if isset($datas.AStat_deleted_picture_submit0) and $datas.AStat_deleted_picture_submit0 == 'yes'}
      <p class='formtable'>
        <input type="submit" value="{'AStat_tools_deleted_picture_apply'|@translate}" name="apply_tool_deleted_picture"/>
      </p>
    {/if}
  </form>
  <hr/>
  <p>{'AStat_tools_deleted_picture_nfo3'|@translate}</p>

  <form method="post" action="" class="general">
    <p>
      <label>
        <input type="radio" value="prepare" name="fAStat_tools_deleted_picture_action" id="deleted_picture0" {$datas.ASTAT_DELETED_PICTURE_PREPARE} >&nbsp;
        {'AStat_tools_deleted_picture_prepare_action'|@translate}
      </label><br>
      <label>
        <input type="radio" value="apply" name="fAStat_tools_deleted_picture_action" id="deleted_picture1" {$datas.ASTAT_DELETED_PICTURE_DO_ACTION} >&nbsp;
        {'AStat_tools_deleted_picture_do_action'|@translate}{$datas.ASTAT_DELETED_PICTURE_NFO_NB}
      </label>
    </p>
    <p class='formtable'>
      <input type="checkbox" id="deleted_picture_confirm_resync" onclick="enabled_deleted_picture();"/>
      <input type="submit" value="{'AStat_tools_deleted_picture_do'|@translate}" name="apply_tool_deleted_picture_resync" id="deleted_picture_resync_button" disabled />
    </p>
  </form>
</fieldset>


<fieldset class='formtable'>
  <legend>{'AStat_tools_deleted_category'|@translate}</legend>
  <p>{'AStat_tools_deleted_category_nfo0'|@translate}</p>
  <p>{$datas.ASTAT_DELETED_CATEGORY_NFO}</p>
  <form method="post" action="" class="general">
    {if isset($datas.AStat_deleted_category_submit0) and $datas.AStat_deleted_category_submit0=='yes'}
    <p class='formtable'>
      <input type="submit" value="{'AStat_tools_deleted_category_apply'|@translate}" name="apply_tool_deleted_category"/>
    </p>
    {/if}
  </form>
</fieldset>


<fieldset class='formtable'>
  <legend>{'AStat_tools_purge_history'|@translate}</legend>
  <p>{'AStat_tools_purge_history_nfo'|@translate}</p>
  <form method="post" action="" class="general">
    <p>
      <label>
        <input type="radio" value="bydate" name="fAStat_purge_history_type" id="purge_history_type0" checked onclick="enabled_purge();">&nbsp;
        {'AStat_tools_purge_history_date'|@translate}
      </label>

      <input type="text" id="purge_history_date" name="fAStat_purge_history_date" size="10" onchange="enabled_purge();"/><br>

      <label>
        <input type="radio" value="byimageid0" name="fAStat_purge_history_type" id="purge_history_type1" onclick="enabled_purge();" {$datas.ASTAT_PURGE_HISTORY_IMAGE_DISABLED} >&nbsp;
        {$datas.ASTAT_PURGE_HISTORY_IMAGE_NFO}
      </label>
      <br/>

      <label>
        <input type="radio" value="bycategoryid0" name="fAStat_purge_history_type" id="purge_history_type2" onclick="enabled_purge();" {$datas.ASTAT_PURGE_HISTORY_CATEGORY_DISABLED}>&nbsp;
        {$datas.ASTAT_PURGE_HISTORY_CATEGORY_NFO}
      </label>
      <br/>

      <label>
        <input type="radio" value="byipid0" name="fAStat_purge_history_type" id="purge_history_type3" onclick="enabled_purge();" {$datas.ASTAT_PURGE_HISTORY_IP_DISABLED}>&nbsp;
        {$datas.ASTAT_PURGE_HISTORY_IP_NFO}
      </label>
    </p>

    <p class='formtable'>
      <input type="checkbox" id="purge_history_confirm" onclick="enabled_purge();"/>
      <input type="submit" value="{'AStat_tools_purge_history_apply'|@translate}" name="apply_tool_purge_history" id="purge_history_button" disabled />
    </p>

  </form>
</fieldset>

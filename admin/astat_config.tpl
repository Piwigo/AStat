{literal}
<script type="text/javascript">

  function change_color(inputzone, colorsquare)
  {
    var objinp = document.getElementById(inputzone);
    var objcol = document.getElementById(colorsquare);
    var colvalue = objinp.value;

    while(colvalue.length<6) { colvalue+='0'; }

    objcol.style.background = '#'+colvalue;
  }

  function change_width(inputzone, widthbar)
  {
    var objinp = document.getElementById(inputzone);
    var objbar = document.getElementById(widthbar);
    objbar.style.width = objinp.value+'px';
  }

  function isAValidIP(ip, strict)
  {
    returnedip=ip;
    re = /^(\d{1,3}){1}(\.\d{1,3}){0,3}$/i;
    if(re.test(ip))
    {
      num = ip.split('.');
      for(i=0;i<num.length;i++)
      {
        if(num[i]>255) return(false);
      }
      if(!strict)
      {
        returnedip+="%";
      }
      for(j=4-i;j>0;j--)
      {
        returnedip+=".%";
      }
      return(returnedip);
    }
    else
    {
      return(false);
    }
  }

  function makeOptionsFromList(list, options)
  {
    if(list=="")
    {
       return(false);
    }

    items=list.split(",");
    for(i=0;i<items.length;i++)
    {
      opt = document.createElement("option");
      opt.value=items[i];
      opt.text=items[i];
      options.appendChild(opt);
    }
  }

  function makeListFromOptions(options)
  {
    list="";
    for(i=0;i<options.length;i++)
    {
      (i!=0)?list+=",":"";
      list+=options[i].value;
    }
    return(list);
  }

  function addIP()
  {
    ip=isAValidIP($("#iaddblackip").val(), true);

    if(ip==false) return(false);

    list = $("#iblacklistedip").val()+",";
    if(list.indexOf(ip+",")==-1)
    {
      opt = document.createElement("option");
      opt.value=ip;
      opt.text=ip;
      $("#iblacklistip")[0].appendChild(opt);
      $("#iblacklistedip").val(makeListFromOptions($("#iblacklistip")[0].options));
    }
    $("#iaddblackip").val("");
    checkButtons();
  }

  function delIP()
  {
    opt = $("#iblacklistip")[0];

    i=0;
    while(i<opt.options.length)
    {
      if(opt.options[i].selected)
      {
        opt.removeChild(opt.options[i]);
      }
      else
      {
        i++;
      }
    }
    $("#iblacklistedip").val(makeListFromOptions(opt.options));
    checkButtons();
  }

  function checkButtons()
  {
    $("#idelipbutton").attr('disabled', !($("#iblacklistip")[0].selectedIndex!=-1));
    $("#iaddipbutton").attr('disabled', (isAValidIP($('#iaddblackip').val(),true)==false) );
  }

  function init()
  {
    makeOptionsFromList($("#iblacklistedip").val(), $("#iblacklistip")[0]);

    $("#iaddblackip").bind("keyup focus", getIPList).bind("blur", hideIPList);
    p = $("#iaddblackip").offset()
    $("#iplist").css({
      left:p.left+1,
      top:p.top+$("#iaddblackip").outerHeight()-1
    });
    $("#iblacklistip").bind("change", checkButtons);
    checkButtons();
  }

  function getIPList()
  {
    /*if($("#iaddblackip").val()=="")
    {
      ip="%";
    }
    else
    {
      ip=isAValidIP($("#iaddblackip").val(),false);
    }
    if(ip==false) return(false);*/
    ip=$("#iaddblackip").val()+"%";

    checkButtons();
    $("html,input").css({cursor:"progress"});
    $.get("{/literal}{$datas.ajaxurl}{literal}", {
        ajaxfct:"astat_listip",
        ipfilter:ip,
        exclude:$("#iblacklistedip").val()
      },
      function (data)
      {
        $("#iplist").html(data).css({visibility:"visible"});
        $("#iipsellist")
          .bind("mouseover", function (event) {
              $("#iaddblackip").unbind("blur");
          } )
          .bind("mouseout", function (event) {
              $("#iaddblackip").bind("blur", hideIPList);
          } )
          .bind("blur", hideIPList)
          .bind("change", function (event) {
            $("#iaddblackip").val($("#iipsellist").val());
            $("#iipsellist").trigger("blur").attr("selectedIndex", -1);
            checkButtons();
            hideIPList();
          } ) ;
        $("html,input").css({cursor:"default"});
        $("input:text").css({cursor:"text"});
      }
    );
  }

  function hideIPList()
  {
    $("#iplist").css({visibility:"hidden"});
  }

</script>
{/literal}

<form method="post" action="" class="general">
  <fieldset >
    <legend>{'AStat_config_colors_and_graph'|@translate}</legend>

    <table class="formtable"  >
      <tr>
        <td>{'AStat_BarColor_Pages'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_BarColor_Pages" value="{$datas.f_AStat_BarColor_Pages}" maxlength=6 id="idz1" onkeyup="change_color('idz1', 'ids1');change_color('idz1', 'ids4')" />
        </td>
        <td>
          <div id="ids1" style="display:block;width:15px;height:15px;border:0px;background-color:#{$datas.f_AStat_BarColor_Pages};"/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_BarColor_Img'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_BarColor_Img" value="{$datas.f_AStat_BarColor_Img}" maxlength=6 id="idz2" onkeyup="change_color('idz2', 'ids2')"/>
        </td>
        <td>
          <div id="ids2" style="display:block;width:15px;height:15px;border:0px;background-color:#{$datas.f_AStat_BarColor_Img}"/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_BarColor_Cat'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_BarColor_Cat" value="{$datas.f_AStat_BarColor_Cat}" maxlength=6 id="idz6" onkeyup="change_color('idz6', 'ids6')"/>
        </td>
        <td>
          <div id="ids6" style="display:block;width:15px;height:15px;border:0px;background-color:#{$datas.f_AStat_BarColor_Cat}"/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_BarColor_IP'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_BarColor_IP" value="{$datas.f_AStat_BarColor_IP}" maxlength=6 id="idz3" onkeyup="change_color('idz3', 'ids3')"/>
        </td>
        <td>
          <div id="ids3" style="display:block;width:15px;height:15px;border:0px;background-color:#{$datas.f_AStat_BarColor_IP}"/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_MouseOverColor'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_MouseOverColor" value="{$datas.f_AStat_MouseOverColor}" maxlength=6 id="idz5" onkeyup="change_color('idz5', 'ids5')"/>
        </td>
        <td>
          <div id="ids5" style="display:block;width:15px;height:15px;border:0px;background-color:#{$datas.f_AStat_MouseOverColor}"/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_MaxBarWidth'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_MaxBarWidth" value="{$datas.f_AStat_MaxBarWidth}" maxlength=4 id="idz4" onkeyup="change_width('idz4', 'ids4')"/>
        </td>
        <td>
          <div id="ids4" style="display:block;width:{$datas.f_AStat_MaxBarWidth}px;height:8px;top:3px;border:0px;background-color:#{$datas.f_AStat_BarColor_Pages}"/>
        </td>
      </tr>
    </table>

  </fieldset>


  <fieldset>
    <legend>{'AStat_specific_period_config'|@translate}</legend>
    <table class="formtable">
      <tr>
        <td>{'AStat_PeriodPerDefault'|@translate}</td>
        <td>
          <select name="f_AStat_default_period">
            {html_options values=$AStat_periods_list_values output=$AStat_periods_list_labels selected=$datas.AStat_periods_selected}
          </select>
        </td>
      </tr>
    </table>
  </fieldset>


  <fieldset>
    <legend>{'AStat_specific_ip_config'|@translate}</legend>
    <table class="formtable">
      <tr>
        <td>{'AStat_NbIPPerPages'|@translate}</td>
        <td colspan="2"><input type="text" name="f_AStat_NpIPPerPages" value="{$datas.f_AStat_NpIPPerPages}" maxlength=4/></td>
      </tr>

      <tr>
        <td>{'AStat_DefaultSortIP'|@translate}</td>
        <td colspan="2">
          <select name="f_AStat_DefaultSortIP">
            {html_options values=$AStat_defaultsortip_list_values output=$AStat_defaultsortip_list_labels selected=$datas.AStat_defaultsortip_selected}
          </select>
        </td>
      </tr>

      <tr>
        <td>{'AStat_BlackListedIP'|@translate}</td>
        <td>
          <input type="text" size="15" id="iaddblackip" style="width:200px;" autocomplete="off"/>
          <input type="hidden" id="iblacklistedip" name="f_AStat_BlackListedIP" value="{$datas.f_AStat_BlackListedIP}"/>
          <div id="iplist"></div>
        </td>
        <td>
          <input type="button" value="{'AStat_AddIP'|@translate}" id="iaddipbutton" onclick="addIP();"/>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
         <select multiple size="4" id="iblacklistip" style="width:200px;height:150px;">
         </select>
        </td>
        <td>
         <input type="button" value="{'AStat_DelIP'|@translate}" id="idelipbutton" onclick="delIP();"/>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">
          <select name="f_AStat_UseBlackList">
            {html_options values=$AStat_enableddisabled_list_values output=$AStat_enableddisabled_list_labels selected=$datas.AStat_UseBlackList_selected}
          </select>
        </td>
      </tr>



    </table>
  </fieldset>

  <fieldset>
    <legend>{'AStat_specific_category_config'|@translate}</legend>
    <table class="formtable">
      <tr>
        <td>{'AStat_NbCatPerPages'|@translate}</td>
        <td><input type="text" name="f_AStat_NpCatPerPages" value="{$datas.f_AStat_NpCatPerPages}" maxlength=4/></td>
      </tr>

      <tr>
        <td>{'AStat_ShowThumbCat'|@translate}</td>
        <td>
          <select name="f_AStat_ShowThumbCat">
            {html_options values=$AStat_yesno_list_values output=$AStat_yesno_list_labels selected=$datas.AStat_showthumbcat_selected}
          </select>
        </td>
      </tr>

      <tr>
        <td>{'AStat_DefaultSortCat'|@translate}</td>
        <td>
          <select name="f_AStat_DefaultSortCat">
            {html_options values=$AStat_defaultsortcat_list_values output=$AStat_defaultsortcat_list_labels selected=$datas.AStat_defaultsortcat_selected}
          </select>
        </td>
      </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend>{'AStat_specific_image_config'|@translate}</legend>
    <table class="formtable">
      <tr>
        <td>{'AStat_NbImgPerPages'|@translate}</td>
        <td>
          <input type="text" name="f_AStat_NbImgPerPages" value="{$datas.f_AStat_NbImgPerPages}" maxlength=4/>
        </td>
      </tr>

      <tr>
        <td>{'AStat_ShowThumbImg'|@translate}</td>
        <td>
          <select name="f_AStat_ShowThumbImg">
            {html_options values=$AStat_yesno_list_values output=$AStat_yesno_list_labels selected=$datas.AStat_showthumbimg_selected}
          </select>
        </td>
      </tr>

      <tr>
        <td>{'AStat_DefaultSortImg'|@translate}</td>
        <td>
          <select name="f_AStat_DefaultSortImg">
            {html_options values=$AStat_defaultsortimg_list_values output=$AStat_defaultsortimg_list_labels selected=$datas.AStat_defaultsortimg_selected}
          </select>
        </td>
      </tr>
    </table>
  </fieldset>

  <p>
    <input type="submit" value="{'AStat_do_save'|@translate}" name="submit"/>
  </p>

</form>

<script type="text/javascript">
  init();
</script>


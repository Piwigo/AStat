<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  AStat_AIM : classe to manage plugin integration into plugin menu

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php');
include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/GPCCss.class.inc.php');

class AStat_AIM extends CommonPlugin
{
  protected $css = null;

  function AStat_AIM($prefixeTable, $filelocation)
  {
    $this->setPluginName("AStat.2");
    $this->setPluginNameFiles("astat");
    parent::__construct($prefixeTable, $filelocation);
    $this->css = new GPCCss(dirname($this->getFileLocation()).'/'.$this->getPluginNameFiles().".css");
  }

  /*
    initialize events call for the plugin
  */
  function initEvents()
  {
    add_event_handler('get_admin_plugin_menu_links', array(&$this, 'pluginAdminMenu') );
  }


  /*
    initialization of config properties
  */
  function initConfig()
  {
    $this->config=array(
      'AStat_BarColor_Pages' => '6666ff',
      'AStat_BarColor_Img' => '66ff66',
      'AStat_BarColor_IP' => 'ff6666',
      'AStat_MouseOverColor' => '303030',
      'AStat_NpIPPerPages' => '25',
      'AStat_NpCatPerPages' => '50',
      'AStat_MaxBarWidth' => '400',
      'AStat_default_period' => 'global', //global, all, year, month, day
      'AStat_ShowThumbCat' => 'true',
      'AStat_DefaultSortCat' => 'page', //page, picture, nbpicture
      'AStat_ShowThumbImg' => 'true',
      'AStat_DefaultSortImg' => 'picture',  //picture, catname
      'AStat_NbImgPerPages' => '100',
      'AStat_BarColor_Cat' => 'fff966',
      'AStat_DefaultSortIP' => 'page',    //page, ip, picture
      'AStat_SeeTimeRequests' => 'false',
      'AStat_BlackListedIP' => '',    // ip blacklisted (separator : ",")
      'AStat_UseBlackList' => 'false'    // if false, blacklist usage is disabled, if "invert" then result are inverted
      );

  }

  /*
    surchage of CommonPlugin->saveConfig function
  */
  function loadConfig()
  {
    parent::loadConfig();
    if(!$this->css->fileExists())
    {
      $this->css->makeCSS($this->generate_CSS());
    }
  }

  /*
    surchage of CommonPlugin->saveConfig function
  */
  function saveConfig()
  {
    if(parent::saveConfig())
    {
      $this->css->makeCSS($this->generate_CSS());
      return(true);
    }
    return(false);
  }

  /*
    generate the css code
  */
  function generate_CSS()
  {
    $text = ".AStatBar1, .AStatBar2, .AStatBar3, .AStatBar4, .AStatBarX {
      border:0px;
      height:8px;
      display: block;
      margin:0px;
      padding:0px;
      left:0;
      position:relative;
      }
       .MiniSquare1, .MiniSquare2, .MiniSquare3, .MiniSquare4 {
      border:0px;
      height:8px;
      width:8px;
      margin:0px;
      padding:0px;
      }
       .AStatBar1 { background-color:#".$this->config['AStat_BarColor_Pages']."; top:5px;  }
       .AStatBar2 { background-color:#".$this->config['AStat_BarColor_Img']."; top:-3px; }
       .AStatBar3 { background-color:#".$this->config['AStat_BarColor_IP']."; top:-3px;}
       .AStatBar4 { background-color:#".$this->config['AStat_BarColor_Cat']."; top:-3px;}
       .AStatBarX { background-color:transparent; top:-3px; height:1px; }
       .MiniSquare1 { color:#".$this->config['AStat_BarColor_Pages'].";   }
       .MiniSquare2 { color:#".$this->config['AStat_BarColor_Img'].";  }
       .MiniSquare3 { color:#".$this->config['AStat_BarColor_IP']."; }
       .MiniSquare4 { color:#".$this->config['AStat_BarColor_Cat']."; }
       .StatTableRow:hover { background-color:#".$this->config['AStat_MouseOverColor']."; }
       .formtable, .formtable P { text-align:left; display:block; }
       .formtable tr { vertical-align:top; }
       .window_thumb {
      position:absolute;
      border: none;
      background: none;
      left:0;
      top:0;
      margin:0px;
      padding:0px;
      z-index:100;
      overflow:hidden;
      visibility:hidden; }
        .img_thumb {
      border: solid 3px #ffffff;
      background: #000000;
      margin:0px;
      padding:0px; }
        .time_request {
      font-size:83%;
      text-align:right; }
        .invisible { visibility:hidden; display:none; }
      .littlefont { font-size:90%; }
      table.littlefont th { padding:3px; }
      table.littlefont td { padding:0px;padding-left:3px;padding-right:3px; }
      #iplist { visibility:hidden; position:absolute; width:200px; z-index:1000; }
      .iipsellistitem { float:right; }
      #iipsellist { width:100%; font-family:monospace; }
    ";

    return($text);
  }

  /* ---------------------------------------------------------------------------
  Function needed for plugin activation
  --------------------------------------------------------------------------- */

  /*
    get 'section' enumeration from HISTORY_TABLE
  */
  function get_section_enum($add)
  {
    $returned=array('', false);
    $sql = 'SHOW COLUMNS FROM '.HISTORY_TABLE.' LIKE "section"';
    $result=pwg_query($sql);
    if($result)
    {
      $row = pwg_db_fetch_assoc($result);
      $list=substr($row['Type'], 5, strlen($row['Type'])-6);
      $returned[0]=explode(',', $list);
      if((strpos($list, "'$add'")===false)&&($add!=''))
      { array_push($returned[0], "'$add'"); }
      else
      { $returned[1]=true; }
      return($returned);
    }
  }

  function alter_history_section_enum($section)
  {
    $sections=$this->get_section_enum('deleted_cat');
    if(!$sections[1])
    {
      $enums=implode(',', $sections[0]);
      $sql="ALTER TABLE ".HISTORY_TABLE."
          CHANGE `section` `section`
          ENUM (".$enums.") ;";
      $result=pwg_query($sql);
      if(!$result)
      {
        return(false);
      }
    }
    return(true);
  }

} // AStat_Plugin class


?>

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

include_once(PHPWG_PLUGINS_PATH.'grum_plugins_classes-2/common_plugin.class.inc.php');
include_once(PHPWG_PLUGINS_PATH.'grum_plugins_classes-2/css.class.inc.php');

class AStat_AIM extends common_plugin
{ 
  protected $css = null;

  function AStat_AIM($prefixeTable, $filelocation)
  {
    $this->plugin_name="AStat.2";
    $this->plugin_name_files="astat";
    parent::__construct($prefixeTable, $filelocation);
    $this->css = new css(dirname($this->filelocation).'/'.$this->plugin_name_files.".css");
  }

  /*
    initialize events call for the plugin
  */
  function init_events()
  {
    add_event_handler('get_admin_plugin_menu_links', array(&$this, 'plugin_admin_menu') );
  }


  /*
    initialization of config properties
  */
  function init_config()
  {
    $this->my_config=array(
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
      'AStat_SeeTimeRequests' => 'false'
      );

  }

  /*
    surchage of common_plugin->save_config function
  */
  function load_config()
  {
    parent::load_config();
    if(!$this->css->css_file_exists())
    {
      $this->css->make_CSS($this->generate_CSS());
    }
  }

  /*
    surchage of common_plugin->save_config function
  */
  function save_config()
  {
    if(parent::save_config())
    {
      $this->css->make_CSS($this->generate_CSS());
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
       .AStatBar1 { background-color:#".$this->my_config['AStat_BarColor_Pages']."; top:5px;  }
       .AStatBar2 { background-color:#".$this->my_config['AStat_BarColor_Img']."; top:-3px; }
       .AStatBar3 { background-color:#".$this->my_config['AStat_BarColor_IP']."; top:-3px;}
       .AStatBar4 { background-color:#".$this->my_config['AStat_BarColor_Cat']."; top:-3px;}
       .AStatBarX { background-color:transparent; top:-3px; height:1px; }
       .MiniSquare1 { color:#".$this->my_config['AStat_BarColor_Pages'].";   }
       .MiniSquare2 { color:#".$this->my_config['AStat_BarColor_Img'].";  }
       .MiniSquare3 { color:#".$this->my_config['AStat_BarColor_IP']."; } 
       .MiniSquare4 { color:#".$this->my_config['AStat_BarColor_Cat']."; } 
       .StatTableRow:hover { background-color:#".$this->my_config['AStat_MouseOverColor']."; }
       .formtable, .formtable P { text-align:left; display:block; } 
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
      $row = mysql_fetch_array($result);
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

<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  AStat_install classe => manage install process

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php');

class AStat_root extends CommonPlugin
{
  public function __construct($prefixeTable, $filelocation)
  {
    global $conf;

    $this->setPluginName("AStat.2");
    $this->setPluginNameFiles("astat");
    parent::__construct($prefixeTable, $filelocation);
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

  public function loadCSS()
  {
    parent::loadCSS();
    GPCCore::addHeaderCSS('astat.css', 'plugins/'.$this->getDirectory().'/'.$this->getPluginNameFiles().".css");
    GPCCore::addHeaderContent('css',
"
.AStatBar1 { background-color:#".$this->config['AStat_BarColor_Pages']."; }
.AStatBar2 { background-color:#".$this->config['AStat_BarColor_Img']."; }
.AStatBar3 { background-color:#".$this->config['AStat_BarColor_IP']."; }
.AStatBar4 { background-color:#".$this->config['AStat_BarColor_Cat']."; }

.MiniSquare1 { color:#".$this->config['AStat_BarColor_Pages'].";   }
.MiniSquare2 { color:#".$this->config['AStat_BarColor_Img'].";  }
.MiniSquare3 { color:#".$this->config['AStat_BarColor_IP']."; }
.MiniSquare4 { color:#".$this->config['AStat_BarColor_Cat']."; }

.StatTableRow:hover { background-color:#".$this->config['AStat_MouseOverColor']."; }
"
    );
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


} // astat_root  class



?>

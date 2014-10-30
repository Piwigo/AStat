<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2014 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['AStat_tools_deleted_picture_nfo1'] = '%s ukjent bilde Id blant hendelse historikk påvirker %s hendelser: <ul>%s</ul>';
$lang['AStat_tools_deleted_picture_nfo3'] = 'Når bilder fysisk overføres fra en katalog, sletter synkroniseringen bilder fra databasen og reinsetter deretter med en ny referanse. Et overført bilde etterlater seg i historikken  hendelser knyttet til referanse som ikke lenger eksisterer </p><p><i>Astat</i>lar:<Ul><li>for å lagre bildereferanser <u><i>før</ i></u>for å synkronisere</li><li>koble historiske hendelser med nøyaktig bilde referanse <u><i>etter</i></u>en synkronisering</ li></p><p><b>Pass på!</b><br><ul><li> skal bildene ha samme filnavn kan ikke utfallet forutsies</li><li>denne funksjonen kan ikke håndtere bilde om hvilken fil navn har blitt endret på serveren</li></ul>';
$lang['AStat_tools_deleted_picture_nfo2'] = 'Alle bilde Id-er i historikken om hendelser finnes, Ingen tiltak skal gjennomføres.';
$lang['AStat_tools_deleted_picture_nfo0'] = 'Påvirker hendelser i historikken som viser til bilder som ikke lenger eksisterer, en <i> bilde [Id # 0] finnes ikke lenger i basen</i>';
$lang['AStat_tools_deleted_picture_error1'] = 'Ny forening av hendelser i historien har sviktet';
$lang['AStat_sortip_ip'] = 'Brukers / IP Adresse';
$lang['AStat_sortip_page'] = 'Antall sider sett';
$lang['AStat_sortip_picture'] = 'Antall bilder sett';
$lang['AStat_specific_category_config'] = 'Spesielle innstillinger for statistikk etter kategorier';
$lang['AStat_specific_image_config'] = 'Spesielle innstillinger for statistikk per bilde';
$lang['AStat_specific_ip_config'] = 'Spesielle innstillinger for statistikk etter IP';
$lang['AStat_specific_period_config'] = 'Spesielle innstillinger for statistikk etter periode';
$lang['AStat_time_request_label'] = 'Forespørsel utført i';
$lang['AStat_title_page'] = 'Avansert statistikk';
$lang['AStat_tools'] = 'Verktøy';
$lang['AStat_tools_deleted_category'] = 'Oppdater kategorier i historikken';
$lang['AStat_tools_deleted_category_apply'] = 'Oppdater';
$lang['AStat_tools_deleted_category_nfo0'] = 'Tildele hendelser i historikken som ikke lenger eksisterer. Slettet kategori';
$lang['AStat_tools_deleted_category_nfo1'] = '%s ikke eksisterende kataloger er oppført blant hendelsene i historikken og innvirknings%s hendelser:<ul>%s</ul>';
$lang['AStat_tools_deleted_category_nfo2'] = 'Alle hendelse kategorier i historikken eksisterer. Ingen tiltak skal foretas.';
$lang['AStat_tools_deleted_picture'] = 'Oppdater historikken for bilde henvisninger';
$lang['AStat_tools_deleted_picture_apply'] = 'Oppdater';
$lang['AStat_tools_deleted_picture_do'] = 'Start prosessen';
$lang['AStat_tools_deleted_picture_do_action'] = '<u>Etter</u> synkronisering: link igjen nytt bilde ID til hendelser i historikken';
$lang['AStat_tools_deleted_picture_error0'] = 'Klargjøringen har sviktet';
$lang['AStat_page_label'] = 'Side';
$lang['AStat_pages_label'] = 'Sider';
$lang['AStat_period_label_all'] = 'Alle år';
$lang['AStat_period_label_days'] = 'Dager';
$lang['AStat_period_label_global'] = 'Globalt';
$lang['AStat_period_label_hours'] = 'Timer';
$lang['AStat_period_label_months'] = 'Måneder';
$lang['AStat_period_label_years'] = 'År';
$lang['AStat_section_additional_page'] = 'Programtillegget <a href="http://phpwebgallery.net/ext/extension_view.php?eid=153">Andre sider</a>';
$lang['AStat_section_deleted_cat'] = 'Kategorien slettet';
$lang['AStat_section_label'] = 'Seksjon';
$lang['AStat_section_most_commented'] = 'Programtillegget <a href="http://phpwebgallery.net/ext/extension_view.php?eid=145">Mest kommentert</a>';
$lang['AStat_section_old_deleted_cat'] = 'Kan ikke bli importert gammelt kategori';
$lang['AStat_section_unknown'] = 'Ukjent [%s]';
$lang['AStat_section_web_services'] = 'Programtillegget <a href="http://phpwebgallery.net/ext/extension_view.php?eid=171">Web services statistikk</a>';
$lang['AStat_sortcat_nbpicture'] = 'Gjennomsnittlig antall visninger per bilde';
$lang['AStat_sortcat_page'] = 'Representasjon i prosent av sette sider';
$lang['AStat_sortcat_picture'] = 'Representasjon i prosent av sette bilder';
$lang['AStat_sortimg_catname'] = 'Alfabetisk rekkefølge - Kategori / bildets navn';
$lang['AStat_sortimg_picture'] = 'Bildets antall visninger';
$lang['AStat_event'] = 'Hendelse';
$lang['AStat_events'] = 'Hendelser';
$lang['AStat_general_config'] = 'Globale innstillinger';
$lang['AStat_gpc2_not_installed'] = 'Programtillegget  \'Grum Plugins Classes 2\' (release >= %s)trengs for å instalere ASat';
$lang['AStat_month_of_year_1'] = 'Januar';
$lang['AStat_month_of_year_10'] = 'Oktober';
$lang['AStat_month_of_year_11'] = 'November';
$lang['AStat_month_of_year_12'] = 'Desember';
$lang['AStat_month_of_year_2'] = 'Februar';
$lang['AStat_month_of_year_3'] = 'Mars';
$lang['AStat_month_of_year_4'] = 'April';
$lang['AStat_month_of_year_5'] = 'Mai';
$lang['AStat_month_of_year_6'] = 'Juni';
$lang['AStat_month_of_year_7'] = 'Juli';
$lang['AStat_month_of_year_8'] = 'August';
$lang['AStat_month_of_year_9'] = 'September';
$lang['AStat_nb_total_category'] = 'Tatalt antall kategorier';
$lang['AStat_nb_total_image'] = 'Totalt antall bilder';
$lang['AStat_nb_total_ip'] = 'Totalt antall IP adresser';
$lang['AStat_nofilter'] = '--Ingen filter--';
$lang['AStat_catfilter_list'] = 'Bruk filter på kategorier';
$lang['AStat_config'] = 'Innstillinger';
$lang['AStat_config_colors_and_graph'] = 'Farge & grafiske innstillinger';
$lang['AStat_config_saved'] = 'Innstillingene er lagret!';
$lang['AStat_config_title'] = 'AStat innstillinger';
$lang['AStat_confignotsaved'] = 'En feil har oppstått, innstillingene ble ikke lagret';
$lang['AStat_date_time_format'] = 'Y/d/m H:i:s';
$lang['AStat_day_of_week_0'] = 'Søndag';
$lang['AStat_day_of_week_1'] = 'Mandag';
$lang['AStat_day_of_week_2'] = 'Tirsdag';
$lang['AStat_day_of_week_3'] = 'Onsdag';
$lang['AStat_day_of_week_4'] = 'Torsdag';
$lang['AStat_day_of_week_5'] = 'Fredag';
$lang['AStat_day_of_week_6'] = 'Lørdag';
$lang['AStat_deleted_picture'] = 'Bilde eksisterer ikke lenger';
$lang['AStat_deleted_user'] = 'Slett bruker';
$lang['AStat_do_save'] = 'Lagre';
$lang['AStat_enableddisabled_false'] = 'Filter deaktivert';
$lang['AStat_enableddisabled_invert'] = 'Filter invertert';
$lang['AStat_enableddisabled_true'] = 'Filter aktivert';
$lang['AStat_Nfo_Period'] = 'For den valgte perioden, representerer antall sider og bilder sett, som antall synlige IP adresser tilkoblet';
$lang['AStat_PeriodPerDefault'] = 'Standard valgt periode';
$lang['AStat_PeriodPerDefault_all'] = 'Alle år';
$lang['AStat_PeriodPerDefault_day'] = 'Den aktuelle dagen';
$lang['AStat_PeriodPerDefault_global'] = 'Globalt';
$lang['AStat_PeriodPerDefault_month'] = 'Den aktuelle måneden';
$lang['AStat_PeriodPerDefault_year'] = 'Det aktuelle året';
$lang['AStat_RefIPLabel'] = 'Brukers / IP Adresse';
$lang['AStat_RefImageLabel'] = 'Kategori / Bildets navn';
$lang['AStat_SeeTimeRequests'] = 'Vis tid for gjennomføring av forespørsler';
$lang['AStat_ShowThumbCat'] = 'Vis kategoriens representative miniatyrbilde';
$lang['AStat_ShowThumbImg'] = 'Vis bildets miniatyrbilde';
$lang['AStat_SortCatLabel'] = 'Sortert etter';
$lang['AStat_SortIPLabel'] = 'Sortert etter';
$lang['AStat_SortImgLabel'] = 'Sortert etter';
$lang['AStat_adviser_not_authorized'] = 'Handling avbrutt: anbefaler, ikke tillat denne typen tiltak';
$lang['AStat_by_category'] = 'Etter kategori';
$lang['AStat_by_image'] = 'Per bilde';
$lang['AStat_by_ip'] = 'Etter IP';
$lang['AStat_by_period'] = 'Etter periode';
$lang['AStat_AddIP'] = 'Legg til svartelista';
$lang['AStat_BarColor_Cat'] = 'Antall kategorier';
$lang['AStat_BarColor_IP'] = 'Antall IP adresser';
$lang['AStat_BarColor_Img'] = 'Antall bilder';
$lang['AStat_BarColor_Pages'] = 'Antall sider';
$lang['AStat_BlackListedIP'] = 'Svartelistet IP adresser';
$lang['AStat_DefaultSortCat'] = 'standard sortering';
$lang['AStat_DefaultSortIP'] = 'standard sortering';
$lang['AStat_DefaultSortImg'] = 'standard sortering';
$lang['AStat_DelIP'] = 'Slett fra svartelista';
$lang['AStat_IP_blacklist'] = 'Legg til svartelista';
$lang['AStat_IP_geolocalisation'] = 'Geolokalisering';
$lang['AStat_MaxBarWidth'] = 'Maksimal stolpe bredde (piksler)';
$lang['AStat_MouseOverColor'] = 'Mus over rad';
$lang['AStat_NbCatPerPages'] = 'Antall kategorier per side';
$lang['AStat_NbIPPerPages'] = 'Antall IP per side';
$lang['AStat_NbImgPerPages'] = 'Antall bilder per side';
$lang['AStat_Nfo_Category'] = 'For den valgte perioden, antall sider i prosent og bilder sett etter kategorier, som gjennomsnittlig antall visninger per bilde';
$lang['AStat_Nfo_IP'] = 'For den valgte perioden, representerer antall sider og bilder sett av en IP-adresse';
$lang['AStat_Nfo_Image'] = 'For den valgte perioden, antall visninger for hver bilde, som representasjon i prosent av antall visninger på det totale antall visninger';
$lang['AStat_tools_result_ko'] = 'Det har oppstått en feil. Handlingen er ikke korrekt utført';
$lang['AStat_tools_result_ok'] = 'Handling korrekt utført';
$lang['AStat_tools_title'] = 'Vedlikeholds verktøy';
$lang['AStat_version'] = 'versjon';
$lang['AStat_yesno_false'] = 'NEI';
$lang['AStat_yesno_true'] = 'JA';
$lang['CATEGORY_LABEL'] = 'Kategori';
$lang['Categories_seen'] = 'Kategori sett';
$lang['IP_label'] = 'IP adresse';
$lang['IP_visit'] = 'IP adresser';
$lang['Pictures_seen'] = 'Bilder sett';
$lang['pct_Pages_seen'] = '%Sider';
$lang['pct_Pictures_seen'] = '%Bilder';
$lang['ratio_Pictures_seen'] = 'Bilder sett';
$lang['AStat_tools_general_nfo'] = 'Generell informasjon om historikken';
$lang['AStat_tools_general_nfo_nfo'] = '<ul><li>%s hendelser er tilgjengelig i historikken</li>
            <li>Tabell vekter %s (Tabell: %s ; Liste: %s)</li>
            <li>Dato for første hendelse : %s</li>
            <li>Dato for siste hendelse : %s</li>';
$lang['AStat_tools_invalid_date'] = 'Oppgitt dato er ikke gyldig!';
$lang['AStat_tools_invalid_date2'] = 'Oppgitt dato er senere eller samme som dagens dato';
$lang['AStat_tools_purge_history'] = 'Opprydding av historikken';
$lang['AStat_tools_purge_history_apply'] = 'Rydde opp';
$lang['AStat_tools_purge_history_categoryid0'] = 'Å rense hendelser assosiert til slettede kategorier (%s hendelser i historikken)';
$lang['AStat_tools_purge_history_date'] = 'Å rense alle hendelser før ';
$lang['AStat_tools_purge_history_imageid0'] = 'Å rense alle hendelser knyttet til slettede bilder (%s hendelser i historikken)';
$lang['AStat_tools_purge_history_ipid0'] = 'Å rense hendelser assosiert med IP fra svartelisten (%s elementer i svartelisten,%s hendelser i historikken)';
$lang['AStat_tools_purge_history_nfo'] = 'Denne funksjonen vil rense historikken fra alle tidligere hendelse fra en gitt dato, og vil optimalisere listene.<br><b> Operasjonen kan ikke reverseres</b>.';
$lang['AStat_tools_deleted_user_nfo2'] = 'Alle bruker ID i historikken av hendelser finnes, ingen tiltak skal gjennomføres.';
$lang['AStat_tools_deleted_picture_nfo_nb'] = '(%s bilde Id kan ikke knyttes til %s hendelser i historikken)';
$lang['AStat_tools_deleted_picture_ok0'] = 'Klargjøringen av tabellen lyktes, filene kan bli omorganisert på serveren';
$lang['AStat_tools_deleted_picture_ok1'] = 'Sammenslå hendelse i historikken har lykkes';
$lang['AStat_tools_deleted_picture_prepare_action'] = '<u>Tidligere</u>  til synkronisering: forberede <i>AStat</i>';
$lang['AStat_tools_deleted_user'] = 'Oppdater historikken med brukerens referanser';
$lang['AStat_tools_deleted_user_nfo0'] = 'Denne funksjonen tvinger på en <i>gjest</i> en bruker-ID som genereres som en hendelse i historikken dens konto som  tidligere har vært slettet.';
$lang['AStat_tools_deleted_user_apply'] = 'Oppdater';
$lang['AStat_tools_deleted_user_nfo1'] = '%s  ukjent bruker-ID blant historiehendelser påvirker %s hendelser : <ul>%s</ul>';
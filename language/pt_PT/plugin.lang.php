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
$lang['AStat_tools_deleted_picture'] = 'Atualizar o historial com imagem referência';
$lang['AStat_tools_deleted_picture_apply'] = 'Atualizar';
$lang['AStat_tools_deleted_picture_error1'] = 'Nova associação de eventos ao historial falhou';
$lang['AStat_tools_deleted_user_nfo1'] = '%s ID de utilizadores desconhecidos entre os eventos do historial com impacto em %s eventos: <ul>%s</ul>';
$lang['AStat_tools_purge_history_nfo'] = 'Esta função irá limpar o histórico de todos os eventos decorridos a partir ​​de uma determinada data e irá otimizará a tabela. <br> <b> A operação não pode ser revertida </b>.';
$lang['AStat_tools_deleted_picture_ok0'] = 'Priming da tabela sucesso, os arquivos podem ser reorganizados no servidor';
$lang['AStat_tools_deleted_picture_ok1'] = 'Ligação do evento no historial foi bem sucedida';
$lang['AStat_tools_deleted_picture_prepare_action'] = '<u>Antes</u> para sincronizar: preparar <i>AStat</i>';
$lang['AStat_tools_deleted_user'] = 'Atualizar historial com as preferências dos utilizadores';
$lang['AStat_tools_deleted_user_nfo0'] = 'Esta função força a <i>visitante </i> um ID de utilizador gerado como evento no historial  cuja conta foi entretanto excluída.';
$lang['AStat_tools_deleted_user_nfo2'] = 'Todos os ID de utilizadores existentes no historial de eventos, nNão deverão executar qualquer ação.';
$lang['AStat_tools_result_ko'] = 'Ocorreu um erro. A ação não foi executada corretamente';
$lang['AStat_tools_title'] = 'Ferramentas de manutenção';
$lang['Categories_seen'] = 'Categorias vistas';
$lang['IP_label'] = 'IP';
$lang['IP_visit'] = 'IP\'s';
$lang['Pictures_seen'] = 'Fotos visualizadas';
$lang['pct_Pages_seen'] = '%Páginas';
$lang['pct_Pictures_seen'] = '%Fotos';
$lang['ratio_Pictures_seen'] = 'Fotos visualizadas';
$lang['AStat_tools_general_nfo'] = 'Informação geral no historial';
$lang['AStat_tools_general_nfo_nfo'] = '<ul><li>%s eventos estão presentes no historial</li>
            <li>Tabela de pesos %s (Tabela: %s ; Index: %s)</li>
            <li>Data do primeiro evento : %s</li>
            <li>Data do último evento : %s</li>';
$lang['AStat_tools_invalid_date2'] = 'Data atribuída é maior ou igual à data do dia';
$lang['AStat_tools_purge_history_categoryid0'] = 'Para purgar eventos associados a categorias apagadas (%s eventos no historial)';
$lang['AStat_tools_purge_history_imageid0'] = 'Para purgar todos os eventos associados a imagens apagadas (%s eventos no historial)';
$lang['AStat_tools_purge_history_ipid0'] = 'Para purgar eventos associados a IP da lista negra(%s artigos na lista negra, %s eventos no historial)';
$lang['AStat_version'] = 'versão';
$lang['AStat_yesno_false'] = 'Não';
$lang['AStat_yesno_true'] = 'Sim';
$lang['CATEGORY_LABEL'] = 'Categoria';
$lang['AStat_tools_invalid_date'] = 'Data atribuída não é válida';
$lang['AStat_tools_purge_history'] = 'Apagar o historial';
$lang['AStat_tools_purge_history_apply'] = 'Limpar';
$lang['AStat_tools_purge_history_date'] = 'Para limpar todos os eventos anteriores';
$lang['AStat_tools_result_ok'] = 'Ação corretamente executada';
$lang['AStat_tools_deleted_user_apply'] = 'Atualizar';
$lang['AStat_Nfo_Period'] = 'Para o período escolhido, representam o número de páginas e imagens vistas, como o número de diferentes IP\'s ligados';
$lang['AStat_adviser_not_authorized'] = 'Ação abortada: Alerta do perfil não permite este tipo de ação';
$lang['AStat_specific_period_config'] = 'Definições específicas para estatisticas por períodos';
$lang['AStat_time_request_label'] = 'Pedido executado em';
$lang['AStat_title_page'] = 'Definições avançadas';
$lang['AStat_tools'] = 'Ferramentas';
$lang['AStat_tools_deleted_category'] = 'Atualizar categorias no historial';
$lang['AStat_tools_deleted_category_apply'] = 'Atualizar';
$lang['AStat_tools_deleted_category_nfo0'] = 'No historial não existem assinaturas para eventos. Categoria apagada';
$lang['AStat_tools_deleted_category_nfo1'] = '%s diretórios inexistentes estão listados entre os eventos do historial com impacto em %s eventos : <ul>%s</ul>';
$lang['AStat_tools_deleted_category_nfo2'] = 'Todos as categorias de  eventos existem no historial';
$lang['AStat_config_title'] = 'Configurações AStat';
$lang['AStat_gpc2_not_installed'] = 'Extensão \'Grum Plugins Classes 2\' (release >= %s) necessária para instalar AStat';
$lang['AStat_section_additional_page'] = 'Extensão <a href="http://phpwebgallery.net/ext/extension_view.php?eid=153">Páginas adicionais</a>';
$lang['AStat_section_most_commented'] = 'Extensão <a href="http://phpwebgallery.net/ext/extension_view.php?eid=145">Mais comentadas</a>';
$lang['AStat_section_web_services'] = 'Extensão <a href="http://phpwebgallery.net/ext/extension_view.php?eid=171">Estatisticas de serviços web</a>';
$lang['AStat_sortip_picture'] = 'Número de fotos vistas';
$lang['AStat_specific_category_config'] = 'Definições específicas para estatisticas por categorias';
$lang['AStat_specific_image_config'] = 'Definições específicas para estatisticas por fotos';
$lang['AStat_specific_ip_config'] = 'Definições específicas para estatisticas por IP';
$lang['AStat_sortimg_catname'] = 'Ordem alfabética - Categoria / Nome das fotos';
$lang['AStat_sortimg_picture'] = 'Número de visualizações de fotos';
$lang['AStat_sortip_ip'] = 'Utilizador / IP';
$lang['AStat_sortip_page'] = 'Número de páginas vistas';
$lang['AStat_ShowThumbCat'] = 'Mostrar as miniaturas representativas das categorias';
$lang['AStat_nofilter'] = '--- Sem filtro ---';
$lang['AStat_sortcat_page'] = 'Representação em percentagem de páginas vistas';
$lang['AStat_sortcat_picture'] = 'Representação em percentagem de fotos vistas';
$lang['AStat_section_unknown'] = 'Desconhecido [%s]';
$lang['AStat_sortcat_nbpicture'] = 'Número média de visualizações por foto.';
$lang['AStat_catfilter_list'] = 'Aplicar filtro nas categorias';
$lang['AStat_section_label'] = 'Secção';
$lang['AStat_section_old_deleted_cat'] = 'Não é possivel importar a categoria antiga';
$lang['AStat_page_label'] = 'Página';
$lang['AStat_pages_label'] = 'Páginas';
$lang['AStat_period_label_all'] = 'Todo o ano';
$lang['AStat_period_label_days'] = 'Dias';
$lang['AStat_period_label_global'] = 'Global';
$lang['AStat_period_label_hours'] = 'Horas';
$lang['AStat_period_label_months'] = 'Meses';
$lang['AStat_period_label_years'] = 'Anos';
$lang['AStat_section_deleted_cat'] = 'Categoria apagada';
$lang['AStat_enableddisabled_false'] = 'Filtro desativado';
$lang['AStat_enableddisabled_invert'] = 'Filtro invertido';
$lang['AStat_enableddisabled_true'] = 'Filtro ativado';
$lang['AStat_month_of_year_2'] = 'Fevereiro';
$lang['AStat_month_of_year_3'] = 'Março';
$lang['AStat_month_of_year_4'] = 'Abril';
$lang['AStat_month_of_year_5'] = 'Maio';
$lang['AStat_month_of_year_6'] = 'Junho';
$lang['AStat_month_of_year_7'] = 'Julho';
$lang['AStat_month_of_year_8'] = 'Agosto';
$lang['AStat_month_of_year_9'] = 'Setembro';
$lang['AStat_nb_total_category'] = 'Número total de categorias';
$lang['AStat_nb_total_image'] = 'Número total de fotos';
$lang['AStat_nb_total_ip'] = 'Número total de IP\'s';
$lang['AStat_SeeTimeRequests'] = 'Mostrar tempo de execução dos pedidos';
$lang['AStat_ShowThumbImg'] = 'Mostrar miniaturas das fotos';
$lang['AStat_deleted_user'] = 'Apagar utilizador';
$lang['AStat_do_save'] = 'Salvar';
$lang['AStat_event'] = 'evento';
$lang['AStat_events'] = 'eventos';
$lang['AStat_general_config'] = 'Configurações globais';
$lang['AStat_month_of_year_1'] = 'Janeiro';
$lang['AStat_month_of_year_10'] = 'Outubro';
$lang['AStat_month_of_year_11'] = 'Novembro';
$lang['AStat_month_of_year_12'] = 'Dezembro';
$lang['AStat_config'] = 'Configurações';
$lang['AStat_config_colors_and_graph'] = 'Configurações cor & gráficas ';
$lang['AStat_config_saved'] = 'Configurações salvas';
$lang['AStat_confignotsaved'] = 'Ocorreu um erro, as definições não foram salvas';
$lang['AStat_date_time_format'] = 'Y/dd/m H:i:s';
$lang['AStat_day_of_week_0'] = 'Domingo';
$lang['AStat_day_of_week_1'] = 'Segunda feira';
$lang['AStat_day_of_week_2'] = 'Terça feira';
$lang['AStat_day_of_week_3'] = 'Quarta feira';
$lang['AStat_day_of_week_4'] = 'Quinta feira';
$lang['AStat_day_of_week_5'] = 'Sexta feira';
$lang['AStat_day_of_week_6'] = 'Sábado';
$lang['AStat_deleted_picture'] = 'A fot já não existe';
$lang['AStat_PeriodPerDefault'] = 'Período escolhido por defeito';
$lang['AStat_PeriodPerDefault_all'] = 'Todos os anos';
$lang['AStat_PeriodPerDefault_day'] = 'Dia atual';
$lang['AStat_PeriodPerDefault_global'] = 'Global';
$lang['AStat_PeriodPerDefault_month'] = 'Mês atual';
$lang['AStat_PeriodPerDefault_year'] = 'Ano atual';
$lang['AStat_RefIPLabel'] = 'Utilizador / IP';
$lang['AStat_RefImageLabel'] = 'Categoria / Número da foto';
$lang['AStat_SortCatLabel'] = 'Ordenar por';
$lang['AStat_SortIPLabel'] = 'Ordenar por';
$lang['AStat_SortImgLabel'] = 'Ordenar por';
$lang['AStat_by_category'] = 'Por categoria';
$lang['AStat_by_image'] = 'Por fotos';
$lang['AStat_by_ip'] = 'Por IP';
$lang['AStat_by_period'] = 'Por período';
$lang['AStat_AddIP'] = 'Adicionar à lista negra';
$lang['AStat_BarColor_Cat'] = 'Número de categorias';
$lang['AStat_BarColor_IP'] = 'Número de IP\'s';
$lang['AStat_BarColor_Img'] = 'Número de fotos';
$lang['AStat_BarColor_Pages'] = 'Número de páginas';
$lang['AStat_BlackListedIP'] = 'IP\'s na lista negra';
$lang['AStat_DefaultSortCat'] = 'Exibição por defeito';
$lang['AStat_DefaultSortIP'] = 'Exibição por defeito';
$lang['AStat_DefaultSortImg'] = 'Exibição por defeito';
$lang['AStat_DelIP'] = 'Apagar da Lista negra';
$lang['AStat_IP_blacklist'] = 'Adicionar à lista negra';
$lang['AStat_IP_geolocalisation'] = 'Geolocalização';
$lang['AStat_MaxBarWidth'] = 'Largura máxima da barra (pixels)';
$lang['AStat_MouseOverColor'] = 'Rato sobre a linha';
$lang['AStat_NbCatPerPages'] = 'Número de categorias por página';
$lang['AStat_NbIPPerPages'] = 'Número de IP por página';
$lang['AStat_NbImgPerPages'] = 'Número de fotos por página';
$lang['AStat_Nfo_Category'] = 'Percentagem do número de páginas e fotos vistas por categorias, por estimativa do núemro de visualizações por foto.';
$lang['AStat_Nfo_IP'] = 'Número de páginas e fotos visualizadas por IP no período escolhido';
$lang['AStat_Nfo_Image'] = 'Número de visualizações por cada foto, para o período escolhido, representado em percentagem do número de visualizações da foto no total geral de visualizações.';
$lang['AStat_tools_deleted_picture_do'] = 'Fazer o processo';
$lang['AStat_tools_deleted_picture_do_action'] = '<u>Depois</u>da sincronização: ligar novo ID de imagem ao historial';
$lang['AStat_tools_deleted_picture_error0'] = 'Priming falhou';
$lang['AStat_tools_deleted_picture_nfo0'] = 'Impactos de eventos no historial referem-se a imagens inexistentes, uma <i>imagem[Id#0]não existe mais na base</i>';
$lang['AStat_tools_deleted_picture_nfo1'] = '%s id de imagem desconhecido no historial de evento com impacto em %s eventos: <ul>%s</ul>
';
$lang['AStat_tools_deleted_picture_nfo2'] = 'Todas as imagens existem no historial do evento, Não deve ser tomada qualquer ação. ';
$lang['AStat_tools_deleted_picture_nfo_nb'] = '(%s imagem lds não pode ser ligada a %s eventos no historial)';
$lang['AStat_tools_deleted_picture_nfo3'] = 'Quando as imagens são fisicamente transferidos de um diretório, a sincronização apaga-as da base e reinsere-as depois com uma nova referência. A imagem transferida, contudo, permanece no historial dos eventos ligada à referência que não existe mais </p<p>><i> Astat </i> permite:<ul><li> Memorizar referências da imagem<u></i>antes </i></u> para sincronizar </li><li>o historial de eventos com a referência da imagem exata,  <u><i> depois, </i></u> a sincronização </li></p><p><b> Lembre-se! </b><br><ul><li> Se as fotos tiverem o mesmo nome de arquivo, o resultado não pode ser previsto </li><li> esta função não pode lidar com a imagem cujo nome de arquivo foi alterado no servidor </li></ul>';
$lang['AStat_section_best_rated'] = ' ';
$lang['AStat_section_categories'] = ' ';
$lang['AStat_section_favorites'] = ' ';
$lang['AStat_section_list'] = ' ';
$lang['AStat_section_most_visited'] = ' ';
$lang['AStat_section_recent_cats'] = ' ';
$lang['AStat_section_recent_pics'] = ' ';
$lang['AStat_section_search'] = ' ';
$lang['AStat_section_tags'] = ' ';
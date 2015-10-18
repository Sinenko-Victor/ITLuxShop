<?php 

//
// (C) mkp, 2007
// Author: Mastushkin Kirill. Tomsk.
// E-mail: mkp@inbox.ru, mkp@tpce.tomsk.ru
// ICQ: 169035175
//

  define('IN_APPLICATION', true);

  require('./app.config.php');
  require('./common.php');
  require('./xtree.lib.php');

  $tree = new xtree("<b>Example</b>", 'example');
  $tree->SetImagePath('./images');

  // ImageList
  $tree->AddNodeImage('root', 'home.gif');
  $tree->AddNodeImage('city2');
  $tree->AddNodeImage('user');
  $tree->AddNodeImage('admin');
  $tree->AddNodeImage('usergroup');
  $tree->AddNodeImage('links');
  $tree->AddNodeImage('news', 'news4.gif');
  $tree->AddNodeImage('chat');
  $tree->AddNodeImage('blog');
  $tree->AddNodeImage('vote', 'userquestion.gif');
  $tree->AddNodeImage('goroscop', 'zodiak.gif');
  $tree->AddNodeImage('currency');
  $tree->AddNodeImage('palm');
  $tree->AddNodeImage('s09');
  $tree->AddNodeImage('folder3');
  $tree->AddNodeImage('folder5');
  $tree->AddNodeImage('gamesl');
  $tree->AddNodeImage('piechart');
  $tree->AddNodeImage('barchart');
  $tree->AddNodeImage('settings', 'foldersettings.gif');
  $tree->AddNodeImage('shield2');
  $tree->AddNodeImage('userqueue');
  $tree->AddNodeImage('diagnostics');
  $tree->AddNodeImage('tree');
  $tree->AddNodeImage('blocks');
  $tree->AddNodeImage('class');
  $tree->AddNodeImage('databases');
  $tree->AddNodeImage('database');
  $tree->AddNodeImage('database-linux');
  
  // NodeList
  $tree->AddNode('', '_navigation', 'Навигация', 'city2', cookievalue('tree_example_navigation', 'open'));
  $tree->AddNode('_navigation', '_nav_01', 'Ссылки', 'links');
  $tree->AddNode('_navigation', '_nav_02', 'Новости', 'news');
  $tree->AddNode('_navigation', '_nav_03', 'Чат', 'chat');
  $tree->AddNode('_navigation', '_nav_04', 'Блоги', 'blog');
  $tree->AddNode('_navigation', '_nav_05', 'Гороскоп', 'goroscop');
  $tree->AddNode('_navigation', '_nav_06', 'Опросы', 'vote');
  $tree->AddNode('_navigation', '_nav_07', 'Игры', 'gamesl');
  $tree->AddNode('_navigation', '_nav_08', 'Курсы валют', 'currency');
  $tree->AddNode('_navigation', '_nav_09', 'Отдых', 'palm');
  $tree->AddNode('_navigation', '_nav_10', 'Телефонный справочник', 's09');

  $tree->AddNode('', '_reports', 'Статистика', 'piechart', cookievalue('tree_example_reports', 'open'));
  $tree->AddNode('_reports', '_r1', 'Хосты', 'barchart');
  $tree->AddNode('_reports', '_r2', 'Пользователи', 'barchart');
  $tree->AddNode('_reports', '_r3', 'IP адреса', 'barchart');
  $tree->AddNode('_reports', '_r4', 'Сводный отчёт', 'barchart');

  $tree->AddNode('', '_users', 'Пользователи', 'usergroup', cookievalue('tree_example_users', 'open'));
  $tree->AddNode('_users', '_user_01', 'Иванов Пётр Сидорович', 'user');
  $tree->AddNode('_users', '_user_02', 'Петров Сидор Иванович', 'user');
  $tree->AddNode('_users', '_user_03', 'Сидоров Иван Петрович', 'user');
  $tree->AddNode('_users', '_user_04', 'Мастушкин Кирилл Петрович (admin)', 'admin');

  $tree->AddNode('_users', '_user_groups', 'Группы', 'usergroup', cookievalue('tree_example_user_groups', 'open'));
  $tree->AddNode('_user_groups', '_user_groups_01', 'Пользователи', 'usergroup');
  $tree->AddNode('_user_groups', '_user_groups_02', 'Продвинутые', 'usergroup');
  $tree->AddNode('_user_groups', '_user_groups_03', 'Администраторы', 'usergroup');

  $tree->AddNode('', '_long_branch_01', 'Длинная ветка', 'folder3', cookievalue('tree_example_long_branch_01', 'open'));
  $tree->AddNode('_long_branch_01', '_long_branch_02', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_02', 'open'));
  $tree->AddNode('_long_branch_02', '_long_branch_03', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_03', 'open'));
  $tree->AddNode('_long_branch_03', '_long_branch_04', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_04', 'open'));
  $tree->AddNode('_long_branch_04', '_long_branch_05', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_05', 'open'));
  $tree->AddNode('_long_branch_05', '_long_branch_06', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_06', 'open'));
  $tree->AddNode('_long_branch_06', '_long_branch_07', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_07', 'open'));
  $tree->AddNode('_long_branch_07', '_long_branch_08', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_08', 'open'));
  $tree->AddNode('_long_branch_08', '_long_branch_09', 'Длинная ветка', 'folder5', cookievalue('tree_example_long_branch_09', 'open'));
  $tree->AddNode('_long_branch_09', '_long_branch_10', 'Нода', '');

  $tree->AddNode('', '_without_images', 'Ноды без иконок', 'folder3', cookievalue('tree_example_without_images', 'open'));
  $tree->AddNode('_without_images', '_wi_01', 'Нода 1', '');
  $tree->AddNode('_without_images', '_wi_02', 'Нода 2', '');
  $tree->AddNode('_without_images', '_wi_03', 'Нода 3', '');
  $tree->AddNode('_without_images', '_wi_04', 'Нода 4', '');

  $tree->AddNode('', '_settings', 'Настройки', 'settings', cookievalue('tree_example_settings', 'open'));
  $tree->AddNode('_settings', '_settings_01', 'Безопасность', 'shield2');
  $tree->AddNode('_settings', '_settings_02', 'Блоки', 'blocks');
  $tree->AddNode('_settings', '_settings_03', 'Модули', 'class');
  $tree->AddNode('_settings', '_settings_04', 'База данных', 'database');
  $tree->AddNode('_settings', '_settings_05', 'Сессии пользователей', 'userqueue');
  $tree->AddNode('_settings', '_settings_06', 'Диагностика', 'diagnostics');
  $tree->AddNode('_settings', '_settings_07', 'Меню', 'tree');

  print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
  print "<base target=\"_self\">\n";
  print "<html>\n";
  print "  <head>\n";
  print "    <title>xTree</title>\n";
  print "    <meta http-equiv=content-type content=\"text/html; charset=windows-1251\" />\n";
  print "    <script language=JavaScript src=\"./common.js\" type=text/javascript></script>\n";
  print "    <link type=\"text/css\" href=\"./style.css\" rel=\"stylesheet\" />\n";
  print "  </head>\n";
  print "<body>\n";

  // ShowTree
  $tree->show();

  print "</body>\n";
  print "</html>\n";

?>
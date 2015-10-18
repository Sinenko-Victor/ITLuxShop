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
  $tree->AddNode('', '_navigation', '���������', 'city2', cookievalue('tree_example_navigation', 'open'));
  $tree->AddNode('_navigation', '_nav_01', '������', 'links');
  $tree->AddNode('_navigation', '_nav_02', '�������', 'news');
  $tree->AddNode('_navigation', '_nav_03', '���', 'chat');
  $tree->AddNode('_navigation', '_nav_04', '�����', 'blog');
  $tree->AddNode('_navigation', '_nav_05', '��������', 'goroscop');
  $tree->AddNode('_navigation', '_nav_06', '������', 'vote');
  $tree->AddNode('_navigation', '_nav_07', '����', 'gamesl');
  $tree->AddNode('_navigation', '_nav_08', '����� �����', 'currency');
  $tree->AddNode('_navigation', '_nav_09', '�����', 'palm');
  $tree->AddNode('_navigation', '_nav_10', '���������� ����������', 's09');

  $tree->AddNode('', '_reports', '����������', 'piechart', cookievalue('tree_example_reports', 'open'));
  $tree->AddNode('_reports', '_r1', '�����', 'barchart');
  $tree->AddNode('_reports', '_r2', '������������', 'barchart');
  $tree->AddNode('_reports', '_r3', 'IP ������', 'barchart');
  $tree->AddNode('_reports', '_r4', '������� �����', 'barchart');

  $tree->AddNode('', '_users', '������������', 'usergroup', cookievalue('tree_example_users', 'open'));
  $tree->AddNode('_users', '_user_01', '������ ϸ�� ���������', 'user');
  $tree->AddNode('_users', '_user_02', '������ ����� ��������', 'user');
  $tree->AddNode('_users', '_user_03', '������� ���� ��������', 'user');
  $tree->AddNode('_users', '_user_04', '��������� ������ �������� (admin)', 'admin');

  $tree->AddNode('_users', '_user_groups', '������', 'usergroup', cookievalue('tree_example_user_groups', 'open'));
  $tree->AddNode('_user_groups', '_user_groups_01', '������������', 'usergroup');
  $tree->AddNode('_user_groups', '_user_groups_02', '�����������', 'usergroup');
  $tree->AddNode('_user_groups', '_user_groups_03', '��������������', 'usergroup');

  $tree->AddNode('', '_long_branch_01', '������� �����', 'folder3', cookievalue('tree_example_long_branch_01', 'open'));
  $tree->AddNode('_long_branch_01', '_long_branch_02', '������� �����', 'folder5', cookievalue('tree_example_long_branch_02', 'open'));
  $tree->AddNode('_long_branch_02', '_long_branch_03', '������� �����', 'folder5', cookievalue('tree_example_long_branch_03', 'open'));
  $tree->AddNode('_long_branch_03', '_long_branch_04', '������� �����', 'folder5', cookievalue('tree_example_long_branch_04', 'open'));
  $tree->AddNode('_long_branch_04', '_long_branch_05', '������� �����', 'folder5', cookievalue('tree_example_long_branch_05', 'open'));
  $tree->AddNode('_long_branch_05', '_long_branch_06', '������� �����', 'folder5', cookievalue('tree_example_long_branch_06', 'open'));
  $tree->AddNode('_long_branch_06', '_long_branch_07', '������� �����', 'folder5', cookievalue('tree_example_long_branch_07', 'open'));
  $tree->AddNode('_long_branch_07', '_long_branch_08', '������� �����', 'folder5', cookievalue('tree_example_long_branch_08', 'open'));
  $tree->AddNode('_long_branch_08', '_long_branch_09', '������� �����', 'folder5', cookievalue('tree_example_long_branch_09', 'open'));
  $tree->AddNode('_long_branch_09', '_long_branch_10', '����', '');

  $tree->AddNode('', '_without_images', '���� ��� ������', 'folder3', cookievalue('tree_example_without_images', 'open'));
  $tree->AddNode('_without_images', '_wi_01', '���� 1', '');
  $tree->AddNode('_without_images', '_wi_02', '���� 2', '');
  $tree->AddNode('_without_images', '_wi_03', '���� 3', '');
  $tree->AddNode('_without_images', '_wi_04', '���� 4', '');

  $tree->AddNode('', '_settings', '���������', 'settings', cookievalue('tree_example_settings', 'open'));
  $tree->AddNode('_settings', '_settings_01', '������������', 'shield2');
  $tree->AddNode('_settings', '_settings_02', '�����', 'blocks');
  $tree->AddNode('_settings', '_settings_03', '������', 'class');
  $tree->AddNode('_settings', '_settings_04', '���� ������', 'database');
  $tree->AddNode('_settings', '_settings_05', '������ �������������', 'userqueue');
  $tree->AddNode('_settings', '_settings_06', '�����������', 'diagnostics');
  $tree->AddNode('_settings', '_settings_07', '����', 'tree');

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
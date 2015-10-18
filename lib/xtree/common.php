<?php

//
// (C) mkp, 2007
// Author: Mastushkin Kirill. Tomsk.
// E-mail: mkp@inbox.ru, mkp@tpce.tomsk.ru
// ICQ: 169035175
//

if (!defined('IN_APPLICATION')) { die('hacking attempt'); }

  function cookievalue($name, $val = '') {
    if (isset($_COOKIE[$name]))
    if ($_COOKIE[$name] == $val) return true;
    return false;
  }

?>
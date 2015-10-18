//
// (C) mkp, 2007
// Author: Mastushkin Kirill. Tomsk.
// E-mail: mkp@inbox.ru, mkp@tpce.tomsk.ru
// ICQ: 169035175
//

function setcookievalue(name, value, seconds, path, domain, secure) {
  var today = new Date();
  expires = new Date(today.getTime() + seconds * 1000);
  document.cookie = name + "="+escape(value) + 
                 "; expires=" + expires.toGMTString() + 
                 ((path) ? "; path=" + path : "") +
                 ((domain) ? "; domain=" + domain : "") +
                 ((secure) ? "; secure" : "");
}

// Open/Close treeNode
function OC(n, id, seconds, path, domain, secure, imagepath){
  t = 't'+n;
  i = 'i'+n;
  f = 'f'+n;
  cookie_name = 'tree_'+id;
  s = window.document.all[i].src;
  if (window.document.all[t].style.display == 'none') {
    window.document.all[t].style.display = '';
    setcookievalue(cookie_name, 'open', seconds, path, domain, secure);
    if (s.lastIndexOf('plus.gif')>0)  window.document.all[i].src = imagepath + '/minus.gif';
    else window.document.all[i].src = imagepath + '/minus2.gif';
  } else {
    window.document.all[t].style.display = 'none';
    setcookievalue(cookie_name, 'close', seconds, path, domain, secure);
    if (s.lastIndexOf('minus.gif')>0)  window.document.all[i].src = imagepath + '/plus.gif';
    else window.document.all[i].src = imagepath + '/plus2.gif';
  }
}


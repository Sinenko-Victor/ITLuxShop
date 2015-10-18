<?php

//
// (C) mkp, 2007
// Author: Mastushkin Kirill. Tomsk.
// E-mail: mkp@inbox.ru, mkp@tpce.tomsk.ru
// ICQ: 169035175
//

if (!defined('IN_APPLICATION')) { die('hacking attempt'); }

class xtree
{
  var $treeID = '';
  var $nodesid;
  var $tree;
  var $counter = 0;
  var $imagepath = './images';
  var $imagelist;
  var $imagewidth = 19;
  var $imageheight = 16;

  // Constructor
  function xtree($text= '', $treeID = '') {
    $this->treeID = "$treeID";
    $this->nodesid = array();
    $this->tree = array();
    $this->imagelist = array();
    $this->tree['id'] = '';
    $this->tree['count'] = 0;
    $this->tree['text'] = "$text";
    $this->tree['image'] = 'root';
    $this->tree['content'] = array();
    $this->imagelist['root'] = $this->imagepath.'/root.gif';
    $this->imagelist['standartfolder'] = $this->imagepath.'/folder.gif';
  }

  function SetImagePath($path) {
    $this->imagepath = "$path";
    $this->imagelist['root'] = $this->imagepath.'/root.gif';
    $this->imagelist['standartfolder'] = $this->imagepath.'/folder.gif';
  }

  function AddNodeImage($id, $image='') {
    if (empty($image)) $image = "$id.gif";
    $this->imagelist["$id"] = $this->imagepath."/$image";
  }

  function AddNodeImageFile($id, $imagefile) {
    $this->imagelist["$id"] = "$imagefile";
  }

  // Add Node
  function AddNode($hostnodeid, $id, $text, $image='folder', $open=false) {
    $hostnodeid = trim("$hostnodeid"); 
    $id = trim("$id"); 
    if (!isset($this->nodesid[$id])) {
      $text = trim("$text");
      $image = trim("$image");
      $this->counter++;
      $nodecounter = $this->counter;
      if (empty($hostnodeid)) {
        $this->tree['count']++; 
        $treecounter = $this->tree['count'];
        $this->tree['content'][$treecounter]['id'] = $id;
        $this->tree['content'][$treecounter]['index'] = $nodecounter;
        $this->tree['content'][$treecounter]['count'] = 0;
        $this->tree['content'][$treecounter]['text'] = $text;
        $this->tree['content'][$treecounter]['image'] = $image;
        $this->tree['content'][$treecounter]['open'] = $open;
        $this->tree['content'][$treecounter]['content'] = array();
        $this->nodesid[$id]['pointer'] = "['content'][$treecounter]";
      } else {
        if (isset($this->nodesid[$hostnodeid])) {
          $ptr = $this->nodesid[$hostnodeid]['pointer'];
          $s = "
               \$this->tree $ptr ['count']++; 
               \$treecounter = \$this->tree $ptr ['count']; 
               "; eval($s);
          $s = "
               \$this->tree $ptr ['content'][$treecounter]['id'] = \$id; 
               \$this->tree $ptr ['content'][$treecounter]['index'] = \$nodecounter; 
               \$this->tree $ptr ['content'][$treecounter]['count'] = 0; 
               \$this->tree $ptr ['content'][$treecounter]['text'] = \$text; 
               \$this->tree $ptr ['content'][$treecounter]['image'] = \$image; 
               \$this->tree $ptr ['content'][$treecounter]['open'] = \$open; 
               \$this->tree $ptr ['content'][$treecounter]['content'] = array(); 
               "; eval($s);
          $this->nodesid[$id]['pointer'] = "$ptr ['content'][$treecounter]";
        }
      }
    }
  }

  // SetNodeState
  function SetNodeState($id, $state=true) {
    if (isset($this->nodesid[$id])) {
      $ptr = $this->nodesid[$id]['pointer'];
      $state = $state?'true':'false';
      $s = "\$this->tree $ptr ['open'] = $state;"; 
      eval($s);
    }
  }

  // Visualization
  function show() {
    $imgpth = $this->imagepath;
    $text = $this->tree['text'];
    $rootimage = $this->imagelist['root'];
    $iwidth =  $this->imagewidth;
    $iheight = $this->imageheight;

    print "<table border=0 cellspacing=0 cellpadding=0 style=\"table-layout: fixed;\">\n";
    print "<tr><td class=treenode width=\"{$iwidth}px\"><img src=\"$rootimage\" width=\"{$iwidth}px\" height=\"{$iheight}px\" border=0 /></td>
               <td class=treenodetext><nobr>$text</nobr></td></tr>\n";
    print "<tr><td class=treenode colspan=2>\n";
    print "<table border=0 cellspacing=0 cellpadding=0 style=\"table-layout: fixed;\">\n";
    $this->showbranch($this->tree['content'], $this->tree['count']); 
    print "</table>\n";
    print "</td></tr>\n";
    print "</table>\n";
  }

  function showbranch($branch, $items) {
    $treeID = $this->treeID;

    $iwidth =  $this->imagewidth;
    $iheight = $this->imageheight;
    $imgpth = $this->imagepath;
    $counter = 0;

    $imagewidth = $this->imagewidth;
    $imageheight = $this->imageheight;
    
    reset($branch);
    while (list ($key, $cntnt) = each ($branch)) { 
      $counter++;
      $id = "{$treeID}".$cntnt['id'];
      $nodeindex = "{$treeID}".$cntnt['index'];
      $count = $cntnt['count']; 
      $text = $cntnt['text']; 

      $display = 'none';
      $state = 'plus';
      if ($cntnt['open']) {
        $display = '';
        $state = 'minus';
      }

      $content = $cntnt['content'];

      // Node plus/minus image
      if ($items!=$counter) 
        if ($count>0) $image = "<span onClick=\"javascript:OC('$nodeindex', '$id', 1814400, '" . APP_COOKIE_PATH . "', '" . APP_COOKIE_DOMAIN . "', '', '{$imgpth}');\" onMouseOver=\"this.style.cursor='hand'\"><img src=\"$imgpth/{$state}.gif\"  border=0 width=$iwidth height=$iheight id=\"i$nodeindex\" border=0 /></span>";
        else $image = "<img src=\"$imgpth/cross.gif\" border=0 width=$iwidth height={$iheight}px border=0 />";
      else                  
        if ($count>0) $image = "<span onClick=\"javascript:OC('$nodeindex', '$id', 1814400, '" . APP_COOKIE_PATH . "', '" . APP_COOKIE_DOMAIN . "', '', '{$imgpth}');\" onMouseOver=\"this.style.cursor='hand'\"><img src=\"$imgpth/{$state}2.gif\" border=0 width=$iwidth height=$iheight id=\"i$nodeindex\" border=0 /></span>";
        else  $image = "<img src=\"$imgpth/coner.gif\" border=0 width=\"{$iwidth}px\" height=\"{$iheight}px\" border=0 />";

      print "<tr><td width=\"{$iwidth}px\">$image</td>";

      // Node image
      $image = $cntnt['image'];
      if (!empty($image)) {
        if (isset($this->imagelist[$image])) $img = $this->imagelist[$image];
        else $img = $this->imagelist['standartfolder'];
        $image = "<img width=\"{$iwidth}px\" height=\"{$iheight}px\" src=\"$img\" id=\"f$nodeindex\" border=0 />";
        if ($count>0) $image = "<span onClick=\"javascript:OC('$nodeindex', '$id', 1814400, '" . APP_COOKIE_PATH . "', '" . APP_COOKIE_DOMAIN . "', '', '{$imgpth}');\" onMouseOver=\"this.style.cursor='hand'\"><img width=\"{$iwidth}px\" height=\"{$iheight}px\" src=\"$img\" id=\"f$nodeindex\" border=0 /></span>";
      }

      $iw = empty($image) ? 1 : $iwidth;
      print "<td class=treenodetext><nobr> $text</nobr></td></tr>\n";

      if ($count>0) {
        $image = $items==$counter?'clear':'vline';
        print "<tr id=t$nodeindex style=display:$display;>\n";
        print "<td width=\"{$imagewidth}px\" background=\"$imgpth/$image.gif\"></td>\n";
        print "<td class=treenode colspan=2>\n";
        print "<table border=0 cellspacing=0 cellpadding=0 style=\"table-layout: fixed;\">\n";
        $this->showbranch($content, $count); 
        print "</table></td></tr>\n";
      }
    
    }
  }

} // class xtree

?>
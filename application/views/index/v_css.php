<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title><?=$site_name?> | <?=$page_title?></title>
    <meta name="description" content="<?=$site_description?>"/>
    <meta name="author" content="Victor Sinenko"/>
    <meta name="REVISIT-AFTER" content="1 DAYS "/>
    <meta content="text/html; charset=utf8" http-equiv="content-type"/>

<?foreach ($styles as $file_style):?>
    <?=HTML::style($file_style)?>

<?endforeach?>

<?foreach ($scripts as $file_script):?>
    <?=HTML::script($file_script)?>

<?endforeach?>
</head>
<body>
Текст<br />
----------------<br />
<span class=text_1>text_1</span><br />
<span class=text_2>text_2</span><br />
<span class=text_3>text_3</span><br />
<span class=text_4>text_4</span><br />
<span class=text_5>text_5</span><br />
<span class=text_6>text_6</span><br />
<span class=text_7>text_7</span><br />
<span class=text_8>text_8</span><br />
<span class=text_9>text_9</span><br />
<span class=text_10>text_10</span><br />
<span class=error>error</span><br />
<br />Ссылки<br />
----------------<br />
<a href="#">Без стиля</a><br />
<span class="link_1"><a href="#">link_1</a></span><br />
<span class="link_2"><a href="#">link_2</a></span><br />
<span class="link_3"><a href="#">link_3</a></span><br />
<span class="link_4"><a href="#">link_4</a></span><br />
<span class="link_5"><a href="#">link_5</a></span><br />
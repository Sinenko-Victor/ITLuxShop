<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title><?=$site_name?> | <?=$page_title?></title>
    <meta name="description" content="<?=$site_description?>"/>
    <meta name="author" content="Victor Sinenko"/>
    <meta content="text/html; charset=utf8" http-equiv="content-type"/>

<?foreach ($styles as $file_style):?>
    <?=HTML::style($file_style)?>

<?endforeach?>

<?foreach ($scripts as $file_script):?>
    <?=HTML::script($file_script)?>

<?endforeach?> 

</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="logo">
        </div>
        <!-- Верхний блок-->
        <?php
        if (isset($block_header))
        {
            foreach ($block_header as $hblock)
            {
                echo$hblock;
            }
        }
        ?>        
        <!-- /Верхний блок-->
    </div>    
    <div id="topmenu">
        <!-- Верхнее меню-->
        <?php
        if (isset($block_topmenu))
        {
            foreach ($block_topmenu as $tmblock)
            {
                echo$tmblock;
            }
        }
        ?>        
        <!-- /Верхнее меню-->
    </div>
    <div id="content">
        <!-- Центральный блок-->
        <?php
        if (isset($block_center))
        {
            foreach ($block_center as $cblock)
            {
                echo$cblock;
            }
        }
        ?>        
        <!-- /Центральный блок-->
    </div>
    <div id="footer">
        <!-- Нижний блок-->
        <?php
        if (isset($block_footer))
        {
            foreach ($block_footer as $fblock)
            {
                echo$fblock;
            }
        }
        ?>        
        <!-- /Нижний блок--> 
    </div>
</div>
</body>
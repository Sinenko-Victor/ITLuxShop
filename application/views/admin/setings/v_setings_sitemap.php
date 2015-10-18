<div id="pages_list">
    <div id="pages_header">
        <h1><?=$page_title?></h1>
    </div>
    <div id="pages_dir">
        <?=$menuset?>       
    </div>
    <div id="pages_edit">
        
<br/>
<?=Form::open('/admin/setings/sitemap/1')?>
<div id='form_in'>
    <p>
       <?=$update?> 
    </p>
    <p>

    </p>  
</div>
<br/>

<?=Form::submit('submit', ' Обновить ', array('class' => 'form_in_submit'))?>
<?=Form::close()?>
        
    </div>
    <div id="pages_footer">
    </div>
</div>
<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
 
?>


<?php echo $bcForm->create('Layout.LayoutConfigs', array('url' => array('action' => 'index'))) ?>
<p>
	<span><?php echo $bcForm->label('PageCategory.type', 'タイプ') ?> 
	<?php echo $bcForm->input('PageCategory.type', array(
			'type'		=> 'select',
			'options'	=> $pageType,
			'escape'	=> false)) ?></span>
</p>
<div class="button">
	<?php $bcBaser->link($bcBaser->getImg('admin/btn_search.png', array('alt' => '検索', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchSubmit')) ?> 
	<?php $bcBaser->link($bcBaser->getImg('admin/btn_clear.png', array('alt' => 'クリア', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchClear')) ?> 
</div>
<?php echo $bcForm->end() ?>
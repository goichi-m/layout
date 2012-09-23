<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
 

?>


<tr id="Row<?php echo $data['PageCategory']['id'] ?>"<?php echo $rowGroupClass ?>>
	<td class="row-tools">

<?php if(in_array($data['PageCategory']['owner_id'], $allowOwners)|| (!empty($user) && $user['user_group_id']==1)): ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '設定編集', 'class' => 'btn')), array('action' => 'edit', $data['PageCategory']['id']), array('title' => '設定編集')) ?>
		
		
<?php endif ?>
<?php if($count != 1 || !isset($datas)): ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_up.png', array('width' => 24, 'height' => 24, 'alt' => '上へ移動', 'class' => 'btn')), array('controller' => 'page_categories', 'action' => 'ajax_up', $data['PageCategory']['id']), array('class' => 'btn-up', 'title' => '上へ移動')) ?>
<?php else: ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_up.png', array('width' => 24, 'height' => 24, 'alt' => '上へ移動', 'class' => 'btn')), array('controller' => 'page_categories', 'action' => 'ajax_up', $data['PageCategory']['id']), array('class' => 'btn-up', 'title' => '上へ移動', 'style' => 'display:none')) ?>
<?php endif ?>
<?php if(count($datas) != $count || !isset($datas)): ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_down.png', array('width' => 24, 'height' => 24, 'alt' => '下へ移動', 'class' => 'btn')), array('controller' => 'page_categories', 'action' => 'ajax_down', $data['PageCategory']['id']), array('class' => 'btn-down', 'title' => '下へ移動')) ?>
<?php else: ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_down.png', array('width' => 24, 'height' => 24, 'alt' => '下へ移動', 'class' => 'btn')), array('controller' => 'page_categories', 'action' => 'ajax_down', $data['PageCategory']['id']), array('class' => 'btn-down', 'title' => '下へ移動', 'style' => 'display:none')) ?>
<?php endif ?>
	</td>
	<td><?php echo $data['PageCategory']['id']; ?></td>
	<td>
	<?php if($data['PageCategory']['name']!='mobile'): ?>
		<?php $bcBaser->link($data['PageCategory']['name'], array('action' => 'edit', $data['PageCategory']['id'])); ?>
	<?php else: ?>
		<?php echo $data['PageCategory']['name'] ?>
	<?php endif ?>
	<?php if($bcBaser->siteConfig['category_permission']): ?>
	<br />
	<?php echo $bcText->arrayValue($data['PageCategory']['owner_id'], $owners) ?>
	<?php endif ?>
	</td>
	<td><?php echo $data['PageCategory']['title']; ?></td>
    <td>
    <?php
	$layoutModel = ClassRegistry::init('Layout.Layout');
	$layoutData = $layoutModel->find('first',array('conditions'=>array('page_categories_id'=>$data['PageCategory']['id'])));
	if(!empty($layoutData)){
		echo $layoutData['Layout']['layout'];
	}else{
		echo '未設定<br />（default.phpが適用されます）';	
	}
    
	?>
    </td>
	<td style="white-space:nowrap"><?php echo $bcTime->format('Y-m-d', $data['PageCategory']['created']); ?><br />
		<?php echo $bcTime->format('Y-m-d', $data['PageCategory']['modified']); ?></td>
</tr>
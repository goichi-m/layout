<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
 
?>


<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
	<thead>
		<tr>
			<th class="list-tool">
			操作
			</th>
			<th>NO</th>
			<th>ページカテゴリー名
	<?php if($bcBaser->siteConfig['category_permission']): ?>
				<br />管理グループ
	<?php endif ?>
			</th>
			<th>ページカテゴリータイトル</th>
            <th>現在のレイアウト設定</th>
			<th>登録日<br />更新日</th>
		</tr>
	</thead>
	<tbody>
<?php if(!empty($datas)): ?>
	<?php $currentDepth = 0 ?>
	<?php foreach($datas as $key => $data): ?>
<?php
$rowIdTmps[$data['PageCategory']['depth']] = $data['PageCategory']['id'];

// 階層が上がったタイミングで同階層よりしたのIDを削除
if($currentDepth > $data['PageCategory']['depth']) {
	$i=$data['PageCategory']['depth']+1;
	while(isset($rowIdTmps[$i])) {
		unset($rowIdTmps[$i]);
		$i++;
	}
}
$currentDepth = $data['PageCategory']['depth'];
$rowGroupId = array();
foreach($rowIdTmps as $rowIdTmp) {
	$rowGroupId[] = 'row-group-'.$rowIdTmp;
}
$rowGroupClass = ' class="depth-'.$data['PageCategory']['depth'].' '.implode(' ', $rowGroupId).'"';
?>
		<?php $currentDepth = $data['PageCategory']['depth'] ?>
		<?php $bcBaser->element('layout_configs/index_row', array('datas' => $datas, 'data' => $data, 'count' => ($key + 1), 'rowGroupClass' => $rowGroupClass)) ?>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="5"><p class="no-data">データが見つかりませんでした。</p></td>
	</tr>
<?php endif; ?>
	</tbody>
</table>
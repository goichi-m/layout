<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
 
?>
<tr>
	<th>固定ページ管理メニュー</th>
	<td>
		<ul class="cleafix">
			<li><?php $bcBaser->link('一覧を表示する', array('plugin'=>'','controller' => 'pages', 'action' => 'index')) ?></li>
<?php if($newCatAddable): ?>
			<li><?php $bcBaser->link('新規に登録する', array('plugin'=>'','controller' => 'pages', 'action' => 'add')) ?></li>
<?php endif ?>
			<li><?php $bcBaser->link('固定ページテンプレート読込', array('plugin'=>'','controller' => 'pages', 'action' => 'entry_page_files'), array('confirm' => 'テーマ '.Inflector::camelize($bcBaser->siteConfig['theme']).' フォルダ内のページテンプレートを全て読み込みます。\n本当によろしいですか？')) ?></li>
			<li><?php $bcBaser->link('固定ページテンプレート書出', array('plugin'=>'','controller' => 'pages', 'action' => 'write_page_files'), array('confirm' => 'データベース内のページデータを、'.'テーマ '.Inflector::camelize($bcBaser->siteConfig['theme']).' のページテンプレートとして全て書出します。\n本当によろしいですか？')) ?></li>
		</ul>
	</td>
</tr>


<tr>
	<th>固定ページカテゴリー管理メニュー</th>
	<td>
		<ul class="cleafix">
			<li><?php $bcBaser->link('一覧を表示する', array('plugin'=>'','controller' => 'page_categories', 'action' => 'index')) ?></li>
<?php if($newCatAddable): ?>
			<li><?php $bcBaser->link('新規に登録する', array('plugin'=>'','controller'=> 'page_categories', 'action' => 'add')) ?></li>
<?php endif ?>
		</ul>
	</td>
</tr>


<tr>
	<th>固定ページレイアウト管理メニュー</th>
	<td>
		<ul class="cleafix">
			<li><?php $bcBaser->link('一覧を表示する', array('plugin'=>'layout','controller' => 'layout_configs', 'action' => 'admin_index')) ?></li>
		</ul>
	</td>
</tr>
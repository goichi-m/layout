<?php
		
			
			//データを取得できれば処理に入る。
			if(!empty($treeList)){
				
				//取得した再上位のノード名で判定する。
				$parentName = $treeList['PageCategory']['name'];
			 
				if($parentName != 'mobile' && $parentName != 'smartphone'){
					$parentName = 'pc';	 
				} 
			}
		
		
		//親ノードが空っぽならＰＣ確定
		if(empty($parentName)){
		
			$parentName = 'pc';	
			
		}
		
				
		//カテゴリの種類（PC,MOBILE,SMARTPHONE）によって、レイアウトファイルの検索先を変える。
		switch($parentName){
		
			case 'pc':
					if($bcBaser->siteConfig['theme']){
						$templatesPathes[] = WWW_ROOT.'themed'.DS.$bcBaser->siteConfig['theme'].DS.'layouts'.DS;
					}			
					break;
				
			case 'mobile':
					if($bcBaser->siteConfig['theme']){
						$templatesPathes[] = WWW_ROOT.'themed'.DS.$bcBaser->siteConfig['theme'].DS.'layouts'.DS.'mobile'.DS;
					}			
					break;
				
			case 'smartphone':
					if($bcBaser->siteConfig['theme']){
						$templatesPathes[] = WWW_ROOT.'themed'.DS.$bcBaser->siteConfig['theme'].DS.'layouts'.DS.'smartphone'.DS;
					}			
					break;
				
			default:
				break;	
			
		}
		
		
		//テンプレート名格納用
		$_templates = array();
		
		//テンプレートを配列に格納していく。
		foreach($templatesPathes as $templatesPath){
			$folder = new Folder($templatesPath);
			$files = $folder->read(true, true);
			$foler = null;
			if($files[1]){
				if($_templates){
					$_templates = am($_templates,$files[1]);
				}else{
					$_templates = $files[1];
				}
			}
		}
		
		
		//オプションの配列生成。
		$templateOption = array();
		foreach($_templates as $template){
			
			$templateOption[] = array('name'=>$template,'value'=>$template);
			
		}

?>


<?php echo $bcForm->create('LayoutConfigs',array('action'=>'admin_edit')) ?>

<?php if(!empty($layoutData['Layout']['id'])): ?>

<?php echo $bcForm->hidden('Layout.id', array('value' => $layoutData['Layout']['id'])) ?>

<?php endif; ?>

<?php
//カテゴリ　page_categories_id
echo $bcForm->hidden('Layout.page_categories_id', array('value' => $categoryData['PageCategory']['id']));
?>


<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head">カテゴリ名</th>
			<td class="col-input">
				<?php
                
				echo $categoryData['PageCategory']['name'];
				
				?>
			</td>
		</tr>
        		<tr>
			<th class="col-head">カテゴリタイトル</th>
			<td class="col-input">
				<?php
                
				echo $categoryData['PageCategory']['title'];
				echo $bcForm->hidden('Layout.name', array('value' => $categoryData['PageCategory']['title']))
				?>
			</td>
		</tr>
		<tr>
			<th class="col-head">タイプ</th>
			<td class="col-input">
			<?php
            	if(!empty($parentName)){
			
					switch($parentName){
				
					case 'pc':
							echo 'PC用';			
							break;
						
					case 'mobile':
							echo 'モバイル';
							break;
						
					case 'smartphone':
							echo 'スマートフォン用';
							break;
						
					default:
						break;	
							
					}
					
				}else{
					
					echo 'PC用';
										
				}
			
			?>
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $bcForm->label('Layout.layout', '適用するレイアウト') ?></th>
			<td class="col-input">
				<?php
				//現在の設定確認
				if(!empty($layoutData['Layout']['layout'])){
				
					 $thisSetting = $layoutData['Layout']['layout'];
				
				//未設定
				}else{
					$thisSetting = NULL;	
				}
                
				echo $bcForm->select('Layout.layout',$templateOption,$layoutData['Layout']['layout'], null, null);
				
				
				?>
                
                
			</td>
		</tr>

	</table>
    
    
</div>
<div class="submit">

	<?php echo $bcForm->submit('更新', array('div' => false, 'class' => 'btn-orange button')) ?>
	<?php 
	
		if(!empty($layoutData['Layout']['id'])){
			$bcBaser->link('解除', 
				array('action'=>'delete', $layoutData['Layout']['page_categories_id']),
				array('class'=>'btn-gray button'),
				sprintf('%s を設定を解除してもいいですか？\n\nカテゴリはデフォルトのレイアウトファイルを使用するようになります。', $bcForm->value('PageCategory.name')),
				false);
			}
			
	?>

</div>

<?php echo $bcForm->end() ?>


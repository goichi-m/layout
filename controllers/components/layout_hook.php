<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
 

/********************************************
**
**　フック
**
********************************************/
class LayoutHookComponent extends Object {

	/*-----------------------------------------*/
	//　設定
	/*-----------------------------------------*/
    var $registerHooks = array('beforeRender');
	
	
	
	/********************************************
	*　ページ表示時に処理を事前実行する
	********************************************/
	function beforeRender($controller){
		
		
		/*-----------------------------------------------------
		*　ページ出力時に処理に入る
		*-----------------------------------------------------*/
		if($controller->name == 'Pages'){
		
	
			$layoutName = '';
			
			/*-----------------------------------------*/
			//　モデルの追加設定
			/*-----------------------------------------*/
			$pageContentsModel = ClassRegistry::init('Page.PageCategory');
			$pagesModel = ClassRegistry::init('Page.Pages');
			$layoutChangerModel = ClassRegistry::init('Layout.Layout');
				
			
			/*-----------------------------------------*/
			//　カテゴリ情報の取得
			/*-----------------------------------------*/
			
			//　親カテゴリ
			/*-------------*/
			if(isset($controller->params['pass'][0])){
				//カテゴリ名を代入
				$parentCategory = $controller->params['pass'][0];
				//親カテゴリの名前からIDを取得する。
				$parentCategoryData = $pageContentsModel->find('first',array('conditions'=>array(
						'name' => $parentCategory
					)));
				//親ID
				$parentId = $parentCategoryData['PageCategory']['id'];
				//この親カテゴリのレイアウト設定を確認する。
				$parentSettingData = $layoutChangerModel->find('all',array('conditions'=>array(
						'page_categories_id' => $parentId
				)));
				//カテゴリデータが登録されていれば、レイアウトを設定する。
				if(!empty($parentSettingData) && $parentSettingData[0]['Layout']['layout'] != '---'){
					$layoutName = $parentSettingData[0]['Layout']['layout'];
				}
				
			}
			
			//　子カテゴリ
			/*-------------*/
			if(isset($controller->params['pass'][1])){
				//カテゴリ名を代入
				$childCategory = $controller->params['pass'][1];
				//子カテゴリの名前からIDを取得する。
				$childCategoryData = $pageContentsModel->find('first',array('conditions'=>array(
						'name' => $childCategory
					)));
				//子ID
				$childId = $childCategoryData['PageCategory']['id'];
				//この親カテゴリのレイアウト設定を確認する。
				$childSettingData = $layoutChangerModel->find('all',array('conditions'=>array(
						'page_categories_id' => $childId
				)));
				//カテゴリデータが登録されていれば、レイアウトを設定する。
				if(!empty($childSettingData) && $childSettingData[0]['Layout']['layout'] != '---'){
					$layoutName = $childSettingData[0]['Layout']['layout'];
				}
			}
			

			//レイアウトを指定する。
			if($layoutName != ''){
				//正規表現にて拡張子PHPを外す
				$layoutName = preg_replace("/.[^.]+$/","",$layoutName);
				$controller->layout = $layoutName;
			}
		}


	}
	

}

?>
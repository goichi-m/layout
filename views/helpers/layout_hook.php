<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
* @descript     ページ管理、カテゴリ管理にサブメニューを追加する
*/

/********************************************
**
**　ヘルパーフック
**
********************************************/
class LayoutHookHelper extends AppHelper{

	//設定
	var $registerHooks = array('beforeRender');
	
	
	/********************************************
	*　ページ表示時に処理を事前実行する
	********************************************/
	function beforeRender(){
	
		/*-----------------------------------------*/
		//　Viewの情報を得るためオブジェクトを取得する
		/*-----------------------------------------*/
		$view = ClassRegistry::getObject('View');
		$controller = $view->name; //コントローラー名取得
		
		//Pageコントローラーであり、かつ管理画面であればサブメニューに追記を行う。
		if($controller == 'Pages' || $controller == 'PageCategories'){
		if(!empty($view->viewVars['currentPrefix'])){
			if($view->viewVars['currentPrefix'] == 'admin'){
			
				//サブメニューセット関数を利用する為、ヘルパーを取得しておく
				App::import('Helper','BcBaser');
    			$bcBaser = new BcBaserHelper();
    			//噂によるとこの関数は上書きということだったが、下のように書くと追記で処理できる。
    			//相対パスで書くのはver2.0.5現在のbaserCMSでは他に手がない為。（フォーラムで確認済み）
 				$subMenus = array('../../../../../app/plugins/layout/views/elements/admin/submenus/layout_configs');
 				
 				//サブメニュー追加実行
 				$bcBaser->setSubMenus($subMenus);
			}
		}
	
	}
		
	}
}
?>
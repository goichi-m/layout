<?php
/*
*　レイアウト個別設定プラグイン
*
* @link			http://mani-lab.com   mani-lab
* @version		2.0.0
* @lastmodified	2012-09-23
*/
class LayoutConfigsController extends AppController {


	/********************************************
	*　設定
	********************************************/
	var $name = 'LayoutConfigs';
	var $helpers = array(BC_TEXT_HELPER, BC_FORM_HELPER, BC_ARRAY_HELPER);
	var $uses = array('PageCategory','Layout.Layout');
	var $components = array('BcAuth','Cookie','BcAuthConfigure');
	var $crumbs = array(array('name' => '固定ページレイアウト管理', 'url' => array('controller' => 'layout_configs', 'action' => 'index')));
	function beforeFilter() {
		
		parent::beforeFilter();
		$user = $this->BcAuth->user();
		$userModel = $this->getUserModel();
		$newCatAddable = $this->PageCategory->checkNewCategoryAddable(
				$user[$userModel]['user_group_id'], 
				$this->checkRootEditable()
		);
		$this->set('newCatAddable', $newCatAddable);
		
	}
	



	/********************************************
	*　カテゴリの一覧表示を行う
	********************************************/
	function admin_index() {

		if(!Configure::read('BcApp.mobile')) {
			$this->data['PageCategory']['type'] = 'pc';
		}
			
		$default = array('PageCategory' => array('type'=>'pc'));
		$this->setViewConditions('PageCategory', array('default' => $default));

		$mobileId = $this->PageCategory->getAgentId('mobile');
		$smartphoneId = $this->PageCategory->getAgentId('smartphone');
		
		$ids = array();
		$conditions = array();
		if($this->data['PageCategory']['type'] == 'pc' || empty($this->data['PageCategory']['type'])) {
			$children = am($this->PageCategory->children($mobileId, false, array('PageCategory.id')), $this->PageCategory->children($smartphoneId, false, array('PageCategory.id')));
			if($children) {
				$ids = am($ids, Set::extract('/PageCategory/id', $children));
			}
			$ids = am(array($mobileId, $smartphoneId), $ids);
			$conditions = array('NOT' => array('PageCategory.id' => $ids));
		} elseif($this->data['PageCategory']['type'] == 'mobile') {
			$children = am($this->PageCategory->children($mobileId, false, array('PageCategory.id')));
			if($children) {
				$ids = am($ids, Set::extract('/PageCategory/id', $children));
			}
			if($ids) {
				$conditions = array(array('PageCategory.id' => $ids));
			}
		} elseif($this->data['PageCategory']['type'] == 'smartphone') {
			$children = am($this->PageCategory->children($smartphoneId, false, array('PageCategory.id')));
			if($children) {
				$ids = am($ids, Set::extract('/PageCategory/id', $children));
			}
			if($ids) {
				$conditions = array(array('PageCategory.id' => $ids));
			}
		}
		
		$datas = array();
		if($conditions) {
			$_dbDatas = $this->PageCategory->generatetreelist($conditions);
			$datas = array();
			foreach($_dbDatas as $key => $dbData) {
				$category = $this->PageCategory->find('first', array('conditions' => array('PageCategory.id'=>$key), 'recursive' => -1));
				if(preg_match("/^([_]+)/i",$dbData,$matches)) {
					$prefix = str_replace('_','&nbsp&nbsp&nbsp',$matches[1]);
					$category['PageCategory']['title'] = $prefix.'└'.$category['PageCategory']['title'];
					$category['PageCategory']['depth'] = strlen($matches[1]);
				} else {
					$category['PageCategory']['depth'] = 0;
				}
				$datas[] = $category;
			}
		}
		
		$this->_setAdminIndexViewData();
		$this->set('datas', $datas);
		
		if($this->RequestHandler->isAjax() || !empty($this->params['url']['ajax'])) {
			$this->render('ajax_index');
			return;
		}
		
		$pageType = array();
		if(Configure::read('BcApp.mobile') || Configure::read('BcApp.smartphone')) {
			$pageType = array('pc' => 'PC');	
		}
		if(Configure::read('BcApp.mobile')) {
			$pageType['mobile'] = 'モバイル';
		}
		if(Configure::read('BcApp.smartphone')) {
			$pageType['smartphone'] = 'スマートフォン';
		}
		if($pageType) {
			$this->search = 'page_categories_index';
		}
		$this->help = 'page_categories_index';
		$this->set('pageType', $pageType);
			

		/* 表示設定 */
		$this->subMenuElements = array('layout_configs');
		$this->pageTitle = 'レイアウト設定　カテゴリ一覧';
		$this->search = 'layout_index';
		$this->help = 'layout_configs_index';

	}




	/********************************************
	*　カテゴリのレイアウト設定画面
	********************************************/
	function admin_edit($id = null) {
				
		
		
		//データの入力があるかどうか？（更新ボタン押下の確認）
		if(empty($this->data)){
			
			
				//テンプレートの場所格納用配列
				$templatesPathes = array();
				
				//このカテゴリのデータを取得する。
				$categoryData = $this->PageCategory->find('first',array('conditions'=>array('id'=>$id)));
				
				//カテゴリデータのセット
				$this->set('categoryData',$categoryData);
						
				//ツリービヘイビアの性質を利用して再上位の親ノードを取得する。
				$options['conditions']['lft <'] = $categoryData['PageCategory']['lft'];
				$options['conditions']['rght >'] = $categoryData['PageCategory']['rght'];
				
					//lftとrghtの値を元にデータを取得する。
					$treeList =  $this->PageCategory->find('first',$options);
					
					$this->set('treeList',$treeList);
			
				
				//現在のレイアウト設定の取得を行う
				$layoutData = $this->Layout->find('first',array(
								'conditions'=>array(
									'page_categories_id'=>$id
								)));
				
				$this->set('layoutData',$layoutData);		
				
		
		
		//送信されてきたデータを元に保存処理
		}else{
			
				//
				if($this->Layout->save($this->data)){
					
					//完了後、表示するメッセージ
					$this->Session->setFlash('カテゴリ「'.$this->data['Layout']['name'].'」のレイアウト設定を更新しました。');
					//ログに残すメッセージ
					$this->Layout->saveDbLog('カテゴリ「'.$this->data['Layout']['name'].'」のレイアウト設定を更新しました。');
					
					//リダイレクト
					$this->redirect(array('action' => 'admin_index'));
					
					
				}else{
				
					$this->Session->setFlash('保存に失敗しました。');	
					
				}
			
		}
		

		//$this->set('parents', $parents);
		$this->subMenuElements = array('layout_configs');
		$this->pageTitle = 'レイアウト設定　設定編集'.$this->data['PageCategory']['title'];
		$this->help = 'layout_configs_form';
		$this->render('form');

	}
	
	


	/********************************************
	*　カテゴリに設定されたレイアウトを解除する
	********************************************/
	function admin_delete($id = null) {
		
		if(empty($id)){
			
			$this->Session->setFlash('無効なIDです');
			$this->redirect(array('action' => 'admin_index'));
		
		}else{
			
			//データを取得する。
			$layoutData = $this->Layout->find('first',array('conditions'=>array('page_categories_id'=>$id)));
			$layoutId = $layoutData['Layout']['id'];
			
				//この時点でデータを取得できない
				if(empty($layoutId)){
						$this->Session->setFlash('設定情報がありません。');
						$this->redirect(array('action' => 'admin_index'));
				}
			
			//カテゴリ名の取得
			$categoryData =  $this->PageCategory->find('first',array('conditions'=>array('id'=>$id)));
			$categoryName = $categoryData['PageCategory']['title'];
		
		}
				
		
		//削除処理実行
		if($this->Layout->del($layoutId)) {
			
			//完了後、表示するメッセージ
			$this->Session->setFlash('カテゴリ「'.$categoryName.'」のレイアウト設定を解除しました。');
			//ログに残すメッセージ
			$this->Layout->saveDbLog('カテゴリ「'.$categoryName.'」のレイアウト設定を解除しました。');
			$this->redirect(array('action' => 'admin_index'));
			
		}else{
			
			$this->Session->setFlash('DB処理実行中にエラーが発生しました');
			$this->redirect(array('action' => 'admin_index'));
			
		}

	}


	
	/********************************************
	*　一覧生成
	********************************************/
	function _setAdminIndexViewData() {
		
		$allowOwners = array();
		if(isset($user['user_group_id'])) {
			$allowOwners = array('', $user['user_group_id']);
		}
		$this->set('allowOwners', $allowOwners);
		$this->set('owners', $this->PageCategory->getControlSource('owner_id'));
		
	}

	
}
?>
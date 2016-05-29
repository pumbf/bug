<?php
namespace Home\Controller;
use Think\Controller;
use Home\Controller\DebugController;
class IndexController extends Controller {
    public function index($id = '2015210001'){
    	try{
       		$M = M('Lesson');
       		$data = $M->where('studentid='.$id)->select();
       		$message;
       		foreach ($data  as $value) {
       			$n = (int)$value['week']+7*(int)$value['time'];
       			$message[$n][] = $value;
       		}
       		$message['studentid'] = $id;       		
       		$this->assign('data',$message);
       		$this->display('index');
       	} catch(Exception $e) {
       		$this->error('数据为空，获取数据中....',U('Index/getData'));
       	}
       	

    }
    public function getData(){
    	echo'获取数据中:)....';
    	 $Debug = new DebugController('2015210001',100);
    }
}
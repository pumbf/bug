<?php
namespace Home\Controller;
use Think\Controller;
use Home\Controller\DebugController;
class IndexController extends Controller {
    public function index()
    {
    	$id = I('post.id', '','htmlspecialchars');
    	unset($_POST['id']);
    	$pattern = '/^201[2-5][0-9]{6}$/';
    	if(preg_match($pattern,$id)) {
    		  $M = M('Lesson');
       	  $data = $M->where('studentid='.$id)->select();
       	  if(!$data) {
       			  $data = $this->getData($id);
       		}
       	  $message;
       	  foreach ($data  as $value) {
       			  $n = (int)$value['week']+7*(int)$value['time'];
       			  $message[$n][] = $value;
        	}
       	  $message['studentid'] = $id;  		
       	  $this->assign('data',$message);
       	  }
		  $this->display('index');      	

    }
    

    private function getData($id)
    {
    	 $Debug = new DebugController();
    	 $data = $Debug->runIt($id);
    	 return $data;
    }
}
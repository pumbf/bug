<?php

namespace Home\Controller;

use Think\Controller;

class DebugController //extends Controller
{
	//匹配信息
	private $pattern = array(
		'/<td[^>]*?>.*?<\\/td>/',
		'/(?<classid>\\d*)<br>(?<lessonname>.*?)<br>(?<teacher>.*?)<br>(?<classroom>.*?)<br><font[^>]*?>(?<method>.*?)<\\/font><br>(?<weeks>.*?)<br>选课状态:(?<status>.*?)<br><font[^>]*?>(?<special>.*?)<\\/font><br>/'

	);

	//过滤
	private $annotation = array(
		'/\\t/',
		'/\\n/',
		'/\\r/',
		'/<!--(?s).*?-->/'
	);
	private $id;
	private $data = array();

	public function runIt($id = 2015211703)
	{
		$targetUrl = 'http://jwzx.cqupt.edu.cn/pubStuKebiao.php?xh=' . $id;
		$this->id = $id;
		$text = $this->runCurl($targetUrl);
		if($text) 
			$this->analyze($text);
		return $this->data;
	}

	private function runCurl($url)
	{
		$curl = curl_init();
		//参数
		$opt = array(
			CURLOPT_RETURNTRANSFER  => TRUE,	//不显示在屏幕上
			CURLOPT_URL             => $url,    //目标地址
			CURLOPT_HEADER          => false, 	//是否显示请求头
			CURLOPT_NOBODY          => false	//显示<body>标签
			//CURLOPT_TIMEOUT			=> 60
		);
		curl_setopt_array($curl, $opt);
		$text = curl_exec($curl);		
		if(!$text){
			return NULL;
		}
		curl_close($curl);
		
		return $text;
	}

	private function analyze($text)
	{
		$data;
		//去注释
		$text = preg_replace($this->annotation, '', $text);
		//转码
		$text = iconv('GBK', 'UTF-8', $text);
		//把<td>内容单独拿出来
		preg_match_all($this->pattern['0'], $text, $subject);
		$lesson = array();
		foreach ($subject[0] as $key => $value) {
			$week = $key%7+1;
			$time = $key/7;
			//分析数据
			$num  = preg_match_all($this->pattern['1'], $value, $message);
			if ($message['classid']['0']) {
				$this->addData($message, $num, $week, $time);
			}
			
		}

	}

	private function addData($message, $num, $week, $time)
	{
		$model = M('Lesson');
		$lesson['studentid']  	= $this->id;
		$lesson['time']  	 	= $time;
		$lesson['week']		 	= $week;
		//添加数据
		for($i=0; $i<$num; $i++) {
			
			$lesson['classid'] 	 	= $message['classid'][$i];
			$lesson['teacher'] 	 	= $message['teacher'][$i];
			$lesson['lessonname'] 	= $message['lessonname'][$i];
			$lesson['classroom'] 	= $message['classroom'][$i];
			$lesson['method']    	= $message['method'][$i];
			$lesson['weeks'] 	 	= $message['weeks'][$i];
			$lesson['status'] 	 	= $message['status'][$i];
			$lesson['special']	 	= $message['special'][$i];
			$this->data[]			= $lesson;
			$model->create($lesson);
			$model->add();
		}
			unset($model);
	}
}


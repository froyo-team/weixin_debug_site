<?php
require_once 'SimulationRequest.class.php';
class WxDebug{
	private function getFormatData($to_user, $from_user, $type, $content, $event = '', 
												 $msg_id = '1234567890',$creat_time){
		 if ($creat_time == null){
		 		$creat_time = time();
		 }
		return $post_data = "<xml>
						      <ToUserName><![CDATA[$to_user]]></ToUserName>
						      <FromUserName><![CDATA[$from_user]]></FromUserName> 
						      <CreateTime>$creat_time</CreateTime> 
						      <MsgType><![CDATA[$type]]></MsgType> 
						      <Content><![CDATA[$content]]></Content>
						      <Event><![CDATA[$event]]></Event>  
						      <MsgId>$msg_id</MsgId></xml>";
}

public function sendMsg($token, $to_user, $from_user, $type, $content,$url,$port=80,
											$event = '', $msg_id = '1234567890', $creat_time = null){
		if ($creat_time == null){
		 		$creat_time = time();
		 }									
		$data = $this->getFormatData($to_user, $from_user, $type, $content,
																		$event , $msg_id, $creat_time = null);
    $timestamp = (string)time();
    $nonce = (string)rand();
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr);
    $tmpStr = implode( $tmpArr );
    $signature = sha1( $tmpStr );

    $url = rtrim($url,'/')."/?signature=$signature&timestamp=$timestamp&nonce=$nonce";
		$simulation_request = new SimulationRequest();
		$simulation_request->setType('XML');
		$simulation_request->setUrl($url);
		$simulation_request->setPort($port);
		$result = $simulation_request->request($data);
		return $result;
}

public function jsonReturnSendMsg($token, $to_user, $from_user, $type, $content,$url,$port=80,
											$event = '', $msg_id = '1234567890',$creat_time=NULL){
	if ($creat_time == null){
	 		$creat_time = time();
	 }	
	$result = $this->sendMsg($token,$to_user, $from_user, $type, $content,$url,$port,
											$event , $msg_id, $creat_time = null);
	if($result['status'] == 'ok'){
      $result['content'] = str_replace('<![CDATA[','',$result['content']);
      $result['content'] = str_replace(']]>','',$result['content']);
      $result = json_decode(json_encode(simplexml_load_string($result['content'])),TRUE);
      if(isset($result['MsgType']) && $result['MsgType'] == 'text'){
        $result['Content'] = str_replace("\n",'</br>',$result['Content']);
        return json_encode($result);    
			}else if(isset($result['MsgType']) && $result['MsgType'] == 'news'){
				return json_encode($result);
			}    
    }
  }
}
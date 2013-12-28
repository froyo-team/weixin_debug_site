<?php
class SimulationRequest{
	private $type = 'POST';
	private $url = '';
	private $port = '80';
	private $limit_time = 50;

	public function setType($type){
		$this->type = $type;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function setPort($port){
		$this->port = $port;
	}

	public function setLimitTime($limit_time){
		$this->limit_time = $limit_time;
	}



	public function request($data){
		/* simulation request by php
			Args:$data;
			Return:array('status'=>'ok/error',
									'header'=>'header string',
									'content'=>'content string')
		*/
		$url = parse_url($this->url);
    $host = $url['host'];
    $path = $url['path'];
   
  	
  	
    if ($url['scheme'] != 'http') {
      return array(
          'status' => 'err',
          'error' => "Host must starts with http:// !!"
      );
    }
    $fp = @fsockopen($host, $this->port, $errno, $errstr, $this->limit_time);
    if ($fp) {
			if($this->type == 'XML'){
		      fputs($fp, "POST $path HTTP/1.1\r\n");
		      fputs($fp, "Host: $host\r\n");
		      if ($referer != '')
		          fputs($fp, "Referer: $referer\r\n");
		      fputs($fp, "Content-type: text/xml\r\n");
		      fputs($fp, "Content-length: " . strlen($data) . "\r\n");
		      fputs($fp, "Connection: close\r\n\r\n");
		      fputs($fp, $data);
		     
		  }else if($this->type == 'GET'){
		  	$query = '';
		  	if(is_array($data)) 
		  		$query = http_build_query($data);
		  	$url = parse_url(rtrim($this->url,'/').$query);
				$request = $url["path"] . ($url["query"] != "" ? "?" . $url["query"] : "") . 
										($url["fragment"] != "" ? "#" . $url["fragment"] : "");
				fputs($fp, "GET " . $request . " HTTP/1.0\r\n");	    
		    if ($referer != '')
		      fputs($fp, "Referer: $referer\r\n");
				fputs("Accept: */*\r\n");
				fputs("User-Agent: Payb-Agent\r\n");
				fputs($fp, "Host: $host\r\n");
				fputs("Connection: Close\r\n\r\n");
			}else if($this->type=='POST'){
				if(is_array($data)) $query = http_build_query($data);
				fputs($fp, sprintf("POST %s%s%s HTTP/1.0/n", 
												$url['path'], $url['query'] ? "?" : "", $url['query'])); 
				fputs($fp, "Host: $url[host]/n");  
				fputs($fp, "Content-type: application/x-www-form-urlencoded/n");  
				fputs($fp, "Content-length: " . strlen($query) . "/n");  
				fputs($fp, "Connection: close/n/n");  
				fputs($fp, "$query/n");  
			}
			$result = '';
	    while (!feof($fp)) {
	          $result .= fgets($fp, 128);
	      }
	     
	  } else {
        return array(
            'status' => 'err',
            'error' => "$errstr ($errno)"
        );
		}
	  fclose($fp);
	  $result = explode("\r\n\r\n", $result, 2);

    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
		if (preg_match("/^HTTP\/[1]\.[0-5]\W+200/", $header,$match) == 1) 
    // return as structured array:
	    return array(
	        'status' => 'ok',
	        'header' => $header,
	        'content' => $content
	    );
	  else
	    return array(
	        'status' => 'error',
	        'header' => $header,
	        'content' => $content
	    );	  	
	}


}
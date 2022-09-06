<?php
	class ClassAPI{
		private static function perform_http_request($method, $url, $data = false)
		{
		    $curl = curl_init();

		    switch ($method)
		    {
		        case "POST":
		            curl_setopt($curl, CURLOPT_POST, 1);

		            if ($data)
		                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		            break;
		        case "PUT":
		            curl_setopt($curl, CURLOPT_PUT, 1);
		            break;
		        default:
		            if ($data){
		                
		                $pieces = explode(" ", $url);
		                if($pieces[0]==="http")
		                	$url = sprintf("%s?%s", $url, http_build_query($data));
		                else
		                if($pieces[0]==="https"){
		                	$curl_handle=curl_init();
							curl_setopt($curl_handle, CURLOPT_URL,$url);
							curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
							curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
							$query = curl_exec($curl_handle);
							$datas = json_decode($query, true);
							curl_close($curl_handle);
							return $datas;
		                }

		             }
		    }


		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    $result = curl_exec($curl);
		    curl_close($curl);
		    return $result;
		}

		function postAPI($url,$data){
			$get_data =$this->perform_http_request('POST', $url, $data);
			$response = json_decode($get_data, true);
			$data =$response;
			return $data;
		}


		function getAPI($url){
			
		 	$get_data = $this->perform_http_request('GET', $url, false);
			$response = json_decode($get_data, true);
			$data =$response;
			return $data;
		}

		function getRawAPI($url){
			$data = $this->perform_http_request('GET', $url, false);
			return $data;
		}

	}
?>
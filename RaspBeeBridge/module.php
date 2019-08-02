<?php


require_once __DIR__ . "/../libs/Helper.php";
require_once __DIR__ . "/../libs/RaspBeeDevice.php";
error_reporting(2);
error_reporting(E_ERROR & ~ E_PARSE);
//error_reporting(E_ALL);
//ws://192.168.178.40:8088/websocket/

class RaspBeeBridge extends IPSModule

{
    public function Create(){
        parent::Create();
		$this->RegisterPropertyString('Host', '');
		$this->RegisterPropertyString('User', '');
		$this->RegisterPropertyString('Port', '');
		$this->RegisterPropertyString('Hostname', '');		
		$this->RegisterPropertyString('Username', '');
		$this->RegisterPropertyString('Userpass', '');
		
		$this->ConnectParent("{3AB77A94-3467-4E66-8A73-840B4AD89582}");
		
      }

    public function ApplyChanges(){
        parent::ApplyChanges();

		$data=$this->Get_config();
		
		$this->ConnectParent("{3AB77A94-3467-4E66-8A73-840B4AD89582}");
		
        $this->ValidateConfiguration();
    }

	
	
    private function ValidateConfiguration(){
	
	if ($this->ReadPropertyString('Host') == '' || $this->ReadPropertyString('User') == ''|| $this->ReadPropertyString('Port') == '') {
			$this->SetStatus(104);
        } elseif (!$this->ValidateApiKey()) {
            $this->SetStatus(201);
        } else {
            $this->SetStatus(102);
        }
    }

    private function ValidateApiKey(){
    		
		$result = (array)$this->Request('/lights', null);
        if (!isset($result[0]) && !isset($result[0]->error)) {
            return true;
        } else {
				//$stat=$this->CreateApiKey();
				//if($stat)return(true);
				return false;
        }
    }

	
	public function Get_Bridge(){

		$host = $this->ReadPropertyString('Host');
		$port = $this->ReadPropertyString('Port');
		$user = $this->ReadPropertyString('User');		

		$conf = array(
			'host' => $host,
			'port' => $port,
			'user' => $user
				);
		return($conf);
	}
	
	public function CreateApiKey(){

		
		//$username = $this->ReadPropertyString('Username');
		//$userpass = $this->ReadPropertyString('Userpass');
		
		$apikey = $this->ReadPropertyString('User');
		$host = $this->ReadPropertyString('Host');
		$port = $this->ReadPropertyString('Port');
		$authorization=base64_encode($username.":".$userpass);
		$url=$host.':'.$port.'/api';
		$apikey=rand ( 11111111 , 99999999 ); 
		$temp_apikey=$apikey;
		//$temp_apikey="1234567890";
		$data_json = '{"username"' . ':"' . $temp_apikey. '",' . '"devicetype"' .':'. '"Symcon RaspBee"}';
		

		$headers = array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_json),
			'Authorization: Basic '. $authorization 
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);


		$a=json_decode($response,true);

		$apikey=$a[0]['success']['username'];
		
		if(!$apikey){
			print_r($response);
			$this->SetStatus(201);
		}
		
		if($apikey){
			$this->SetStatus(202);
			print_r("Bitte ->".$apikey."<- als Api Key eintragen");
			return(true);
		}

		return(false);
	}

	

	
    protected function GetBridge_Conf(){
        $instance = IPS_GetInstance($this->InstanceID);
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }
	
    public function Request(string $path, array $data = null){
		
		$host = $this->ReadPropertyString('Host');
		$user = $this->ReadPropertyString('User');
		$port = $this->ReadPropertyString('Port');

		if(!$host){
			$MyParent = IPS_GetInstance($this->InstanceID)['ConnectionID'];
			$host = @@IPS_GetProperty($MyParent, 'Host');
			$port = @@IPS_GetProperty($MyParent, 'Port');
			$user = @@IPS_GetProperty($MyParent, 'User');
		}	
		



		
		$client = curl_init();
        curl_setopt($client, CURLOPT_URL, "http://$host:$port/api/$user$path");

	
        curl_setopt($client, CURLOPT_USERAGENT, 'SymconRaspBee');
        curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($client, CURLOPT_TIMEOUT, 5);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        if (isset($data)) {
            curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'PUT');
        }
        if (isset($data)) {
            curl_setopt($client, CURLOPT_POSTFIELDS, json_encode($data));
        }

		
        $result = curl_exec($client);
		
        $status = curl_getinfo($client, CURLINFO_HTTP_CODE);
        curl_close($client);

        if ($status == '0') {
            $this->SetStatus(203);
            return false;
        } elseif ($status != '200') {
            $this->SetStatus(201);
            return false;
        } else {
            $result = json_decode($result);
            if (is_array($result) && @isset($result[0]->error->description) && $result[0]->error->description == 'unauthorized user') {
                $this->SetStatus(201);
                return false;
            }

            if (isset($data)) {
                if (count($result) > 0) {
                    foreach ($result as $item) {
                        if (@$item->error) {
                            IPS_LogMessage('SymconRaspBee', print_r(@$item->error, 1));
                            $this->SetStatus(299);
                            return false;
                        }
                    }
                }
                $this->SetStatus(102);
                return true;
            } else {
                $this->SetStatus(102);
                return $result;
            }
        }
		return false;
	}

	
	//on_off: true=on nach x seconds / false=off nach x seconds
	public function set_timer(string $path, $light,$time,$on_off){
		
		$host = $this->ReadPropertyString('Host');
		$user = $this->ReadPropertyString('User');
		$port = $this->ReadPropertyString('Port');

		if(!$host){
			$MyParent = IPS_GetInstance($this->InstanceID)['ConnectionID'];
			$host = @@IPS_GetProperty($MyParent, 'Host');
			$port = @@IPS_GetProperty($MyParent, 'Port');
			$user = @@IPS_GetProperty($MyParent, 'User');
		}	
	
	$is_group=0;
	$id=IPS_GetProperty($light,'PlugId');
	if(!$id)$id=IPS_GetProperty($light,'LightId');	
	if(!$id){
		$id=IPS_GetProperty($light,'GroupId');	
		if($id)$is_group=1;
	}
 		if($on_off!=""){
			if($on_off=="on")$on_off=true;
			if($on_off=="off")$on_off=false;
		}else{
			return false;
		}

		$name=$light;
		if($is_group==0){
			$json = array(
			'name' => $name,
			'description' => "Timer for ".$name,
			'command' => array(
				'address' => "/api/$user/lights/$id/state",
				'method' => "PUT",
				'body'=> array(
					'on' =>$on_off)
				),
			'time' =>"PT".$time	
			);
		}else{
			$json = array(
			'name' => $name,
			'description' => "Timer for ".$name,
			'command' => array(
				'address' => "/api/$user/groups/$id/state",
				'method' => "PUT",
				'body'=> array(
					'on' =>$on_off)
				),
			'time' =>"PT".$time	
			);
		}		
		
	$data=json_encode($json,true);
	$data = str_replace("\\/", "/", $data);
		        
			$client = curl_init();
			curl_setopt($client, CURLOPT_URL, "http://$host:$port/api/$user/schedules");
			curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
			curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($client, CURLOPT_POSTFIELDS,$data);
			curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($client, CURLOPT_USERAGENT, 'SymconRaspBee');
			curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($client, CURLOPT_TIMEOUT, 5);
			curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($client);
	

        $status = curl_getinfo($client, CURLINFO_HTTP_CODE);
        curl_close($client);

        if ($status == '0') {
            $this->SetStatus(203);
            return false;
        } elseif ($status != '200') {
            $this->SetStatus(201);
            return false;
        } else {
            $result = json_decode($result);
            if (is_array($result) && @isset($result[0]->error->description) && $result[0]->error->description == 'unauthorized user') {
                $this->SetStatus(201);
                return false;
            }

            if (isset($data)) {
                if (count($result) > 0) {
                    foreach ($result as $item) {
                        if (@$item->error) {
                            IPS_LogMessage('SymconRaspBee', print_r(@$item->error, 1));
                            $this->SetStatus(299);
                            return false;
                        }
                    }
                }
                $this->SetStatus(102);
                return true;
            } else {
                $this->SetStatus(102);
                return $result;
            }
        }
		return false;
	}

	
	
    public function Reach_Status(){
	//wird vom timer aufgerufen
	return;
	//lights&plugs	
        $lights = $this->Request('/lights');
        if ($lights) {
            foreach ($lights as $lightId => $light) {
                $uniqueId = (string)$light->uniqueid;
                $deviceId = $this->GetDeviceByUniqueIdLight($uniqueId);
				if ($deviceId <= 0) $deviceId = $this->GetDeviceByUniqueIdPlug($uniqueId);
                if ($deviceId > 0) {
                    RB_ApplyData($deviceId, $light);
                }
            }
        }
//sensors&switches
        $sensors = $this->Request('/sensors');
        if ($sensors) {
            foreach ($sensors as $sensorId => $sensor) {
                    $uniqueId = (string)$sensor->uniqueid;
					$uniqueId_org = (string)$sensor->uniqueid;
					$uniqueId = substr($uniqueId, 0, 26);
					$deviceId = $this->GetDeviceByUniqueIdSensor($uniqueId);
                    if ($deviceId <= 0)$deviceId = $this->GetDeviceByUniqueIdSwitch($uniqueId);
                    if ($deviceId > 0) {
						RB_ApplyData($deviceId, $sensor);
                    }
            }
        }
    }
	
	
    /*
     * RB_GetDeviceByUniqueId($bridgeId, $uniqueId)
     * Liefert zu einer UniqueID die passende Lampeninstanz
     */
	 
    protected function GetDeviceByUniqueIdLight(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->LightGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
	protected function GetDeviceByUniqueIdPlug(string $uniqueId){
		$deviceIds = IPS_GetInstanceListByModuleID($this->PlugGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }

    protected function GetDeviceByUniqueIdSensor(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SensorGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
    protected function GetDeviceByUniqueIdSwitch(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SwitchGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
	
    protected function GetDeviceByUniqueIdScene(string $sceneId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SceneGuid());
        foreach ($deviceIds as $deviceId) {
			if (@IPS_GetProperty($deviceId, 'SceneId') == $sceneId && $this->InstanceID == IPS_GetInstance($deviceId)['ConnectionID']) {				
                return $deviceId;
            }
        }
    }

    protected function GetDeviceByGroupId(int $groupId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->GroupGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'GroupId') == $groupId && $this->InstanceID == IPS_GetInstance($deviceId)['ConnectionID']) {
                return $deviceId;
            }
        }
    }
	
    protected function PlugGuid(){
        return '{FB468257-6AA8-4653-8C94-B8ABB7BEB736}';
    }

    protected function LightGuid(){
        return '{B1426B84-13B4-4D76-BC3B-33869AE9EA1F}';
    }

    protected function GroupGuid(){
        return '{272421BE-BB96-4082-ADA7-A642F3734E8D}';
    }

    protected function SensorGuid(){
        return '{1051CA2C-7F9E-44D4-A47A-F923CD99C237}';
    }
    protected function SceneGuid(){
        return '{D687D0DF-33FB-449A-BC66-7FDD1371E96C}';
    }
    protected function SwitchGuid(){
        return '{8691D506-3B80-46AB-B04E-A4A42B0A38AE}';
    }

	public function Get_config(){
	
		$data = $this->Request("/config", null);		
		$bridge=$this->GetBridge_Conf();
		$InstanzID = @IPS_GetInstanceIDByName("RaspBee Bridge", 0);
		
		if($this->InstanceID == $InstanzID){
		
		if($data){
			$this->bridge_maintain('Bridgeid',$data->bridgeid);
			$this->bridge_maintain('Devicename',$data->devicename);
			$this->bridge_maintain('FwVersion',$data->fwversion);
			$this->bridge_maintain('Ip',$data->ipaddress);
			$this->bridge_maintain('ModelId',$data->modelid);
			$this->bridge_maintain('Hostname',$data->name);
			$this->bridge_maintain('Swversion',$data->swversion);
			$this->bridge_maintain('Zigbeechannel',$data->zigbeechannel);			
			$this->bridge_maintain('Websocket',$data->websocketport);			
			$port = $this->ReadPropertyString('Port');
			$this->bridge_maintain('Port',$port);			
		}
		}
		return($data);
	}

	public function bridge_maintain($ident,$new){
	
		$Id = @$this->GetIDForIdent($ident);
		if(!$Id){
			$this->MaintainVariable($ident, $ident,3 ,"", 1,true);
			$Id = $this->GetIDForIdent($ident);
		}
		$old=GetValueString($Id);
		if($old != (string)$new)SetValue($Id, $new);		
		return($Id);
	}

	
	public function get_gateway(){
	//protected function get_gateway(){

	//Config Raspbee auslesen 
		$config=$this->Get_config();
		$user = $this->ReadPropertyString('User');
		$r=file_get_contents("https://dresden-light.appspot.com/discover");
		$r=json_decode($r,true);

		$this->gateway = array(
				'Host' => $r[0]['internalipaddress'],
				'Hostname' => $r[0]['name'],
				'ApiKey' => $user,
				'Port' => $r[0]['internalport'],
				'GatewayId' => $r[0]['id'],
				'Bridgeid' =>$config->bridgeid,
				'Firmwareversion' =>$config->fwversion,
				'ModelId' =>$config->modelid,
				'Swversion' =>$config->swversion,
				'Uuid' =>$config->uuid,
				'Websocketport' =>$config->websocketport,
				'Zigbeechannel' =>$config->zigbeechannel
				);
		foreach ($this->gateway as $d =>$key) {
			$a .= sprintf("%-25s",$d." :");
			$a .= sprintf("%s",$key."\n");
		}	

		echo($a);	

		return ($this->gateway);
}

	public function RequestAction($Ident, $Value){
		//protected function RequestAction($Ident, $Value)

		switch ($Ident) {
			case 'ActionButton':
				if ($Value) {
					return $this->SetResume();
				} else {
					return $this->SetPause();
				}
			}
		trigger_error($this->Translate('Invalid Ident'), E_USER_NOTICE);
		return false;
	}


 

	public function init_List(){
	//if($guid==$this->SensorGuid())
		$lights = $this->Request('/sensors');

		$Sensor_List = array();
		$Sensor = array();

		$anz=0;
		if ($lights) {	
			foreach ($lights as $lightId => $light) {
				$uniqueId = (string)$light->uniqueid;		
				$uniqueId_org = (string)$light->uniqueid;		
				$Id = (string)$light->id;
				$uni = substr($uniqueId, 0, 26);	
				$name = utf8_decode((string)$light->name);
		
				$InstanceIDListe = IPS_GetInstanceListByModuleID($this->SensorGuid());
				$found=false;
				foreach ($InstanceIDListe as $InstanceID) {
					$ParentID = IPS_GetInstance($InstanceID);
					if ($ParentID == 0)continue;
					$unique_id =@IPS_GetProperty($InstanceID, 'UniqueId');
					if($unique_id == $uniqueId_org || $unique_id == $uni){
						$found=$unique_id;//gefunden (normaler Wert)
						break;
					}
				}
	//switch
				if(!$found){
					$InstanceIDListe = IPS_GetInstanceListByModuleID($this->SwitchGuid());
					$found=false;
					foreach ($InstanceIDListe as $InstanceID) {
						$ParentID = IPS_GetInstance($InstanceID);
						if ($ParentID == 0)continue;
						$unique_id =@IPS_GetProperty($InstanceID, 'UniqueId');
						if($unique_id == $uniqueId_org || $unique_id == $uni){
							$found=$unique_id;//gefunden (normaler Wert)
							break;
						}
					}
				}	
					
				if($found){
					$anz++;
					$Sensor = array(
						'InstanceID' => $InstanceID,
						'Id' => $lightId
					)	;
	
					$Sensor_List[]=$Sensor;
				}
			}
		}	
		
		

		$this->SetBuffer("RB", json_encode($Sensor_List));
		
		return;
	}
 
     public function GetConfigurationForm(){
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);
		return json_encode($data);
    }

	//no data since ips 5.1 beta at //public function RequestAction($Ident, $Value)	
	public function ReceiveData($JSONString) {
		
		$old = $this->GetBuffer("json");

		$data = json_decode($JSONString,true);
		$data=$data['Buffer'];

		if($old != $data)$this->update_values($JSONString);
		
	}
	

  	public function update_values($JSONString){
		
		$data = json_decode($JSONString,true);
		$d=$data['Buffer'];
		$data=$data['Buffer'];
		
		$this->SetBuffer("json",$data);
		$data=json_decode($data,true);	
		
		$topic=$data['e'];
		
		if(array_key_exists('config', $data)){
//			IPS_LogMessage('RaspBee', "config event missed: "." -> ".$d);
		}
		switch ($topic)	{
			case "changed": 
				
				$no=$data['id'];
				$event=$data['r'];
				$uni=@$data['uniqueid'];
				
					
				switch ($event)	{
					case "sensors":		
						$sub_state=@$data['state'];
						$sub_config=@$data['config'];
						if($sub_state || $sub_config){
							$instance=$this->find_sensor_instance($no,$uni);
							if(!$instance){
								$instance=$this->find_light_instance($no,$uni);
								if(!$instance){
									$instance=$this->find_switch_instance($no,$uni);
								}
							}
						}
						if($instance && IPS_InstanceExists($instance))RB_UpdateData_Rest($instance,$sub_state,$sub_config,$event);
						break;
						
					case "lights":
						$sub_state=@$data['state'];
						$instance=$this->find_light_instance($no,$uni);
						if($instance && IPS_InstanceExists($instance))RB_UpdateData_Rest($instance,$sub_state,null,$event);
						break;
					case "groups":
						$sub_state=@$data['state'];
						$instance=$this->find_group_instance($no);
						if($instance && IPS_InstanceExists($instance))RB_UpdateData_Rest($instance,$sub_state,null,$event);
						break;
					default:
						IPS_LogMessage('RaspBee', "light,sensor,plug, group event missed: ".$event." -> ".$d);
						break;
				}
			
			break;
			
			case "scene-called": 
				break;
				$no=$data['scid'];
				$group_no=$data['gid'];
				$event=$data['r'];
				switch ($event)	{
					case "scenes":
						break;
					default:
						IPS_LogMessage('RaspBee', "Scene event missed: ".$event." -> ".$d);
						break;
					
				}
						
			break;
			
			default:
				IPS_LogMessage('RaspBee', "topic missed: ".$topic." -> ".$d);
				break;
		}
	return;
	}	
    protected function check_plug_light($bri,$type){
			
		if (!$bri)return("plug");
		$pos=strpos($type,"plug");
		if ($pos)return("plug"); 			
		return("light");
	}

protected function get_powersensor($searchid,$val){	
		$lights = $this->Request('/lights');

		$searchid = substr($searchid, 0, 26);	
		if ($lights) {	
			foreach ($lights as $lightId => $light) {
				$bri = (string)@$light->state->bri;
				$uniqueId = (string)$light->uniqueid;
				$uni = substr($uniqueId, 0, 26);	
				$type=(string)@$light->type;
				$plug_light=$this->check_plug_light($bri,$type);
				if($plug_light=="light")continue;
				if($uni == $searchid){
					$searchuni=$uni;
					break;
				}	
			}
		}	
		if($searchuni){

			$lights = $this->Request('/sensors');
			$devices_p=array();
			$devices_p=json_decode(D_SENSOR,true);
			
			if ($lights) {	
				$Sensor=array();
				foreach ($lights as $lightId => $light) {
					$uniqueId = (string)$light->uniqueid;
					$name = (string)$light->name;
					$uni = substr($uniqueId, 0, 26);	
					$sub_state=@$light->state;
					if($searchuni == $uni){
						if(array_key_exists($val, $sub_state)){
							$Sensor[$val]=$light->state->$val;
							foreach ($devices_p as $deviceId => $d) {
								$value=$devices_p[$deviceId];
								if($value['original']== $val){							
									if(@(float)$value['mult_factor'] >0){
										@$Sensor[$val]=@$Sensor[$val]*@$value['mult_factor'];
									}
								}
							}
							break;
						}
					}
				}
			}		
			return($Sensor);
		}
		return false;
	 }

 // ugly but working 
 //no or unique_id depending in firmware
	 public function find_sensor_instance($no,$uni){

		if(!$uni){
			$sensorlist = json_decode($this->GetBuffer("RB"));
			
			if($sensorlist){
				foreach ($sensorlist as $g =>$sensor) {
					
					if($no==$sensor->Id){
					
						if(IPS_InstanceExists($sensor->InstanceID))return($sensor->InstanceID);
						break;
					}
				}
			}
		
			$this->init_List();	
		
			$sensorlist = json_decode($this->GetBuffer("RB"));
			
			if($sensorlist){
				foreach ($sensorlist as $g =>$sensor) {
					
					if($no==$sensor->Id){
					
						if(IPS_InstanceExists($sensor->InstanceID))return($sensor->InstanceID);
						break;
					}
				}
			}
			return;
		}else{
			$uni = substr($uni, 0, 26);	
			$InstanceIDListe = IPS_GetInstanceListByModuleID($this->SensorGuid());
			foreach ($InstanceIDListe as $InstanceID) {
				
				$ParentID = IPS_GetInstance($InstanceID);
				if ($ParentID == 0)continue;
				$id =@IPS_GetProperty($InstanceID, 'UniqueId');
				
				if($id==$uni){
				
					return($InstanceID);
				}
			}
			return;	
		}
	 }


	 public function find_switch_instance($no,$uni){

			$uni = substr($uni, 0, 26);	
			$InstanceIDListe = IPS_GetInstanceListByModuleID($this->SwitchGuid());
			foreach ($InstanceIDListe as $InstanceID) {
				
				$ParentID = IPS_GetInstance($InstanceID);
				if ($ParentID == 0)continue;
				$id =@IPS_GetProperty($InstanceID, 'UniqueId');
				
				if($id==$uni){
				
					return($InstanceID);
				}
			}
			
			return;	
		
	 }
	 

	//no or unique_id depending in firmware
	protected function find_light_instance($no,$uni){

		$InstanceIDListe = IPS_GetInstanceListByModuleID($this->LightGuid());
		
		foreach ($InstanceIDListe as $InstanceID) {
			
			$ParentID = IPS_GetInstance($InstanceID);
			if ($ParentID == 0)continue;
			$id =@IPS_GetProperty($InstanceID, 'LightId');
			$uniqueid =@IPS_GetProperty($InstanceID, 'UniqueId');
			
			$uniqueid = substr($uniqueid, 0, 26);	
			$uni = substr($uni, 0, 26);	
			
			if(!$uni && $id==$no){
				return($InstanceID);
			}elseif($uni && $uniqueid==$uni){
				return($InstanceID);
			}
		}
		$InstanceIDListe = IPS_GetInstanceListByModuleID($this->PlugGuid());
		foreach ($InstanceIDListe as $InstanceID) {
			
			$ParentID = IPS_GetInstance($InstanceID);
			if ($ParentID == 0)continue;
			$id =@IPS_GetProperty($InstanceID, 'PlugId');
			$uniqueid =@IPS_GetProperty($InstanceID, 'UniqueId');
			
			$uniqueid = substr($uniqueid, 0, 26);	
			$uni = substr($uni, 0, 26);	
			
			if(!$uni && $id==$no){
				return($InstanceID);
			}elseif($uni && $uniqueid==$uni){
				return($InstanceID);
			}
		}
		
		return(false);
	}  
	
	//public function find_group_instance($no){
	protected function find_group_instance($no){

		$InstanceIDListe = IPS_GetInstanceListByModuleID($this->GroupGuid());
		foreach ($InstanceIDListe as $InstanceID) {
			$ParentID = IPS_GetInstance($InstanceID);
            if ($ParentID == 0)continue;
			$id =@IPS_GetProperty($InstanceID, 'GroupId');
			if($id==$no)return($InstanceID);
		}
		return(false);
	}  


  
	//public function find_scene_instance($no,$group_no){
	protected function find_scene_instance($no,$group_no){

		$InstanceIDListe = IPS_GetInstanceListByModuleID($this->SceneGuid());
		foreach ($InstanceIDListe as $InstanceID) {
			
			$ParentID = IPS_GetInstance($InstanceID);
            if ($ParentID == 0)continue;
			$gid =@IPS_GetProperty($InstanceID, 'GroupId');
			$sid =@IPS_GetProperty($InstanceID, 'Id');
			if($sid==$no && $gid==$group_no)return($InstanceID);
		}
		return(false);
} 

 
//ENDE  *********************************************
//ws://192.168.178.40:8088/websocket/

}

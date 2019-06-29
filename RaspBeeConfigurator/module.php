<?php


require_once __DIR__ . "/../libs/Helper.php";
require_once __DIR__ . "/../RaspBeeBridge/module.php";
error_reporting(2);
error_reporting(E_ERROR & ~ E_PARSE);
//error_reporting(E_ALL);
//ws://192.168.178.40:8088/websocket/

class RaspBeeConfigurator extends  IPSModule	

{
    public $count_devices = array(
                'lights' => 0,
				'plugs' => 0,
				'sensors' => 0,
                'groups' => 0,
                'scenes' => 0,				
                'switches' => 0,								
				'new' => 0
    );
	public $Liste = array();

    public function Create(){
        parent::Create();
		
        $this->RegisterPropertyInteger('LightsCategory',0);
		$this->RegisterPropertyInteger('PlugsCategory', 0);
        $this->RegisterPropertyInteger('GroupsCategory', 0);
        $this->RegisterPropertyInteger('SensorsCategory', 0);
		$this->RegisterPropertyInteger('ScenesCategory', 0);		
		$this->RegisterPropertyInteger('SwitchesCategory', 0);		
		
		
		//set bridge as parent 
		$this->ConnectParent("{F49E6837-55BA-4362-B502-CAF32BAF1DBC}");
		
    }
	  
	  
    public function ApplyChanges(){
		$this->RegisterMessage(0, IPS_KERNELSTARTED);
        parent::ApplyChanges();
		
		//set bridge as parent 
		$this->ConnectParent("{F49E6837-55BA-4362-B502-CAF32BAF1DBC}");
        //$this->ValidateConfiguration();
    }
	
 	public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
		
		if($Message==IPS_KERNELSTARTED){
			//$this->SyncStates();
		}
	}

    private function ValidateConfiguration(){
		$MyParent = IPS_GetInstance($this->InstanceID)['ConnectionID'];
			 

		$host = @IPS_GetProperty($MyParent, 'Host');
		$port = @IPS_GetProperty($MyParent, 'Port');
		$user = @IPS_GetProperty($MyParent, 'User');
			
		if ($this->ReadPropertyInteger('LightsCategory') == 0 || $host == '' || $port == ''|| $user == '') {
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
			return false;
        }
       return true;
    }


	private function PlugGuid(){
        return '{FB468257-6AA8-4653-8C94-B8ABB7BEB736}';
    }

    private function LightGuid(){
        return '{B1426B84-13B4-4D76-BC3B-33869AE9EA1F}';
    }

    private function GroupGuid(){
        return '{272421BE-BB96-4082-ADA7-A642F3734E8D}';
    }

    private function SensorGuid(){
        return '{1051CA2C-7F9E-44D4-A47A-F923CD99C237}';
    }
    private function SceneGuid(){
        return '{D687D0DF-33FB-449A-BC66-7FDD1371E96C}';
    }
    private function SwitchGuid(){
        return '{8691D506-3B80-46AB-B04E-A4A42B0A38AE}';
    }

	
    public function GetConfigurationForm(){
	
		
		
		$newListe = array();
		
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);
		
		
		//light
		$this->Liste = $this->get_List($this->LightGuid(),$this->Liste);
		//plug
		$this->Liste = $this->get_List($this->PlugGuid(),$this->Liste);
		//sensor
		$this->Liste = $this->get_List($this->SensorGuid(),$this->Liste);
		//group
		$this->Liste = $this->get_List($this->GroupGuid(),$this->Liste);
		//scene
		$this->Liste = $this->get_List($this->SceneGuid(),$this->Liste);
		//switch
		$this->Liste = $this->get_List($this->SwitchGuid(),$this->Liste);


		//$this->neu=0;

		//light
		$this->Liste = $this->get_new_List($this->LightGuid(),$this->Liste,'/lights',"Light");
		// plug
		$this->Liste = $this->get_new_List($this->PlugGuid(),$this->Liste,'/lights',"Plug");
		//sensor
		$this->Liste = $this->get_new_List($this->SensorGuid(),$this->Liste,'/sensors',"Sensor");
		//group
		$this->Liste = $this->get_new_List($this->GroupGuid(),$this->Liste,'/groups',"Group");
		//scene
		$this->Liste = $this->get_new_List($this->SceneGuid(),$this->Liste,'/groups',"Scene");
		//switch
		$this->Liste = $this->get_new_List($this->SwitchGuid(),$this->Liste,'/sensors',"Switch");
		
		$a=sprintf($this->Translate("Lights: %d"), $this->count_devices[$this->LightGuid()]);
		$a=$a.sprintf($this->Translate("      Plugs: %d"), $this->count_devices[$this->PlugGuid()]);
		$a=$a.sprintf($this->Translate("      Groups: %d"), $this->count_devices[$this->GroupGuid()]);
		$a=$a.sprintf($this->Translate("      Sensors: %d"), $this->count_devices[$this->SensorGuid()]);
		$a=$a.sprintf($this->Translate("      Scenes: %d"), $this->count_devices[$this->SceneGuid()]);
		$a=$a.sprintf($this->Translate("      Switches: %d"), $this->count_devices[$this->SwitchGuid()]);		
		$a=$a.sprintf($this->Translate("                      Neue Geräte: %d"), $this->count_devices['new']);

		$data['actions'][0]['label'] = $a;

		$MyParent = IPS_GetInstance($this->InstanceID)['ConnectionID'];
		$host = @IPS_GetProperty($MyParent, 'Host');
		$port = @IPS_GetProperty($MyParent, 'Port');

		$data['elements'][0]['label'] = $host.":".$port;

		$data['actions'][1]['values'] = array_merge($data['actions'][1]['values'], $this->Liste);

		return json_encode($data);
    }
	
	public function get_List($guid,$Liste){
		
		$InstanceIDListe = IPS_GetInstanceListByModuleID($guid);
		$anz=0;
		$this->count_devices[$guid]=0;
		$Plug=array();
		
		foreach ($InstanceIDListe as $InstanceID) {
			
			$ParentID = IPS_GetInstance($InstanceID);
            if ($ParentID == 0) {
                continue;
            }
			//$anz++;
			$this->count_devices[$guid]++;
			//neu
			$dev_name=IPS_GetName(IPS_GetParent($InstanceID));
			$unique_id =@IPS_GetProperty($InstanceID, 'UniqueId');
			
			//bei group id ist unique
			if($guid==$this->GroupGuid())$unique_id =@IPS_GetProperty($InstanceID, 'Id');
			if($guid==$this->SceneGuid())$unique_id =@IPS_GetProperty($InstanceID, 'SceneId');
			
			$on = @GetValue(IPS_GetObjectIDByIdent ("ON",$InstanceID));
			$reachable = @GetValue(IPS_GetObjectIDByIdent ("REACHABLE",$InstanceID));
		
			if($guid==$this->SensorGuid()|| $guid==$this->SwitchGuid()|| $guid==$this->SceneGuid()){
				$reachable="-";
				$on="-";
			}
			if($guid==$this->GroupGuid())$reachable="-";

            $Plug = array(
                'InstanceID' => $InstanceID,
				'Aktiv' => true,
				'DeviceUid' => $unique_id,
                'DeviceOn' => $on,
				'DeviceReach' => $reachable,
                'DeviceType' => $dev_name,
                'Name' => IPS_GetName($InstanceID)
            );
			
            if ($unique_id === false) {
                $Plug["rowColor"] = "#ff0000";		//rot
            } else {
                $Plug['rowColor'] = "#00ff00";  //grün
            };
            $Liste[] = $Plug;
        }
	
	return ($Liste);
	}
	
    protected function GetBridge_Conf(){
        $instance = IPS_GetInstance($this->InstanceID);
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }


	public function get_new_List($guid,$Liste,$request,$tname){

		$lights = $this->Request($request);
		$Plug = array();
		
		if ($lights) {	
			foreach ($lights as $lightId => $light) {
				if($guid==$this->SceneGuid()){
					$scenes=$light->scenes;
					if($scenes){
						$scenes=$light->scenes;
						foreach ($scenes as $sceneId => $scene) {
							$name = utf8_decode((string)$scene->name);
							$Id = utf8_decode((string)$scene->id);
							$groupid = utf8_decode((string)$light->id);
							$uniqueId=$groupid."-".$Id;
							$found=$this->searchArray($guid, "SceneId", $uniqueId);
							$on = "-";
							$reach="-";

							if (!$found){
								$Plug = array(
									'InstanceID' => 0,
									'Aktiv' => false,
									'DeviceUid' => $uniqueId,
									'DeviceOn' => $on,
									'DeviceReach' => $reach,				
									'DeviceType' => $tname,
									'Name' => $name
								);
								$this->count_devices['new']++;
								$Liste[]=$Plug;
							}
						}
					}
				}else{
					if(array_key_exists('uniqueid', $light))$uniqueId = (string)$light->uniqueid;		
					if(array_key_exists('uniqueid', $light))$uniqueId_org = (string)$light->uniqueid;		
					if(array_key_exists('id', $light))$Id = (string)$light->id;
					if(array_key_exists('name', $light))$name = (string)$light->name;
					if(array_key_exists('type', $light))$type = (string)$light->type;
					
					$bri = (string)@$light->state->bri;
					$type=(string)@$light->type;
					$plug_light=$this->check_plug_light($bri,$type);

					
					if($guid==$this->LightGuid()){
						$bri = (string)@$light->state->bri;
						$on = (string)$light->state->on;
						$reach = (string)$light->state->reachable;
						if($plug_light=="plug")continue;

					}
					if($guid==$this->PlugGuid()){
						$bri = (string)@$light->state->bri;
						$on = (string)$light->state->on;
						$reach = (string)$light->state->reachable;
						if($plug_light=="light")continue;

					}
					if($guid==$this->GroupGuid()){				
						$on = (string)$light->action->on;			
						$reach='-';
						$ok=$this->check_correct_group($type);
						if(!$ok)continue;
					}
					
		//also for power	
					if($guid==$this->SensorGuid()){
						
						$special=$this->check_special_types($type);
						
						if($special)continue;
						
						/*if($type=="CLIPGenericStatus")continue;
						if($type == "ZHASwitch")continue;
						if($type == "ZHAConsumption")continue;
						if($type == "ZHAPower")continue;
						*/
						$uniqueId = substr($uniqueId, 0, 26);
						$on = "-";
						$reach="-";
						$ret=$this->check_new_dup($uniqueId,$Liste);
						if($ret==1)continue;
					}
					if($guid==$this->SwitchGuid()){
						if($type!="ZHASwitch")continue;
						$uniqueId = substr($uniqueId, 0, 26);
						$on = "-";
						$reach="-";
					}

					if($guid!=$this->GroupGuid() && $guid!=$this->SceneGuid())$found=$this->searchArray($guid, "UniqueId", $uniqueId);
					if($guid==$this->GroupGuid())$found=$this->searchArray($guid, "Id", $Id);
					if($guid==$this->GroupGuid())$uniqueId=$Id;
					
					
					if (!$found){
						
						if($on == 1  && $on != '-'){
							$on=true;
						}elseif($on == 0 && $on != '-'){
							$on=false;		
						}else{
							$on='-';		
						}	
						
						if($reach == 1 && $reach != '-'){
							$reach=true;
						}elseif($reach == 0 && $reach != '-'){
							$reach=false;		
						}else{
							$reach='-';		
						}
						
						$Plug = array(
							'InstanceID' => 0,
							'Aktiv' => false,
							'DeviceUid' => $uniqueId,
							'DeviceOn' => $on,
							'DeviceReach' => $reach,				
							'DeviceType' => $tname,
							'Name' => $name
						);
						$this->count_devices['new']++;
						$Liste[]=$Plug;
					}
				}
			}
			return($Liste);
		}
	}



	public function check_new_dup($uniqueId,$g_data){
		$err=0;
		
		foreach ($g_data as $g_dataId => $data) {
		
			$uni = $data["DeviceUid"];
			if($uni===$uniqueId){
				$err=1;
				break;
			}
		}	
		return($err);

	}
	
	public function searchArray($guid,$key,$value) {   
			
			$InstanceIDListe = IPS_GetInstanceListByModuleID($guid);
			
			foreach ($InstanceIDListe as $InstanceID) {
				$unique_id =@IPS_GetProperty($InstanceID, $key);
				
				if ($unique_id == $value){
					return (true);       
				}
			} 
			return(false);
	}


  
    protected function Request(string $path, array $data = null){

		$MyParent = IPS_GetInstance($this->InstanceID)['ConnectionID'];
		$host = @IPS_GetProperty($MyParent, 'Host');
		$port = @IPS_GetProperty($MyParent, 'Port');
		$user = @IPS_GetProperty($MyParent, 'User');
		
		$client = curl_init();
        curl_setopt($client, CURLOPT_URL, "http://$host:$port/api/$user$path");

		$d=json_encode($data);
		
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

	public function configuration($Devices,$type){
		
		$Liste = array();
		switch($type) {
			case 'create':
				if (($Devices["DeviceUid"] == "") or ($Devices["InstanceID"] > 0)){
					echo "No new device selected";
					return;
				}
			$ret=$this->create_instance($Devices,"lights");

			if ($ret == 1)echo "Error. Instance exists ".$Devices["Name"];
			if ($ret == 2)echo "Error. Instance not created ".$Devices["Name"];
			if ($ret == 0)echo "OK. Instance created for ".$Devices["Name"];
            break;
			case 'delete':
			if ($Devices["DeviceUid"] == "" || $Devices["InstanceID"] <= 0){
				echo 'No device for deletion selected!';
				return;
			}
			$ret=$this->delete_instance("lights",$Devices);
			if ($ret == 1)echo "Error. Instance not exists ".$Devices["Name"];
			if ($ret == 2)echo "Error. Instance not deleted ".$Devices["Name"];
			if ($ret == 0)echo "OK. Instance deleted for ".$Devices["Name"];
			break;
			case 'check':
				print_r($Devices);
			break;
			case 'lights':
				$Liste = $this->get_new_List($this->LightGuid(),$Liste,'/lights',"Light");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"lights");
				}
				echo "Light Instances created ";
				break;
			case 'plugs':
				$Liste = $this->get_new_List($this->PlugGuid(),$Liste,'/lights',"Plug");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"plugs");
				}
				echo "Plug Instances created ";
				break;
			case 'groups':
				$Liste = $this->get_new_List($this->GroupGuid(),$Liste,'/groups',"Group");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"groups");
				}
				echo "Group Instances created ";
				break;
			case 'sensors':
				$Liste = $this->get_new_List($this->SensorGuid(),$Liste,'/sensors',"Sensor");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"sensors");
				}
				echo "Sensor Instances created ";
				break;
			case 'switches':
				$Liste = $this->get_new_List($this->SwitchGuid(),$Liste,'/sensors',"Switch");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"switches");
				}
				echo "Switches Instances created ";
				break;
			case 'scenes':
				$Liste = $this->get_new_List($this->SceneGuid(),$Liste,'/groups',"Scene");			
				foreach ($Liste as $Id => $Plugs) {
					$this->create_instance_type($Plugs,"scenes");
				}
				echo "Scene Instances created ";
				break;
				
		}
	}
 
 	public function delete_all(){

		$Liste = array();
 		//light
		$Liste = $this->get_List($this->LightGuid(),$Liste);
		//plug
		$Liste = $this->get_List($this->PlugGuid(),$Liste);
		//sensor
		$Liste = $this->get_List($this->SensorGuid(),$Liste);
		//group
		$Liste = $this->get_List($this->GroupGuid(),$Liste);
		//scene
		$Liste = $this->get_List($this->SceneGuid(),$Liste);
		//switch
		$Liste = $this->get_List($this->SwitchGuid(),$Liste);

		foreach ($Liste as $Plugs) {
			$this->delete_instance(null,$Plugs);
		}
		echo "Devices deleted";
		return;
	}
 
	public function delete_instance($what,$Plugs){
		$err=1;
				
		
		$deviceId = $Plugs["InstanceID"];
		
		if(!@IPS_InstanceExists($deviceId))return($err);
		
		$r=IPS_GetChildrenIDs ($deviceId);

		if ($deviceId > 0) {
			foreach ($r as $rid) {
				$type=IPS_GetObject ($rid );
				if($type["ObjectType"]==2)IPS_DeleteVariable($rid);//var
				if($type["ObjectType"]==3)IPS_DeleteScript($rid,false);//script
				if($type["ObjectType"]==4)IPS_DeleteEvent($rid);//ereignis
				if($type["ObjectType"]==6)IPS_DeleteLink($rid);//link
				if($type["ObjectType"]==1)IPS_DeleteInstance($rid);//instanz
			}
			
		
			$t=IPS_DeleteInstance ($deviceId );

			if($t){$err=0;
			//ist gelöscht !!!!kein apply changes da instanz nichgt mehr da
			//if($deviceId)IPS_ApplyChanges($deviceId);
			}
		}else{
			$err=1;
		}
		return($err);
	}	
	
    public function GetDeviceByUniqueIdLight(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->LightGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
	
	public function GetDeviceByUniqueIdPlug(string $uniqueId){
		$deviceIds = IPS_GetInstanceListByModuleID($this->PlugGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }

    public function GetDeviceByUniqueIdSensor(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SensorGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
    public function GetDeviceByUniqueIdSwitch(string $uniqueId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SwitchGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'UniqueId') == $uniqueId) {
                return $deviceId;
            }
        }
    }
	
    public function GetDeviceByUniqueIdScene(string $sceneId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->SceneGuid());
        foreach ($deviceIds as $deviceId) {
			if (@IPS_GetProperty($deviceId, 'SceneId') == $sceneId && $this->InstanceID == IPS_GetInstance($deviceId)['ConnectionID']) {				
                return $deviceId;
            }
        }
    }

    public function GetDeviceByGroupId(int $groupId){
        $deviceIds = IPS_GetInstanceListByModuleID($this->GroupGuid());
        foreach ($deviceIds as $deviceId) {
            if (@IPS_GetProperty($deviceId, 'GroupId') == $groupId && $this->InstanceID == IPS_GetInstance($deviceId)['ConnectionID']) {
                return $deviceId;
            }
        }
    }
	

	public function create_instance($Plugs){
        $type=$Plugs["DeviceType"];
		
		if($type=="Light")$err=$this->create_instance_type($Plugs,"lights");
		if($type=="Plug")$err=$this->create_instance_type($Plugs,"plugs");
		if($type=="Group")$err=$this->create_instance_type($Plugs,"groups");
		if($type=="Sensor")$err=$this->create_instance_type($Plugs,"sensors");
		if($type=="Switch")$err=$this->create_instance_type($Plugs,"switches");
		if($type=="Scene")$err=$this->create_instance_type($Plugs,"scenes");
		return($err);
	}	
	
	protected function set_ident($deviceId, $name){
		@IPS_SetIdent($deviceId, preg_replace('/[^-a-z-A-Z0-9_]+/', '', $name));
	}
	
	public function create_instance_type($Plugs,$device){

		$err=2;
		switch($device) {
		case "lights":
			
			$lights = $this->Request('/lights');
			$err=2;
			if ($lights) {
				$lightsCategoryId = $this->ReadPropertyInteger('LightsCategory');
				
				if($lightsCategoryId <=0){
					IPS_LogMessage('RaspBee', "Keine Lights Category angelegt ");
					return(2);
				}
				
				foreach ($lights as $lightId => $light) {
					$name = utf8_decode((string)$light->name);
					$uniqueId = (string)$light->uniqueid;
					
					$bri = (string)@$light->state->bri;
					$type=(string)@$light->type;
					$plug_light=$this->check_plug_light($bri,$type);
					if($plug_light=="plug")continue;
					
					if($uniqueId == $Plugs["DeviceUid"]){
				
							$deviceId = $this->GetDeviceByUniqueIdLight($Plugs["DeviceUid"]);
						
							if ($deviceId == 0) {
								$deviceId = IPS_CreateInstance($this->LightGuid());
								IPS_SetProperty($deviceId, 'UniqueId', $Plugs["DeviceUid"]);
								 $err=0;//ok
							}else{
								$err=1;//existiert
								break;
							}
							IPS_SetParent($deviceId, $lightsCategoryId);
							IPS_SetProperty($deviceId, 'LightId', (integer)$lightId);
							IPS_SetName($deviceId, $Plugs["Name"]);
							$this->set_ident($deviceId, $Plugs["Name"]);
						if($err==0){
							IPS_ApplyChanges($deviceId);
							RB_RequestData($deviceId);
						}
						break;
					}
				}
			}
			break;
		
		case "plugs":
		
			$lights = $this->Request('/lights');
			$err=2;
			if ($lights) {
				$plugsCategoryId = $this->ReadPropertyInteger('PlugsCategory');
				if($plugsCategoryId <=0){
					IPS_LogMessage('RaspBee', "Keine Plugs Category angelegt ");
					return(2);
				}
				
				foreach ($lights as $lightId => $light) {
					$name = utf8_decode((string)$light->name);
					$uniqueId = (string)$light->uniqueid;
					
					$bri = (string)@$light->state->bri;
					$type=(string)@$light->type;
					$plug_light=$this->check_plug_light($bri,$type);
					if($plug_light=="light")continue;
					
					$uniqueId = substr($uniqueId, 0, 26);
					$PluguniqueId = substr($uniqueId, 0, 26);
					
					if($uniqueId == $Plugs["DeviceUid"]){
				
						$deviceId = $this->GetDeviceByUniqueIdPlug($Plugs["DeviceUid"]);
					
						if ($deviceId == 0) {
					
							$deviceId = IPS_CreateInstance($this->PlugGuid());
					
							IPS_SetProperty($deviceId, 'UniqueId', $Plugs["DeviceUid"]);
					
							$err=0;//ok
						}else{
					
							$err=1;//existiert
							break;
						}
						IPS_SetParent($deviceId, $plugsCategoryId);
						IPS_SetProperty($deviceId, 'PlugId', (integer)$lightId);
						IPS_SetName($deviceId, $Plugs["Name"]);
					
						$this->set_ident($deviceId, $Plugs["Name"]);
						if($err==0){
							IPS_ApplyChanges($deviceId);
							RB_RequestData($deviceId);
						}	
					
						break;
					}
					
				}
			}
		break;

		case "sensors":
			$lights = $this->Request('/sensors');
			$err=2;

			if ($lights) {
				
				$sensorsCategoryId = $this->ReadPropertyInteger('SensorsCategory');
				if($sensorsCategoryId <=0){
					IPS_LogMessage('RaspBee', "Keine Sensors Category angelegt ");
					return(2);
				}
				
				$sensors=array();
				$sensors=json_decode(SENSORS,true);
				
				foreach ($lights as $lightId => $light) {
					$name = utf8_decode((string)$light->name);
					$manufacturername = utf8_decode((string)$light->manufacturername);
					$modelid = utf8_decode((string)$light->modelid);
					$uniqueId_org = (string)$light->uniqueid;
					$uniqueId = (string)$light->uniqueid;
					$type = (string)$light->type;
					$uniqueId = substr($uniqueId, 0, 26);

					
					
					$special=$this->check_special_types($type);
					if($special)continue;
					
					/*if($type=="CLIPGenericStatus")continue;
					if($type == "ZHAPower")continue;//zusammen mit plug
					if($type == "ZHAConsumption")continue;//zusammen mit plug
					if($type == "ZHASwitch")continue;//eigenes Device
					*/
					
					$sensor_type=0;
					if($uniqueId == $Plugs["DeviceUid"]){
							$deviceId = $this->GetDeviceByUniqueIdSensor($Plugs["DeviceUid"]);
							if ($deviceId == 0) {
								
								//den presence sensor nehmen für namen
								//$combined=$this->get_combined_sensor($uniqueId,"ZHAPresence");	
								//if($combined==1 && $type !="ZHAPresence")continue;
								
								$deviceId = IPS_CreateInstance($this->SensorGuid());
								IPS_SetProperty($deviceId, 'UniqueId', $Plugs["DeviceUid"]);
								IPS_SetName($deviceId, $Plugs["Name"]);
								$this->set_ident($deviceId, $Plugs["Name"]);
								IPS_SetProperty($deviceId, 'SensorId', (integer)$lightId);											
								IPS_SetParent($deviceId, $sensorsCategoryId);						
								$err=0;//ok
								//get_list of combined sensors								
								$lights_x=$this->get_sensors($Plugs["DeviceUid"]);
								$list="";
								foreach ($lights_x as $lightId_x => $light_x) {		
									if($list!="")$list=$list.",";
									if($light_x['Id']!=$lightId){
										$list=$list."(".$light_x['Id'].")";
									}else{
										$list=$list.$light_x['Id'];
									}
								}
								IPS_SetProperty($deviceId, 'SensorId_all', $list);											
							}
							IPS_ApplyChanges($deviceId);
							RB_RequestData($deviceId);
					}
				}

				
			}
			break;
		case "switches":
			$lights = $this->Request('/sensors');
			$err=2;

			if ($lights) {
				
				$switchesCategoryId = $this->ReadPropertyInteger('SwitchesCategory');
				if($switchesCategoryId <=0){
					IPS_LogMessage('RaspBee', "Keine Switches Category angelegt ");
					return(2);
				}
				
				foreach ($lights as $lightId => $light) {
					$name = utf8_decode((string)$light->name);
					$uniqueId_org = (string)$light->uniqueid;
					$uniqueId = (string)$light->uniqueid;
					$type = (string)$light->type;
					$uniqueId = substr($uniqueId, 0, 26);

					if($type != "ZHASwitch")continue;
					
					if($uniqueId == $Plugs["DeviceUid"]){
						$deviceId = $this->GetDeviceByUniqueIdSwitch($Plugs["DeviceUid"]);
						
						if ($deviceId == 0) {
							$deviceId = IPS_CreateInstance($this->SwitchGuid());
							IPS_SetProperty($deviceId, 'UniqueId', $Plugs["DeviceUid"]);
							$err=0;//ok
						}else{
							$err=1	;//ok
						}

						IPS_SetName($deviceId, $Plugs["Name"]);
						$this->set_ident($deviceId, $Plugs["Name"]);
						IPS_SetProperty($deviceId, 'SwitchId', (integer)$lightId);											
						IPS_SetParent($deviceId, $switchesCategoryId);						
						IPS_ApplyChanges($deviceId);
						RB_RequestData($deviceId);
							
						//no break because maybe more endpoints belonging to this sensor
						//break;
					}

				}
			}
			break;
		case "groups":
			$lights = $this->Request('/groups');
			$err=2;
			if ($lights) {
				$groupsCategoryId = $this->ReadPropertyInteger('GroupsCategory');
				if($groupsCategoryId <=0){
					IPS_LogMessage('RaspBee', "Keine Groups Category angelegt ");
					return(2);
				}
				
				foreach ($lights as $lightId => $light) {
					$name = utf8_decode((string)$light->name);
					$groupId=$lightId;
					$type = (string)$light->type;
					$uniqueId=$groupId;
					if($uniqueId == $Plugs["DeviceUid"]){
		
						$ok=$this->check_correct_group($type);

						if(!$ok)continue;
						
						$deviceId = $this->GetDeviceByGroupId($Plugs["DeviceUid"]);
						
						if ($deviceId == 0) {
							$deviceId = IPS_CreateInstance($this->GroupGuid());
							IPS_SetProperty($deviceId, 'GroupId', (integer)$groupId);
							IPS_SetProperty($deviceId, 'Id', (integer)$groupId);
							IPS_SetProperty($deviceId, 'GroupName', $name);
							$err=0;//ok
						}else{
							$err=1;//existiert
							break;
						}
						IPS_SetParent($deviceId, $groupsCategoryId);
						IPS_SetName($deviceId,$Plugs["Name"]);
						$this->set_ident($deviceId, $Plugs["Name"]);
						IPS_SetProperty($deviceId, 'GroupId', (integer)$groupId);
						IPS_SetProperty($deviceId, 'Id', (integer)$groupId);
						if($err==0){
							IPS_ApplyChanges($deviceId);
							RB_RequestData($deviceId);
						}
						break;
					}
				}		
			}
			break;
		case "scenes": 
			$lights = $this->Request('/groups');
			$err=2;
			if ($lights) {
				foreach ($lights as $lightId => $light) {
					$scenes=$light->scenes;
					$scenesCategoryId = $this->ReadPropertyInteger('ScenesCategory');
					if($scenesCategoryId <=0){
						IPS_LogMessage('RaspBee', "Keine Scenes Category angelegt ");
						return(2);
					}
					$type = (string)$light->type;

					if($type != "LightGroup")continue;
					
					if ($scenes) {
						foreach ($scenes as $sceneId => $scene) {
							$name = $scene->name;
							$id = $scene->id;
							$groupid = $light->id;
							$groupname = $light->name;
							$sceneId=$groupid."-".$id;
							
							$deviceId = $this->GetDeviceByUniqueIdScene($Plugs["DeviceUid"]);
							
							if($sceneId != $Plugs["DeviceUid"])continue;
							if($sceneId == $Plugs["DeviceUid"]){
								
								if ($deviceId == 0) {
									$deviceId = IPS_CreateInstance($this->SceneGuid());
									IPS_SetProperty($deviceId, 'GroupId', $groupid);
									IPS_SetProperty($deviceId, 'Group_Name', $groupname);
									IPS_SetProperty($deviceId, 'Id', $id);
									IPS_SetProperty($deviceId, 'SceneId', $sceneId);
									IPS_SetProperty($deviceId, 'SceneName', $name);
									$err=0;//ok
								}else{	
									$err=1;//existiert
									break;
								}
								
								IPS_SetParent($deviceId, $scenesCategoryId);
							
								IPS_SetName($deviceId,$name);
								$this->set_ident($deviceId, $name);
								IPS_SetProperty($deviceId, 'GroupId', $groupid);
								IPS_SetProperty($deviceId, 'Id', $id);
								IPS_SetProperty($deviceId, 'SceneId', $sceneId);
								IPS_SetProperty($deviceId, 'Group_Name', $groupname);
								IPS_SetProperty($deviceId, 'SceneName', $name);
								
								if($err==0){
									IPS_ApplyChanges($deviceId);
									RB_RequestData($deviceId);
								}
								break;		
							}
						}
					}
				}		
			}
			break;
		}	
		return($err);	
	}

	public function check_correct_group($type){
		if($type=="LightGroup")return(true);
		return(false);
	}
	public function check_correct_sensor($type){
	//	if($type=="CLIPGenericStatus")return(false);
		return(true);
	}
	
	
	
	
    /*
     * RB_SyncStates($bridgeId)
     * Abgleich des Status aller Lampen
     */
    public function SyncStates(){
		

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
//groups
        $groups = $this->Request('/groups');
        if ($groups) {
            foreach ($groups as $groupId => $group) {
                $deviceId = $this->GetDeviceByGroupId($groupId);
                if ($deviceId > 0) {
                    RB_ApplyData($deviceId, $group);
//scenes					
					$lights=$groups;
					foreach ($lights as $lightId => $light) {
						$scenes=$light->scenes;
						if ($scenes) {
							foreach ($scenes as $sceneId => $scene) {
								$id = utf8_decode((string)$scene->id);
								$groupid = utf8_decode((string)$light->id);
								$sceneId=$groupid."-".$id;
								$deviceId = $this->GetDeviceByUniqueIdScene($sceneId);
								if ($deviceId > 0) {
									RB_ApplyData($deviceId, $sceneId);
								}		
							}
						}
					}	
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
		echo "Status for Devices updated ";			
    }

    public function check_plug_light($bri,$type){
			
		$pos=strpos($type,"plug");
		if ($pos)return("plug"); 			
		$pos=strpos($type,"light");
		if ($pos)return("light"); 			
		if (!$bri)return("plug");
		return("light");
	}
	
    public function SyncDevices()
    {
        
		$Liste = array();		

		$Liste = $this->get_new_List($this->LightGuid(),$Liste,'/lights',"Light");
		$Liste = $this->get_new_List($this->PlugGuid(),$Liste,'/lights',"Plug");
		$Liste = $this->get_new_List($this->SensorGuid(),$Liste,'/sensors',"Sensor");
		$Liste = $this->get_new_List($this->SwitchGuid(),$Liste,'/sensors',"Switch");
		$Liste = $this->get_new_List($this->GroupGuid(),$Liste,'/groups',"Group");
		$Liste = $this->get_new_List($this->SceneGuid(),$Liste,'/groups',"Scene");
		
		foreach ($Liste as $Id => $Plugs) {

			if($Plugs["DeviceType"]=="Light")$this->create_instance_type($Plugs,"lights");
			if($Plugs["DeviceType"]=="Plug")$this->create_instance_type($Plugs,"plugs");
			if($Plugs["DeviceType"]=="Group")$this->create_instance_type($Plugs,"groups");
			if($Plugs["DeviceType"]=="Sensor")$this->create_instance_type($Plugs,"sensors");
			if($Plugs["DeviceType"]=="Switch")$this->create_instance_type($Plugs,"switches");
			if($Plugs["DeviceType"]=="Scene")$this->create_instance_type($Plugs,"scenes");

		}
		echo "Devices created ";
		
		return true;
	}

protected function get_sensors($searchid){
	
	$lights = $this->Request('/sensors', null);
	
	$Sensor_List = array();
	$Sensor = array();
	$searchuni=null;
	
	if ($lights) {	
		foreach ($lights as $lightId => $light) {
			$uniqueId = (string)$light->uniqueid;		
			$uni = substr($uniqueId, 0, 26);	
			if($uni == $searchid){
				$searchuni=$uni;
				break;
			}	
		}
		if($searchuni){
			foreach ($lights as $lightId => $light) {
				$uniqueId = (string)$light->uniqueid;		
				$type = $light->type;		
				$name = $light->name;		
				$manufacturername=@$light->manufacturername;
				$modelid=$light->modelid;
				$uni = substr($uniqueId, 0, 26);	
				if($searchuni == $uni){
					$Sensor = array(
						'Id' => $lightId,
						'name' =>$name,
						'uid_26' =>$uni,
						'unique_id' =>$uniqueId,					
						'modelid' =>$modelid,					
						'manufacturername'=>$manufacturername,
						'type' =>$type					
					);
					$Sensor_List[]=$Sensor;
				}
			}
		}		
	}	
	return($Sensor_List);
 }

protected function check_special_types($type){

 	$special_types=array();
	$special_types=json_decode(SPECIAL_TYPES,true);
	if (isset($special_types[$type])&& $special_types[$type]==1)return(true);
	return(false);
}
	
protected function get_combined_sensor($uni,$check_type){
	  
	  $found=0;
	  $Sensor_combined = array();
      $sensors = $this->Request('/sensors');
      if ($sensors) {
            foreach ($sensors as $sensorId => $sensor) {
					$uniqueId = (string)$sensor->uniqueid;
					$uniqueId = substr($uniqueId, 0, 26);
					$type = (string)$sensor->type;
					if($uni === $uniqueId){
						$found++;		
						$Sensor = array(
							'type' =>$type					
						);
						$Sensor_combined[]=$Sensor;
					}
			}
	  }
	  if($found>1){
		foreach ($Sensor_combined as $comb => $combined_x) {		
			if($combined_x['type']==$check_type){
				return(1);
			}
		}
	  } 	
	return(0);
}
	

}
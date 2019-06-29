<?php

require_once __DIR__ . "/../libs/RaspBeeDevice.php";

class RaspBeeGroup extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();
        $this->RegisterPropertyInteger('GroupId', 0);
        $this->RegisterPropertyString('GroupName', '');
		$this->RegisterPropertyInteger('Id', 0);
        $this->RegisterPropertyInteger('LightFeatures', 0); // 0=HUE+CT, 1=HUE, 2=CT, 3=BRI, 4=Empty
		
		$lights=array();
		$lights=json_decode(D_GROUP,true);
		foreach ($lights as $lightId => $light) {
			$value=$lights[$lightId];
			$value=$value['choose'];
			$this->RegisterPropertyBoolean($lightId,$value);				
		}	

    }

    protected function BasePath()
    {
        $id = $this->ReadPropertyInteger('GroupId');
        return "/groups/$id";
    }


    public function GetConfigurationForm()
    {

		$newListe = array();
        $Liste = array();
		
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);
		
		$L = array('type' => 'ValidationTextBox','name' => 'GroupId','caption' => "Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "GroupName",'caption' => "Group");
		$Liste[]=$L;

		$lights_allowed=array();
		$lights_allowed=json_decode(D_GROUP,true);

		$lights_all = RaspBeeDevice::RequestData_Group();
		if ($lights_all) {	
			$lights=$lights_all->action;
			
			foreach ($lights as $lightId => $light) {
				$value=$lights->$lightId;

				//if($lightId == "xy")continue;
				
				$lightId=strtoupper ($lightId);

				foreach ($lights_allowed as $lightId_allowed => $light_allowed) {
					$value_allowed=$lights_allowed[$lightId_allowed];
					if($value_allowed['ident'] == $lightId){
						$L = array(
							'type' => 'CheckBox',
							'name' => strtoupper ($lightId),
							'caption' => $lightId."  [$value]"
						);
						$Liste[]=$L;
						break;
					}	
				}	
			}
			$lights_state=$lights_all->state;
			foreach ($lights_state as $lightId => $light) {
				$value=$lights_state->$lightId;
				if($lightId == "all_on")$lightId="ALL_ON";
				if($lightId == "any_on")$lightId="ANY_ON";
				$L = array(
						'type' => 'CheckBox',
						'name' => strtoupper ($lightId),
						'caption' => $lightId."  [$value]"
				);
				$Liste[]=$L;
			}
			
		}    

		$Liste1 =array(
			'elements' => $Liste
			);

		$data = array_merge($data, $Liste1);		

		
		$groupid = $this->BasePath();
		$lights = RB_Request($this->GetBridge_Conf_group(),$groupid,NULL);
		$lights=json_encode($lights,true);
		$lights=json_decode($lights,true);

		
		$Liste=array();
		
		$t=0;	
		$lights=$lights['lights'];
		foreach ($lights as $lightId =>$value) {			
			

			$lightsn = RB_Request($this->GetBridge_Conf_group(),'/lights/'.$value,NULL);
			$lightsn=json_encode($lightsn,true);
			$lightsn=json_decode($lightsn,true);
			$state=$lightsn['state'];
			//ist plug
			
			if(@$state['bri']){
				$bri=@$state['bri'];
				$ct=@$state['ct'];
				$colormode=@$state['colormode'];
			}else{
				$bri=null;
				$ct=null;
				$colormode=null;
			}
		
			$name=$lightsn['name'];
			//$id=$state['id'];
			$on=$state['on'];
			$reachable=$state['reachable'];
			$uniqueid=$lightsn['uniqueid'];
			
			
            $Plug = array(
                'light' => (int)$lightId,
				'bri' => $bri,
				'colormode' => $colormode,
                'ct' => $ct,
				'id' => $value,
				'name' => $name,
                'on' => $on,
                'reachable' => $reachable,
				'uniqueid' => $uniqueid
            );
			$Liste[] = $Plug;
			
		}			

		$data['actions'][3]['values'] = array_merge($data['actions'][3]['values'], $Liste);
	
	
	
	
	
		
		return json_encode($data);
    }
    protected function GetBridge_Conf_group()
    {
        $instance = IPS_GetInstance($this->InstanceID);
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }
	

}

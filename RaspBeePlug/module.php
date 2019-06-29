<?php

require_once __DIR__ . "/../libs/RaspBeeDevice.php";

class RaspBeePlug extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();
        $this->RegisterPropertyInteger('PlugId', 0);
        $this->RegisterPropertyString('Type', '');
        $this->RegisterPropertyInteger('LightFeatures', 0); // 0=RB+CT, 1=RB, 2=CT, 3=BRI
		$this->RegisterPropertyString('LightFeaturesName', ''); // 0=RB+CT, 1=RB, 2=CT, 3=BRI		
        $this->RegisterPropertyString('ModelId', '');
        $this->RegisterPropertyString('UniqueId', '');
        $this->RegisterPropertyString('ManufacturerName', '');
		
		$lights=array();
		$lights=json_decode(D_PLUG,true);
		foreach ($lights as $lightId => $light) {
			$value=$lights[$lightId];
			$value=$value['choose'];
			$this->RegisterPropertyBoolean($lightId,$value);				
		}	
		
    }

    protected function BasePath()
    {
        $id = $this->ReadPropertyInteger('PlugId');
        return "/lights/$id";
    }


    public function GetConfigurationForm()
    {
		
		$newListe = array();
        $Liste = array();
		
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);
		
		$L = array('type' => 'ValidationTextBox','name' => "UniqueId",'caption' => "Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "PlugId",'caption' => "Plug");

		$Liste[]=$L;

		$lights_allowed=array();
		$lights_allowed=json_decode(D_PLUG,true);

		$id = $this->ReadPropertyInteger('PlugId');
		$unique_id = $this->ReadPropertyString('UniqueId');
		$searchuni = substr($unique_id, 0, 26);	

		
		$lights = RaspBeeDevice::RequestData_Group();

		
		if ($lights) {	

			$lights=$lights->state;

			foreach ($lights as $lightId => $light) {
				$value=$lights->$lightId;
				
				$lightId=strtoupper ($lightId);

				foreach ($lights_allowed as $lightId_allowed => $light_allowed) {
					$value_allowed=$lights_allowed[$lightId_allowed];
					
					if($value_allowed['ident'] == $lightId){
						$L = array(
							'type' => 'CheckBox',
							'name' => $lightId,
							'caption' => $lightId."  [$value]"
						);
						$Liste[]=$L;
						break;
					}
				}
			}
			
						/*$L = array(
							'type' => 'CheckBox',
							'name' => 'TIMEROFF',
							'caption' => 'TIMEROFF'
						);
						$Liste[]=$L;
			*/
			
//****************************** get all sensors for this plug			
			$lights = RB_Request($this->GetBridge(), '/sensors', null);
			$devices_p=array();
			$devices_p=json_decode(D_SENSOR,true);
			
			if ($lights) {	
				foreach ($lights as $lightId => $light) {
					$uniqueId = (string)$light->uniqueid;
					$name = (string)$light->name;
					
					$uni = substr($uniqueId, 0, 26);	
					$sub_state=@$light->state;
					$sub_config=@$light->config;
					if($searchuni == $uni){
						foreach ($sub_state as $lightIdy => $lighty) {
							$value=$sub_state->$lightIdy;
							if($lightIdy=="lastupdated")continue;
							foreach ($devices_p as $deviceId => $d) {
								$newvalue=$devices_p[$deviceId];
								if($newvalue['original']== $lightIdy){							
									if(@(float)$newvalue['mult_factor'] >0)
										@$value=@$value*@$newvalue['mult_factor'];
								}
							}
							$lightIdy=strtoupper ($lightIdy);
							$L = array(
							'type' => 'CheckBox',
							'name' => $lightIdy,
							'caption' => $lightIdy."  [$value]"
							);
							$Liste[]=$L;
						}
					}
				}
			}
				
			

		}    
		$L = array(
				'type' => 'ValidationTextBox',
				'name' => "LightFeaturesName",
				'caption' => "Funktionen"
		);
		$Liste[]=$L;

		$L = array(
				'type' => 'ValidationTextBox',
				'name' => "ManufacturerName",
				'caption' => "Hersteller"
		);
		$Liste[]=$L;
		$L = array(
				'type' => 'ValidationTextBox',
				'name' => "ModelId",
				'caption' => "Model"
		);
		$Liste[]=$L;
		$L = array(
				'type' => 'ValidationTextBox',
				'name' => "Type",
				'caption' => "Type"
		);
		$Liste[]=$L;

		$Liste1 =array(
			'elements' => $Liste
			);

		$data = array_merge($data, $Liste1);		


		return json_encode($data);
    }
	
    public function check_plug_light($bri,$type){
			
		if (!$bri)return("plug");
		$pos=strpos($type,"plug");
		if ($pos)return("plug"); 			
		return("light");
	}


}

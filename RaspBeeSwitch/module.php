<?php

require_once __DIR__ . "/../libs/RaspBeeDevice.php";

class RaspBeeSwitch extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();
        $this->RegisterPropertyInteger('SwitchId', 0);
        $this->RegisterPropertyString('Type', '');
        $this->RegisterPropertyString('ModelId', '');
        $this->RegisterPropertyString('UniqueId', '');
        $this->RegisterPropertyString('ManufacturerName', '');	
		$lights=array();
		$lights=json_decode(D_SWITCH,true);
		foreach ($lights as $lightId => $light) {
			$value=$lights[$lightId];
			$value=$value['choose'];
			$this->RegisterPropertyBoolean($lightId,$value);				
		}	

    }

    protected function BasePath()
    {
        $id = $this->ReadPropertyInteger('SwitchId');
        return "/sensors/$id";
    }

    public function GetConfigurationForm()
    {
		
        
        $Liste = array();
		
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);

		$L = array('type' => 'ValidationTextBox','name' => 'UniqueId','caption' => "Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "SwitchId",'caption' => "Switch");

		$Liste[]=$L;
		$lights_allowed=array();
		$lights_allowed=json_decode(D_SWITCH,true);
		
		$lightsx = RaspBeeDevice::RequestData_Group();

	if ($lightsx) {	
		
			$lights=$lightsx->state;

			foreach ($lights as $lightId => $light) {
				
				$value=$lights->$lightId;
				
				$lightId=strtoupper ($lightId);
				
				if(array_search($lightId,  array_column($Liste, 'name')))continue;
				
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
			
			$lights=$lightsx->config;

			foreach ($lights as $lightId => $light) {

				$value=$lights->$lightId;

				$lightId=strtoupper ($lightId);
				
				if(array_search($lightId,  array_column($Liste, 'name')))continue;
				
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
	}    

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
	

}

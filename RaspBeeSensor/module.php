<?php

require_once __DIR__ . "/../libs/RaspBeeDevice.php";

class RaspBeeSensor extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();
        $this->RegisterPropertyInteger('SensorId', 0);
		$this->RegisterPropertyString('SensorId_all', '');
        $this->RegisterPropertyString('Type', '');
        $this->RegisterPropertyString('ModelId', '');
        $this->RegisterPropertyString('UniqueId', '');
        $this->RegisterPropertyString('ManufacturerName', '');	
		$this->RegisterPropertyString('PresenceId','');					
		$lights=array();
		$lights=json_decode(D_SENSOR,true);
		foreach ($lights as $lightId => $light) {
			$value=$lights[$lightId];
			$value=$value['choose'];
			$this->RegisterPropertyBoolean($lightId,$value);				
		}	

    }

    protected function BasePath()
    {
        $id = $this->ReadPropertyInteger('SensorId');
        return "/sensors/$id";
    }
    protected function BaseId()
    {
        $id = $this->ReadPropertyInteger('SensorId');
        return $id;
    }
    protected function Base()
    {
        $id = $this->ReadPropertyInteger('SensorId');
		return "/sensors/";
    }

    public function GetConfigurationForm()
    {
		
        
        $Liste = array();
		
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);

		$L = array('type' => 'ValidationTextBox','name' => 'UniqueId','caption' => "Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "SensorId_all",'caption' => "Sensor");
		
		$Liste[]=$L;
		
		$lights_allowed=array();
		$lights_allowed=json_decode(D_SENSOR,true);
		
		$lightsx = RaspBeeDevice::RequestData_Group();
	
	if ($lightsx) {	
	
		for($r=0;$r<=2;$r++){
		//STATE
			$lights=@$lightsx[$r]->state;
			if($lights){
				foreach ($lights as $lightId => $light) {
					
					$value=$lights->$lightId;
					$lightId=strtoupper ($lightId);
										
					if(array_search($lightId,  array_column($Liste, 'name')))continue;
					
					foreach ($lights_allowed as $lightId_allowed => $light_allowed) {
						$value_allowed=$lights_allowed[$lightId_allowed];
						
						if($value_allowed['ident'] == $lightId){
							
							if(@(float)$value_allowed['mult_factor'] >0 && isset($value)){
								$value=$value*$value_allowed['mult_factor'];
							}
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
		//CONFIG	
				$lights=$lightsx[$r]->config;

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

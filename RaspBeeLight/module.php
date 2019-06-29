<?php




require_once __DIR__ . "/../libs/Helper.php";
require_once __DIR__ . "/../libs/RaspBeeDevice.php";

class RaspBeeLight extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();

		$this->RegisterPropertyInteger('LightId', 0);
        $this->RegisterPropertyString('Type', '');
        $this->RegisterPropertyInteger('LightFeatures', 0); // 0=RB+CT, 1=RB, 2=CT, 3=BRI
        $this->RegisterPropertyString('LightFeaturesName', ''); // 0=RB+CT, 1=RB, 2=CT, 3=BRI
        $this->RegisterPropertyString('ModelId', '');
        $this->RegisterPropertyString('UniqueId', '');		
        $this->RegisterPropertyString('ManufacturerName', '');		
		
		$lights=array();
		$lights=json_decode(D_LIGHT,true);
		foreach ($lights as $lightId => $light) {
			$value=$lights[$lightId];
			$value=$value['choose'];
			$this->RegisterPropertyBoolean($lightId,$value);				
		}	

    }

    protected function BasePath()
    {
        $id = $this->ReadPropertyInteger('LightId');
        return "/lights/$id";
    }
	
    public function GetConfigurationForm()
    {
		
		$newListe = array();
        $Liste = array();
		$Listex = array();
		$Plugs = array();
		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);
		
		$L = array('type' => 'ValidationTextBox','name' => "UniqueId",'caption' => "Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "LightId",'caption' => "Lamp");
		$Liste[]=$L;

		$lights_allowed=array();
		$lights_allowed=json_decode(D_LIGHT,true);

		$lights = RaspBeeDevice::RequestData_Group();
		
		if ($lights) {	

			$lights=$lights->state;
		
			foreach ($lights as $lightId => $light) {

				$value=$lights->$lightId;

				$Plugs['id']= $this->ReadPropertyInteger('LightId');
				$Plugs[$lightId]= $value;
				$lightId=strtoupper ($lightId);
				
				//für Änderung / im Moment rausgenommen
				/*if($lightId == "XY"){
					$x=$value[0];
					$y=$value[1];
					$Plugs['x']= $x;
					$Plugs['y']= $y;
					continue;
				}*/

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
			//für Änderung / im Moment rausgenommen
			//$Listex[] = $Plugs;		
		
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
	
	
	//$data['actions'][3]['values'] = array_merge($data['actions'][3]['values'], $Listex);
	
		return json_encode($data);
    }
	
	
	
}

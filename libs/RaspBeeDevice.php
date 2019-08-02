<?php

require_once __DIR__ . "/Helper.php";
require_once __DIR__ . "/RaspBeeMisc.php";
error_reporting(2);
error_reporting(E_ERROR & ~ E_PARSE);
//error_reporting(E_ALL);
abstract class RaspBeeDevice extends IPSModule
{
    

    public function __construct($InstanceID){
        parent::__construct($InstanceID);
    }

    public function Create(){
		
        if (!IPS_VariableProfileExists('Current.RaspBee')) {
            IPS_CreateVariableProfile('Current.RaspBee', 2);
        }
        IPS_SetVariableProfileDigits('Current.RaspBee', 2);
        IPS_SetVariableProfileIcon('Current.RaspBee', 'Electricity');
        IPS_SetVariableProfileText('Current.RaspBee', '', ' A');

        if (!IPS_VariableProfileExists('Consumption.RaspBee')) {
            IPS_CreateVariableProfile('Consumption.RaspBee', 2);
        }
        IPS_SetVariableProfileDigits('Consumption.RaspBee', 2);
        IPS_SetVariableProfileIcon('Consumption.RaspBee', 'Electricity');
        IPS_SetVariableProfileText('Consumption.RaspBee', '', ' kWh');

        if (!IPS_VariableProfileExists('Voltage.RaspBee')) {
            IPS_CreateVariableProfile('Voltage.RaspBee', 2);
        }
        IPS_SetVariableProfileDigits('Voltage.RaspBee', 0);
        IPS_SetVariableProfileIcon('Voltage.RaspBee', 'Electricity');
        IPS_SetVariableProfileText('Voltage.RaspBee', '', ' V');

        if (!IPS_VariableProfileExists('ColorModeSelect.RaspBee')) {
            IPS_CreateVariableProfile('ColorModeSelect.RaspBee', 1);
        }
        IPS_SetVariableProfileAssociation('ColorModeSelect.RaspBee', 0, $this->Translate('Color'), '', 0x000000);
        IPS_SetVariableProfileAssociation('ColorModeSelect.RaspBee', 1, $this->Translate('Color temperature'), '', 0x000000);
        IPS_SetVariableProfileIcon('ColorModeSelect.RaspBee', 'ArrowRight');

        if (!IPS_VariableProfileExists('ColorTemperatureSelect.RaspBee')) {
            IPS_CreateVariableProfile('ColorTemperatureSelect.RaspBee', 1);
        }
        IPS_SetVariableProfileDigits('ColorTemperatureSelect.RaspBee', 0);
        IPS_SetVariableProfileIcon('ColorTemperatureSelect.RaspBee', 'Bulb');
        IPS_SetVariableProfileText('ColorTemperatureSelect.RaspBee', '', 'Mired');
        IPS_SetVariableProfileValues('ColorTemperatureSelect.RaspBee', 153, 500, 1);

        if (!IPS_VariableProfileExists('Intensity.RaspBee')) {
            IPS_CreateVariableProfile('Intensity.RaspBee', 1);
        }
        IPS_SetVariableProfileDigits('Intensity.RaspBee', 0);
        IPS_SetVariableProfileIcon('Intensity.RaspBee', 'Intensity');
        IPS_SetVariableProfileText('Intensity.RaspBee', '', '%');
        IPS_SetVariableProfileValues('Intensity.RaspBee', 0, 254, 1);

        if (!IPS_VariableProfileExists('Scenes.RaspBee')) {
			IPS_CreateVariableProfile ("Scenes.RaspBee",0);
		}
			
			IPS_SetVariableProfileAssociation('Scenes.RaspBee', 0, '', ' ', 0x4169E1);
			IPS_SetVariableProfileAssociation('Scenes.RaspBee', 1, 'CALL', '', 0x4169E1);
			IPS_SetVariableProfileIcon('Scenes.RaspBee', 'Shuffle');

		
		
        if (!IPS_VariableProfileExists('Alert.RaspBee')) {
			IPS_CreateVariableProfile ("Alert.RaspBee",2);
		}
			IPS_SetVariableProfileAssociation('Alert.RaspBee', 1, 'none', '', 0x339966);
			IPS_SetVariableProfileAssociation('Alert.RaspBee', 2, 'select', '', 0xff9900);
			IPS_SetVariableProfileAssociation('Alert.RaspBee', 3, 'lselect', '', 0x3366FF);
			IPS_SetVariableProfileIcon('Alert.RaspBee', 'Alert');
		
        if (!IPS_VariableProfileExists('Effect.RaspBee')) {
			IPS_CreateVariableProfile ("Effect.RaspBee",2);
		}
			IPS_SetVariableProfileAssociation('Effect.RaspBee', 1, 'none', '', 0x000000);
			IPS_SetVariableProfileAssociation('Effect.RaspBee', 2, 'colorloop', '', 0xff9900);
			IPS_SetVariableProfileIcon('Effect.RaspBee', 'Repeat');

        if (!IPS_VariableProfileExists('Temperature_Offset.RaspBee')) {
            IPS_CreateVariableProfile('Temperature_Offset.RaspBee', 2);
        }
        IPS_SetVariableProfileDigits('Temperature_Offset.RaspBee', 1);
        IPS_SetVariableProfileIcon('Temperature_Offset.RaspBee', 'Temperature');
        IPS_SetVariableProfileText('Temperature_Offset.RaspBee', '', ' °C');
        IPS_SetVariableProfileValues('Temperature_Offset.RaspBee', -30.0, 30.0, 0.1);
			
        if (!IPS_VariableProfileExists('Sensitivity.RaspBee')) {
            IPS_CreateVariableProfile('Sensitivity.RaspBee', 1);
        }
        IPS_SetVariableProfileDigits('Sensitivity.RaspBee', 0);
        IPS_SetVariableProfileIcon('Sensitivity.RaspBee', 'Motion');
        IPS_SetVariableProfileValues('Sensitivity.RaspBee', 0, 2, 1);

		if (!IPS_VariableProfileExists('Daylight.RaspBee')) {
            IPS_CreateVariableProfile('Daylight.RaspBee', 1);
		}
		IPS_SetVariableProfileDigits('Daylight.RaspBee', 0);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 100, 'NaDir', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 110, 'Night End', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 120, 'Nautical Dawn', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 130, 'Dawn', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 140, 'Sunrise Start', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 150, 'Sunrise End', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 160, 'Solar Noon', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 170, 'Golden Hour 1', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 180, 'Golden Hour 2', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 190, 'Sunset Start', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 200, 'Sunset End', '', 0x3366FF);
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 210, 'Dusk', '', 0x3366FF);			
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 220, 'Nautical Dust', '', 0x3366FF);			
		IPS_SetVariableProfileAssociation('Daylight.RaspBee', 230, 'Night', '', 0x3366FF);			
		
        /*if (!IPS_VariableProfileExists('Delay.RaspBee')) {
            IPS_CreateVariableProfile('Delay.RaspBee', 1);
        }
        IPS_SetVariableProfileDigits('Delay.RaspBee', 0);
		IPS_SetVariableProfileText('Delay.RaspBee', ' sec');
        IPS_SetVariableProfileIcon('Delay.RaspBee', '');
        IPS_SetVariableProfileValues('Delay.RaspBee', 0, 32000, 1);
			*/
			
        parent::Create();
    }
	

    protected function GetBridge(){
        $instance = IPS_GetInstance($this->InstanceID);
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }

    abstract protected function BasePath();
	
    public function ApplyChanges(){
		
		parent::ApplyChanges();
		
		//bridge as parent for devices
        $this->ConnectParent("{F49E6837-55BA-4362-B502-CAF32BAF1DBC}");

    }
    
	public function ApplyData($data){
		
		$data = (array)$data;
		
		switch(get_class($this)) {
			case 'RaspBeeGroup':
				$values_action = (array)@$data['action'];
				$values_state = (array)@$data['state'];
				break;	
			case 'RaspBeeScene':
				$values_scenes = (array)@$data['lights'];
				$values = (array)@$data;
				break;
			case 'RaspBeeSensor':
				$values_config = (array)@$data['config'];
				$values_state = (array)@$data['state'];
				break;
			case 'RaspBeeSwitch':
				$values_config = (array)@$data['config'];
				$values_state = (array)@$data['state'];
				break;
			default: //LIGHT & PLUG
				$values = (array)@$data['state'];
				$values_state = (array)@$data['state'];
        }
		
        // Status
        if (get_class($this) == 'RaspBeeLight' && $this->ReadPropertyString("UniqueId") == '') {
            $this->SetStatus(104);
            return false;
        } elseif (get_class($this) == 'RaspBeePlug' && $this->ReadPropertyString("UniqueId") == '') {
            $this->SetStatus(104);
            return false;
        } elseif (get_class($this) == 'RaspBeeSensor' && $this->ReadPropertyString("UniqueId") == '') {
            $this->SetStatus(104);
            return false;
        } elseif (get_class($this) == 'RaspBeeSwitch' && $this->ReadPropertyString("UniqueId") == '') {
            $this->SetStatus(104);
            return false;
        } elseif (get_class($this) == 'RaspBeeScene' && $this->ReadPropertyString("SceneId") == '') {
            $this->SetStatus(104);
            return false;
        } elseif (get_class($this) == 'RaspBeePlug' || get_class($this) == 'RaspBeeLight') {
			if (isset($values_state['reachable'])) {
				if(!$values_state['reachable']) {
					$this->SetStatus(201);
				}else
				{
					$this->SetStatus(102);
				}
			}
		} else {
            $this->SetStatus(102);
        }

        $dirty = false;

        /*
         * Properties
         */

        $name = utf8_decode((string)@$data['name']);
		

		switch(get_class($this)) {

			case 'RaspBeeGroup':
				$devices_p=array();
				$devices_p=json_decode(D_GROUP,true);
		
				foreach ($devices_p as $deviceId => $d) {
					$value=$devices_p[$deviceId];
					if($value['state']){
						$val=$values_state;//state
					}elseif($value['config']){
						$val=$values_config;
					}elseif($value['action']){
						$val=$values_action;
					}else{
						break;
					}		
					
		
					//if(isset($val[$value['original']])){
					if(array_key_exists ($value['original'] , $val)){						
						$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$val);
						if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
						if(@$Id)IPS_SetHidden($Id,$value['hidden']);
					}
				}

			break;
			
			case 'RaspBeeScene':
				
				//scenes
				if (!isset($values_scenes['action'])) {									
					$ident="ON";
					$general = @IPS_GetProperty($this->GetBridge(), $ident);
					$single = @IPS_GetProperty($this->InstanceID, $ident);
					if (!$general && !$single) {			
						$this->UnregisterVariable($ident);
					} elseif ($general && !$single) {				
						$this->UnregisterVariable($ident);
					}else{
					$valuesId = @$this->GetIDForIdent("ON");
					if(!$valuesId){
						$this->MaintainVariable("ON", $this->Translate('Action'), 0, "Scenes.RaspBee", 1, true);
						$this->EnableAction("ON");
						$valuesId = @$this->GetIDForIdent("ON");
						if($valuesId)$this->SetValueBoolean($valuesId, true);
					}
					}
				}

				//group level

				$ident="GROUPNAME";
				$general = @IPS_GetProperty($this->GetBridge(), $ident);
				$single = @IPS_GetProperty($this->InstanceID, $ident);
				if (!$general && !$single) {			
					$this->UnregisterVariable($ident);
				} elseif ($general && !$single) {				
					$this->UnregisterVariable($ident);
				}else{
					$groupName = @$this->GetIDForIdent("GROUPNAME");
					if(!$groupName){
						$this->MaintainVariable("GROUPNAME", $this->Translate('Groupname'), 3, "", 1, true);
						$groupName = @$this->GetIDForIdent("GROUPNAME");
					}
					$gn=@IPS_GetProperty($this->InstanceID, 'Group_Name');
					if (@$groupName)$this->SetValueString($groupName, $gn);
				}
				
				//$this->maintain_variable("TRANSITIONTIME",'transitiontime',1,"",2,true,$values);
				
				//}
			break;

			case 'RaspBeeSensor':
				$name = utf8_decode((string)@$data['name']);
				$type = utf8_decode((string)@$data['type']);

				$dirty=$this->maintain_properties($data,NULL);

				if ($dirty)IPS_ApplyChanges($this->InstanceID);

				$devices_p=array();
				$devices_p=json_decode(D_SENSOR,true);

				foreach ($devices_p as $deviceId => $d) {
					$value=$devices_p[$deviceId];
					
					if($value['state']){
						$val=$values_state;//state
					}elseif($value['config']){
						$val=$values_config;
					}elseif($value['action']){
						$val=$values;
					}else{
						break;
					}			

					//umrechnen zb temperatur
					if(array_key_exists ($value['original'] , $val)){							
						if(@(float)$value['mult_factor'] >0 && isset($val[$value['original']])){
							@$val[$value['original']]=@$val[@$value['original']]*@$value['mult_factor'];
						}
				        
						
						if($name =="Daylight"){
							if($value['ident']=="STATUS"){
								$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],"Daylight.RaspBee",$value['pos'],$value['flag'],$val);
								IPS_SetVariableCustomProfile($Id, "Daylight.RaspBee");
							}else{
								$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],	$val);
								if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
								if(@$Id)IPS_SetHidden($Id,$value['hidden']);
							}		
						}else{
							$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$val);
							if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
							if(@$Id)IPS_SetHidden($Id,$value['hidden']);
						}
					}
				}
			break;
			
			case 'RaspBeeSwitch':			
				$name = utf8_decode((string)@$data['name']);
				$type = utf8_decode((string)@$data['type']);

				$dirty=$this->maintain_properties($data,NULL);

				if ($dirty)IPS_ApplyChanges($this->InstanceID);


				$devices_p=array();
				$devices_p=json_decode(D_SWITCH,true);
		
				foreach ($devices_p as $deviceId => $d) {
					$value=$devices_p[$deviceId];
					if($value['state']){
						$val=$values_state;//state
					}elseif($value['config']){
						$val=$values_config;
					}elseif($value['action']){
						$val=$values;
					}else{
						break;
					}			

					if(array_key_exists ($value['original'] , $val)){						
						$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$val);
						if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
						if(@$Id)IPS_SetHidden($Id,$value['hidden']);
					}
				}
				break;
			
			case 'RaspBeeLight':
				$lightFeature=$this->set_light_features($values);
				
				$dirty=$this->maintain_properties($data,$lightFeature);				
								
				if ($dirty) IPS_ApplyChanges($this->InstanceID);
				
				$devices_p=array();
				$devices_p=json_decode(D_LIGHT,true);
		
				foreach ($devices_p as $deviceId => $d) {
					$value=$devices_p[$deviceId];

					if(array_key_exists ($value['original'] , $values)){							
						if($deviceId=="BRI"){
							if ($lightFeature != 4) {
								$briId=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
								if($briId && $value['enableaction'])$this->EnableAction($value['ident']);
							} else {
								$this->UnregisterVariable($value['ident']);
							}
						}elseif	($deviceId=="HUE"){
							if ($lightFeature == 0 || $lightFeature == 1) {
								$hueId=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
							} else {
								$this->UnregisterVariable($value['ident']);
							}
							if (@$hueId && in_array($lightFeature, [0, 1])) 	$this->SetValueInteger($hueId, (int)@$values[$value['original']]);
						}elseif($deviceId=="CT"){
							if ($lightFeature == 0 || $lightFeature == 2) {
								$ctId=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
								if($ctId && $value['enableaction'])$this->EnableAction($value['ident']);
							} else {
								$this->UnregisterVariable($value['ident']);
							}
							if (@$ctId && in_array($lightFeature, [0, 2])) 		$this->SetValueInteger($ctId, (int)@$values[$value['original']]);
						}elseif($deviceId=="SAT"){
							if ($lightFeature == 0 || $lightFeature == 1) {
								$satId=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
								if($satId && $value['enableaction'])$this->EnableAction($value['ident']);
								if(@$satId && in_array($lightFeature, [0, 1])) $this->SetValueInteger($satId, (int)@$values[$value['original']]);
							}
						}else{
							$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
							if($Id !==false && $value['enableaction'])$this->EnableAction($value['ident']);
							if(@$Id)IPS_SetHidden($Id,$value['hidden']);
						}
					}
				}
					
				if ($lightFeature == 0 || $lightFeature == 1) {
					//zusammengesetzt aus hue,sat & bri
					$this->MaintainVariable("COLOR", $this->Translate('Color'), 1, "~HexColor", 3, true);
					$this->EnableAction("COLOR");
					$colorId = $this->GetIDForIdent("COLOR");
					IPS_SetHidden($colorId, true);
				} else {
					$this->UnregisterVariable("COLOR");
					$this->UnregisterVariable("SAT");
				}
				
				// Fix colormode for non philips hue lamps
				$colormode = @$values['colormode'];
				if (in_array($colormode, ['hs', 'xy']) && in_array($lightFeature, [0, 1])) {
					$colormode = 'hs';
					
				} elseif ($colormode == 'ct' && in_array($lightFeature, [0, 2])) {
					$colormode = 'ct';
					
				} else {
					$colormode = '';
					
				}

				if ($colormode == 'hs' && isset($values['hue']) && isset($values['sat']) && isset($values['bri'])) {
					$hex = RaspBeeMisc::HSV2HEX($values['hue'], $values['sat'], $values['bri']);
					$this->SetValueInteger($colorId, hexdec($hex));
					if(@$colorId)IPS_SetHidden($colorId, false);
					if(@$satId)IPS_SetHidden($satId, false);
					if (@$ctId)IPS_SetHidden($ctId, true);
					if (@$cmId)$this->SetValueInteger($cmId, 0);
					
				} elseif ($colormode == 'ct') {
					if (@$colorId)IPS_SetHidden($colorId, true);
					if (@$satId) IPS_SetHidden($satId, true);
					if(@$ctId)IPS_SetHidden($ctId, false);
					if(@$cmId)$this->SetValueInteger($cmId, 1);
				}
				break;
			
			case 'RaspBeePlug':
   				$lightFeature=$this->set_light_features($values);
				
				$dirty=$this->maintain_properties($data,$lightFeature);

				if ($dirty) IPS_ApplyChanges($this->InstanceID);

				$devices_p=array();
				$devices_p=json_decode(D_PLUG,true);
		
				foreach ($devices_p as $deviceId => $d) {
					$value=$devices_p[$deviceId];
					

						if(array_key_exists ($value['original'] , $values)){
							$Id=$this->maintain_variable($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
							if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
							if(@$Id)IPS_SetHidden($Id,$value['hidden']);
						//für power sensoren in den plugs
						}else{
							$Id=$this->maintain_variable_special($value['ident'],$value['original'],$value['type'],$value['profile'],$value['pos'],$value['flag'],$values);
							if($Id && $value['enableaction'])$this->EnableAction($value['ident']);
							if(@$Id)IPS_SetHidden($Id,$value['hidden']);
						}
				}
				break;
				
			default:
				break;
		}


	}	
	
    /*
     * RB_RequestData(int $id)
     * Abgleich des Status einer Lampe oder Gruppe (RB_SyncStates sollte bevorzugewerden,
     * da direkt alle Lampen abgeglichen werden mit nur 1 Request zur RB Bridge)
     */
    public function RequestData(){
		
		$sensorid = @$this->ReadPropertyInteger('SensorId');
		$id1 = @$this->ReadPropertyInteger('PlugId');
		
		//loop über Sensorgruppe
		if ($sensorid) {
			$sensorlist=$this->get_sensors($sensorid);
			$data=array();
			foreach ($sensorlist as $g =>$sensor) {
				
				$newid=$sensor['Id'];
				$path="/sensors/$newid";
				$data = RB_Request($this->GetBridge(), $path, null);
				
				if (is_array($data) && @$data[0]->error) {
					$error = @$data[0]->error->description;
					$this->SetStatus(202);
					IPS_LogMessage("SymconRaspBee", "Es ist ein Fehler aufgetreten: $error");
				}else{
					$this->ApplyData($data);	
				}
			}
		}else{
			$data = RB_Request($this->GetBridge(), $this->BasePath(), null);
		
			if (is_array($data) && @$data[0]->error) {
				$error = @$data[0]->error->description;
				$this->SetStatus(202);
				IPS_LogMessage("SymconRaspBee", "Es ist ein Fehler aufgetreten: $error");
			} else {
				$this->ApplyData($data);
			}
		}	
		
		
		
    }
	
	public function RequestData_Group(){

	$id = @$this->ReadPropertyInteger('SensorId');
	if($id){
			$sensorlist=$this->get_sensors($id);
			$datagroup=array();
			$data=array();
			foreach ($sensorlist as $g =>$sensor) {
				$newid=$sensor['Id'];
				$path="/sensors/$newid";
				$datagroup = RB_Request($this->GetBridge(), $path, null);
				$data[]=$datagroup;
			}
			return($data);
	}else{

        $data = RB_Request($this->GetBridge(), $this->BasePath(), null);
        if (is_array($data) && @$data[0]->error) {
            $error = @$data[0]->error->description;
            $this->SetStatus(202);
            IPS_LogMessage("SymconRaspBee", "Es ist ein Fehler aufgetreten: $error");
        } else {
			return($data);
        }
	}
  }
  
    public function UpdateData_Rest($sub_state,$sub_config,$type){

		if($sub_state){

			foreach ($sub_state as $Id => $sub) {

				$value=$sub_state[$Id];
				$ident=$Id;
				
								
				//-------- Umrechnung ----------------
				//zb. Temperatur wird durch 100 geteilt -->nur sensoren

				if($type == "sensors"){
					$devices_p=array();
					$devices_p=json_decode(D_SENSOR,true);
					foreach ($devices_p as $deviceId => $d) {
						$valuex=$devices_p[$deviceId];
						if($valuex['original'] == $ident){
							if(@(float)$valuex['mult_factor'] >0){
								$value=$value*@$valuex['mult_factor'];
								break;
							}
						}
					}
				}
				
				//---------------------------------
				
				$ident=strtoupper($ident);
				
				//schreiben
				$ident_no=@$this->GetIDForIdent($ident);
				if($ident_no){
					if(GetValue($ident_no) !=$value){
						SetValue($ident_no,$value);
						($value) ? $val=$value : $val="0";
					}
				}
				
				//bei Änderung reachable instanz updaten
				if($ident=="REACHABLE" ){
					if($value)$this->SetStatus(102);
					if(!$value)$this->SetStatus(201);
				}	

				//bei Änderung lastupdated instanz updaten
/*				if($ident=="LASTUPDATED" && $ident_no>0){
					$old=GetValue($ident_no);
					$timestampold=$this->get_timestamp($old)+7200;
					$timestamp4 = time();//aktuelle Zeit
					$l = date("Y-m-d",$timestamp4).'T'.date("H:i:s",$timestamp4);
					$timestampnew=$this->get_timestamp($l);
					$timestampdiff=$timestampnew-$timestampold;
					$val=$this->time2string($timestampdiff);
					set_info("diff: ".$val."---".$ident_no);
					SetValue($ident_no,$val);
				}	*/



				
				//Q&D Ausnahme für group ON 
				if($type == "groups"){
					if($ident=="ALL_ON" || $ident=="ANY_ON"){
						$ident_no=@$this->GetIDForIdent("ON");
						if($ident_no>0 && $value){
							$oldvalue=GetValue($ident_no);
							if($oldvalue !=1)SetValue($ident_no,1);
							if($oldvalue !=0)SetValue($ident_no,0);
						}
						if($ident_no>0 && !$value){
							SetValue($ident_no,0);
						}		
					}
										
				}	
			}
		}
		//config Änderung
		if($sub_config){
			foreach ($sub_config as $Id => $sub) {
				
				$value=$sub_config[$Id];
				$ident=strtoupper($Id);
				
				$ident_no=@$this->GetIDForIdent($ident);
				if($ident_no)SetValue($ident_no,$value);

				($value) ? $val=$value : $val="0";

			}
		}
		
	}
	
	public function UpdateData($device){
	
        $data = RB_Request($this->GetBridge(), $device, null);
		
        if (is_array($data) && @$data[0]->error) {
            $error = @$data[0]->error->description;
            $this->SetStatus(202);
            IPS_LogMessage("SymconRaspBee", "Es ist ein Fehler aufgetreten: $error");
        } else {
			$this->ApplyData($data);
        }
    }

    public function RequestAction($key, $value){
        switch ($key) {
        
		case 'ON':
        case 'PRESENCE':
            $value = $value == 1;
            break;
        case 'HUE':
        case 'CT':
        case 'SAT':
        case 'BRI':
        case 'TEMPERATURE':
        case 'LIGHTLEVEL':
            $value = $value;
            break;
        }
		
        $this->SetValue($key, $value);
    }

    /*
     * RB_GetValue(int $id, string $key)
     * Liefert einen Lampenparameter (siehe RB_SetValue)
     */
    public function GetValue($key){
        switch ($key) {
        default:
            $value = GetValue(@IPS_GetObjectIDByIdent($key, $this->InstanceID));
            break;
        }
        return $value;
    }

    /*
     * RB_SetValue(int $id, string $key, $value)
     * Anpassung eines Lampenparameter siehe SetValues
     */
    public function SetValue($key, $value){
        //Beispiel: RB_SetValue(53604,'ON' ,true );
		return $this->SetValues(array($key => $value));
    }

    /*
     * RB_SetState(int $id, bool $value)
     */
    public function SetState(bool $value){
        //echo RB_SetState(53604,false);
		return $this->SetValue('ON', $value);
    }

    /*
     * RB_GetState(int $id)
     */
    public function GetState(){
		//RB_GetState(53604);
        return $this->GetValue('ON');
    }
    public function GetAnyOn(){
		//echo RB_GetAnyOn(42385);
        return $this->GetValue('ANY_ON');
    }
    public function GetAllOn(){
		//echo RB_GetAllOn(42385);
        return $this->GetValue('ALL_ON');
    }
	
    public function GetReach(){
		//echo RB_GetReach(50416);
        return $this->GetValue('REACHABLE');
    }
	

    /*
     * RB_SetColor(int $id, int $value)
     */
    public function SetColor(int $value){
        return $this->SetValue('COLOR', $value);
    }

    /*
     * RB_GetColor(int $id)
     */
    public function GetColor(){
        return $this->GetValue('COLOR');
    }

    /*
     * RB_SetBrightness(int $id, int $value)
     */
    public function SetBrightness(int $value){
        return $this->SetValue('BRI', $value);
    }

    /*
     * RB_GetBrightness(int $id)
     */
    public function GetBrightness(){
        return $this->GetValue('BRI');
    }

    /*
     * RB_SetValues($lightId, $list)
     * Anpassung mehrere Lampenparameter.
     * array('KEY1' => 'VALUE1', 'KEY2' => 'VALUE2'...)
     *
     * Mögliche Keys:
     *
     * ON -> true oder false für an/aus
     * REACHABLE -> true oder false für erreichbar/nicht erreichbar -> wird bei jeder Änderung/update gesetzt & parameter pulltime in Bridge
     * CT -> Farbtemperatur in mirek (153 bis 500)
     * SAT -> Sättigung (0 bis 254)
     * BRI -> Helligkeit in (0 bis 254)
     * RB -> RB Farbe in (0 bis 65535)
     * COLOR -> Farbe als integer
     * ALERT -> Wird durchgereicht
	 * OFFSET (Temperatur)-> Wird durchgereicht
	 * DELAY-> Wird durchgereicht
	 * DURATION-> Wird durchgereicht	 
	 * SENSITIVITY-> Wird durchgereicht
	 * SENSITIVITYMAX-> Wird durchgereicht
	 * LEDINDICATION-> Wird durchgereicht	 
	 * SUNRISEOFFSET -> Wird durchgereicht
	 * SUNSETOFFSET -> Wird durchgereicht
     * EFFECT -> Wird durchgereicht
     * TRANSITIONTIME -> Wird durchgereicht
     *
     */
    public function SetValues(array $list){
		//Beispiel: RB_SetValues(45914,array('ON'=>'true','BRI'=>'255') );
		
		$stateId = @IPS_GetObjectIDByIdent('ON', $this->InstanceID);
        $cmId = @IPS_GetObjectIDByIdent('COLORMODE', $this->InstanceID);
        $ctId = @IPS_GetObjectIDByIdent('CT', $this->InstanceID);
        $briId = @IPS_GetObjectIDByIdent('BRI', $this->InstanceID);
        $satId = @IPS_GetObjectIDByIdent('SAT', $this->InstanceID);
        $hueId = @IPS_GetObjectIDByIdent('HUE', $this->InstanceID);
        $colorId = @IPS_GetObjectIDByIdent('COLOR', $this->InstanceID);

        if(@$stateValue)$stateValue = GetValueBoolean($stateId);
        if(@$cmValue)$cmValue = $cmId ? GetValueInteger($cmId) : 0;
        if(@$ctValue)$ctValue = $ctId ? GetValueInteger($ctId) : 0;
        if(@$briValue)$briValue = $briId ? GetValueInteger($briId) : 0;
        if(@$satValue)$satValue = $satId ? GetValueInteger($satId) : 0;
        if(@$hueValue)$hueValue = $hueId ? GetValueInteger($hueId) : 0;
        if(@$colorValue)$colorValue = $colorId ? GetValueInteger($colorId) : 0;
		

        foreach ($list as $key => $value) {
			
            switch ($key) {
            case 'ON':
                $stateNewValue = $value;
                break;
			case 'EFFECT':
                $effect = $value;
                break;
            case 'TRANSITIONTIME':
                $transitiontime = $value;
                break;
            case 'ALERT':
                $alert = $value;
                break;
            case 'OFFSET':
                $offset = (float)$value;
                break;
				
            case 'SUNRISEOFFSET':
                $sunriseoffset = (float)$value;
                break;
            case 'SUNSETOFFSET':
                $sunsetoffset = (float)$value;
                break;
            case 'DELAY':
                $delay = (int)$value;
                break;
            case 'DURATION':
                $duration = (int)$value;
                break;
				
            case 'SENSITIVITY':
                $sensitivity = (int)$value;
                break;
            case 'LEDINDICATION':
                $ledindication = (boolean)$value;
                break;
				
            case 'SENSITIVITYMAX':
                $sensitivitymax = (int)$value;
                break;
				
            case 'HUE':
                $stateNewValue = true;
                $hueNewValue = $value;
                $newHex = RaspBeeMisc::HSV2HEX(@$hueNewValue, @$satValue, @$briValue);
                if (isset($colorId)) { $this->SetValueInteger(@$colorId, hexdec($newHex));
                }
                break;
            case 'COLOR':
                $stateNewValue = true;
                $colorNewValue = $value;
                $hex = str_pad(dechex($value), 6, 0, STR_PAD_LEFT);
                $hsv = RaspBeeMisc::HEX2HSV($hex);
                if (isset($colorId)) { $this->SetValueInteger($colorId, hexdec($value));
                }
                $hueNewValue = $hsv['h'];
                $briNewValue = $hsv['v'];
                $satNewValue = $hsv['s'];
                $cmNewValue = 0;
                break;
            case 'BRI':
                $briNewValue = $value;
                if (@IPS_GetProperty($this->InstanceID, 'LightFeatures') != 3) {
                    if (@$cmValue == '0') {
                        $newHex = RaspBeeMisc::HSV2HEX(@$hueValue, @$satValue, @$briNewValue);
                        if (isset($colorId)) { $this->SetValueInteger(@$colorId, hexdec($newHex));
                        }
                        $hueNewValue = @$hueValue;
                        $satNewValue = @$satValue;
                    } else {
                        $ctNewValue = @$ctValue;
                    }
                }
                $stateNewValue = (@$briNewValue > 0);
                break;
            case 'SAT':
                $stateNewValue = true;
                $cmNewValue = 0;
                $satNewValue = $value;
                $newHex = RaspBeeMisc::HSV2HEX(@$hueValue, @$satNewValue, @$briValue);
                if (isset($colorId)) { $this->SetValueInteger($colorId, hexdec($newHex));
                }
                if (isset($hueValue))$hueNewValue = $hueValue;
                if (isset($briValue))$briNewValue = $briValue;
                break;
            case 'CT':
                $stateNewValue = true;
                $cmNewValue = 1;
                $ctNewValue = $value;
                if (isset($briValue))$briNewValue = $briValue;
                break;

			case 'COLORMODE':
                $stateNewValue = true;
                $cmNewValue = $value;
                if ($cmNewValue == 1) {
                    if (isset($ctValue))$ctNewValue = $ctValue;
                    if(@$colorId)IPS_SetHidden($colorId, true);
                    if(@$ctId)IPS_SetHidden($ctId, false);
                    if(@$satId)IPS_SetHidden($satId, true);
                } else {
                    $hueNewValue = @$hueValue;
                    $satNewValue = @$satValue;
                    $briNewValue = @$briValue;
                    $newHex = RaspBeeMisc::HSV2HEX(@$hueValue, @$satValue, @$briValue);
                    $this->SetValueInteger(@$colorId, hexdec($newHex));
                    if(@$colorId)IPS_SetHidden($colorId, false);
                    if(@$ctId)IPS_SetHidden($ctId, true);
                    if(@$satId)IPS_SetHidden($satId, false);
                }
                break;
            default:
            }
        }

        $changes = array();
        if (isset($effect)) {
            $changes['effect'] = $effect;
        }
        if (isset($alert)) {
            $changes['alert'] = $alert;
        }
        if (isset($offset)) {
            $changes['offset'] = (float)$offset;
        }
        if (isset($sunriseoffset)) {
            $changes['sunriseoffset'] = (float)$sunriseoffset;
        }
        if (isset($sunsetoffset)) {
            $changes['sunsetoffset'] = (float)$sunsetoffset;
        }
        if (isset($delay)) {
            $changes['delay'] = (int)$delay;
        }
        if (isset($duration)) {
            $changes['duration'] = (int)$duration;
        }
        if (isset($sensitivity)) {
            $changes['sensitivity'] = (int)$sensitivity;
        }
		
        if (isset($ledindication)) {
            $changes['ledindication'] = (boolean)$ledindication;
        }

        if (isset($sensitivitymax)) {
            $changes['sensitivitymax'] = (int)$sensitivitymax;
        }
		
        if (isset($transitiontime)) {
            $changes['transitiontime'] = $transitiontime;
        }
        if (isset($stateNewValue)) {
            $this->SetValueBoolean($stateId, $stateNewValue);
            $changes['on'] = $stateNewValue;
        }
        if (isset($hueNewValue)) {
            $this->SetValueInteger($hueId, $hueNewValue);
            $changes['hue'] = $hueNewValue;
        }
        if (isset($satNewValue)) {
            $this->SetValueInteger($satId, $satNewValue);
            $changes['sat'] = $satNewValue;
        }
        if (isset($briNewValue)) {
            $this->SetValueInteger($briId, $briNewValue);
            $changes['bri'] = $briNewValue;
        }
        if (isset($ctNewValue)) {
            $this->SetValueInteger($ctId, $ctNewValue);
            $changes['ct'] = $ctNewValue;
        }
        if (isset($cmNewValue)) {
            $this->SetValueInteger($cmId, $cmNewValue);
			$changes['colormode'] = $cmNewValue == 1 ? 'ct' : 'hs';
        }

        if (get_class($this) == 'RaspBeeGroup') {
            $path = $this->BasePath() . "/action";
        } elseif (get_class($this) == 'RaspBeeLight' || get_class($this) == 'RaspBeePlug') {
            $path = $this->BasePath() . "/state";
        } elseif (get_class($this) == 'RaspBeeSensor' || get_class($this) == 'RaspBeeSwitch') {
            $path = $this->BasePath() . "/config";
			//wg Felder auf x Devices/Sensoren verteilt
            $sensorid = $this->BaseId();
			$sensorlist=$this->get_sensors($sensorid);
			foreach ($sensorlist as $g =>$sensor) {
				$newid=$sensor['Id'];
				if (isset($delay) || isset($duration) || isset($sensitivity) || isset($sensitivitymax) || isset($ledindication)){
					if($sensor['delay']!==null || $sensor['duration']!==null || $sensor['sensitivity']!==null || $sensor['sensitivitymax'] !=null || $sensor['ledindication'] != null){
						$path = $this->Base().$newid."/config";
						break;
					}
				}elseif(isset($offset)){
					if($sensor['offset']!==null){
						$path = $this->Base().$newid."/config";
						break;
					}
				}
			}	
			
        } elseif (get_class($this) == 'RaspBeeScene') {
				$path = $this->BasePath() ."/recall";
				
		}

		
		
		
		return RB_Request($this->GetBridge(), $path, $changes);
    }

    protected function SetValueBoolean($InstanceId, $value){
            if($InstanceId)return SetValueBoolean($InstanceId, (boolean)$value);
    }

    protected function SetValueInteger($InstanceId, $value){
            if($InstanceId)return SetValueInteger($InstanceId, (int)$value);
			
    }

    protected function SetValueFloat($InstanceId, $value){
            if($InstanceId)return SetValueFloat($InstanceId, (float)$value);
    }
    protected function SetValueString($InstanceId, $value){
            if($InstanceId)return SetValueString($InstanceId, (string)$value);
    }

	protected function set_light_features($values){
				
				if (!isset($values['bri'])) {
					// Keine Helligkeit, somit keine Licht-Funktionen
					$lightFeature = 4;
					$f="Switch only";
				} elseif (isset($values['ct']) && (isset($values['hue']) || in_array(@$values['colormode'], array('hs', 'xy')))) {
					// RB+CT Lamp
					$lightFeature = 0;
					$f="Color + Temperature";
				} elseif (isset($values['hue']) || in_array(@$values['colormode'], array('hs', 'xy'))) {
					// RB Lamp
					$lightFeature = 1;
					$f="Color";
				} elseif (isset($values['ct'])) {
					// CT Lamp
					$lightFeature = 2;
					$f="Temperature";
				} else {
					// Lux Lamp
					$lightFeature = 3;
					$f="Brightness";
				}
				IPS_SetProperty($this->InstanceID, 'LightFeaturesName', $f);
				

	return($lightFeature);
}

	protected function maintain_properties($data,$lightFeature){

			$dirty=false;

			$type = utf8_decode((string)@$data['type']);
				

//			if($type != "ZHALightLevel" && $type != "ZHATemperature"){	//speziell für motion sensoren

				if (@IPS_GetProperty($this->InstanceID, 'Type') != $type) {
					IPS_SetProperty($this->InstanceID, 'Type', $type);
					$dirty = true;
				}
	//			if($type != "ZHAPower" && $type != "ZHAConsumption"){
					$name = utf8_decode((string)@$data['name']);
					if (IPS_GetName($this->InstanceID) != $name) {
						IPS_SetName($this->InstanceID, $name);
						$dirty = true;
					}
		//		}
				
				$modelid = utf8_decode((string)@$data['modelid']);
				if (@IPS_GetProperty($this->InstanceID, 'ModelId') != $modelid) {
					IPS_SetProperty($this->InstanceID, 'ModelId', $modelid);
					$dirty = true;
				}
				
				
				$manufacturername = utf8_decode((string)@$data['manufacturername']);
				if (@IPS_GetProperty($this->InstanceID, 'ManufacturerName') != $manufacturername) {
					IPS_SetProperty($this->InstanceID, 'ManufacturerName', $manufacturername);
					$dirty = true;
				}
				
				
				if($lightFeature != null){
					if (@IPS_GetProperty($this->InstanceID, 'LightFeatures') != $lightFeature) {
						IPS_SetProperty($this->InstanceID, 'LightFeatures', $lightFeature);
						$dirty = true;
					}
				}
			//}
		
		return($dirty);
	}		

	protected function maintain_variable($ident,$name,$type,$profil,$pos,$flag,$values){

		
		if(($name=="lastupdated" && @$this->ReadPropertyInteger('PlugId')) || $name =="alert" || $name =="effect"){
			$Id=$this->maintain_variable_special($ident,$name,$type,$profil,$pos,$flag,$values);
			return($Id);
			
		}
		

		if($ident=="REACHABLE" ){
			if($values[$name]){
				$this->SetStatus(102);
			}else{
				$this->SetStatus(201);
			}
		}	
		
		
		$general = @IPS_GetProperty($this->GetBridge(), $ident);
		$single = @IPS_GetProperty($this->InstanceID, $ident);
		
		if (!$general && !$single) {			
			$this->UnregisterVariable($ident);
			return(false);
		} elseif ($general && !$single) {				
			$this->UnregisterVariable($ident);
			return(false);
		}

		if(array_key_exists($name, $values)){
								
				$Id = @$this->GetIDForIdent($ident);
				if(!$Id){
					$this->MaintainVariable($ident, $this->Translate($name),$type ,$profil, $pos,$flag);
					$Id = @$this->GetIDForIdent($ident);
				}
				if (@$Id && isset($values[$name])){
					if($type==0){
						if(GetValueBoolean($Id) != (boolean)$values[$name])$this->SetValueBoolean($Id, $values[$name]);
					}	
					if($type==1){
						if(GetValueInteger($Id) != (integer)$values[$name])$this->SetValueInteger($Id, $values[$name]);
					}	
					if($type==2){
						if(GetValueFloat($Id) != (float)$values[$name])$this->SetValueFloat($Id, $values[$name]);
					}	
					if($type==3){
						if(GetValueString($Id) != (string)$values[$name])$this->SetValueString($Id, $values[$name]);
					}	
				}		
				return($Id);
		}
		return(false);
	}

	protected function maintain_variable_special($ident,$name,$type,$profil,$pos,$flag,$values){

		$general = @IPS_GetProperty($this->GetBridge(), $ident);
		$single = @IPS_GetProperty($this->InstanceID, $ident);

		if($name=="lastupdated" && @$this->ReadPropertyInteger('PlugId')){
			
			if (!$general && !$single) {			
				$this->UnregisterVariable($ident);
				return(false);
			} elseif ($general && !$single) {				
				$this->UnregisterVariable($ident);
				return(false);
			}
			
			$id1 = $this->ReadPropertyInteger('PlugId');

			$val=$this->get_powersensor($id1,$name);				
			$val=$val['lastupdated'];
				
			$Id = @$this->GetIDForIdent($ident);
			if(!$Id){
				$this->MaintainVariable($ident, $this->Translate($name),$type ,$profil, $pos,$flag);
				$Id = @$this->GetIDForIdent($ident);
			}
			$old=GetValueString($Id);
			
			if($Id && $old != (string)$val)$this->SetValueString($Id, $val);
			
			return($Id);
		}

		if($name =="alert"){
			
			if (!$general && !$single) {			
				$this->UnregisterVariable($ident);
				return(false);
			} elseif ($general && !$single) {				
				$this->UnregisterVariable($ident);
				return(false);
			}
			$val =$values["alert"];
			if($val=="none")$n=1;
			if($val=="select")$n=2;
			if($val=="lselect")$n=3;

			$Id = @$this->GetIDForIdent($ident);
			if(!$Id){
				$this->MaintainVariable($ident, $this->Translate($name),$type ,$profil, $pos,$flag);
				$Id = @$this->GetIDForIdent($ident);
			}
			$old=GetValueFloat($Id);
			if($Id && $old != (float)$n)$this->SetValueFloat($Id, $n);
			return($Id);
		}


		if($name =="effect"){
			
			if (!$general && !$single) {			
				$this->UnregisterVariable($ident);
				return(false);
			} elseif ($general && !$single) {				
				$this->UnregisterVariable($ident);
				return(false);
			}
			$val =@$values["effect"];
			$n=0;
			if($val=="none")$n=1;
			if($val=="colorloop")$n=2;

			$Id = @$this->GetIDForIdent($ident);
			if(!$Id){
				$this->MaintainVariable($ident, $this->Translate($name),$type ,$profil, $pos,$flag);
				$Id = @$this->GetIDForIdent($ident);
			}
			$old=GetValueFloat($Id);
			if($Id && $old != (float)$n)$this->SetValueFloat($Id, $n);
			return($Id);
		}
		
//der Rest power,curent,consumption,voltage
		
			if (!$general && !$single) {			
				$this->UnregisterVariable($ident);
				return(false);
			} elseif ($general && !$single) {				
				$this->UnregisterVariable($ident);
				return(false);
			}
			
			$id1 = $this->ReadPropertyInteger('PlugId');
			$val=$this->get_powersensor($id1,$name);				
			$val=$val[$name];
			
			//existiert...
			if(isset($val)){
				$Id = @$this->GetIDForIdent($ident);
				if(!$Id){
					$this->MaintainVariable($ident, $this->Translate($name),$type ,$profil, $pos,$flag);
					$Id = @$this->GetIDForIdent($ident);
				}
				$old=GetValueFloat($Id);
				if($Id && $old != (float)$val)$this->SetValueFloat($Id, $val);
				return($Id);
			}	
			
	
	}
	
//for combined sensors to get config parameters (motion,temp,light etc.)

	protected function get_sensors($searchid){
	
	$lights = RB_Request($this->GetBridge(), '/sensors', null);
	
	$Sensor_List = array();
	$Sensor = array();
	$searchuni=null;
	
	if ($lights) {	
		foreach ($lights as $lightId => $light) {
			$uniqueId = (string)$light->uniqueid;		
			$uni = substr($uniqueId, 0, 26);	
			//$uni = $uniqueId;	gerade
			if($lightId == $searchid){
				$searchuni=$uni;
				break;
			}	
		}
		if($searchuni){
			foreach ($lights as $lightId => $light) {
				$uniqueId = (string)$light->uniqueid;
				$type = (string)$light->type;						
				$sensitivity = @$light->config->sensitivity;		
				$sensitivitymax = @$light->config->sensitivitymax;		
				$ledindication = @$light->config->ledindication;		
				$delay = @$light->config->delay;		
				$duration = @$light->config->duration;		
				$offset = @$light->config->offset;		
				$uni = substr($uniqueId, 0, 26);	
				//$uni = $uniqueId;	
				if($searchuni == $uni){
					$Sensor = array(
						'Id' => $lightId,
						'uni' => $uni,
						'uniqueid' => $uniqueId,
						'type' => $type,
						'offset' =>$offset,
						'sensitivity' =>$sensitivity,
						'sensitivitymax' =>$sensitivitymax,
						'ledindication' =>$ledindication,						
						'delay' =>$delay,					
						'duration' =>$duration					
					);
					$Sensor_List[]=$Sensor;
				}
			}
		}		
	}	
	return($Sensor_List);
 }
 
 
    protected function check_plug_light($bri,$type){
			
		if (!$bri)return("plug");
		$pos=strpos($type,"plug");
		if ($pos)return("plug"); 			
		return("light");
	}

	protected function get_powersensor($searchid,$val){	
		$lights = RB_Request($this->GetBridge(), '/lights', null);
		if ($lights) {	
			foreach ($lights as $lightId => $light) {
				$bri = (string)@$light->state->bri;
				$uniqueId = (string)$light->uniqueid;
				$uni = substr($uniqueId, 0, 26);	
				$type=(string)@$light->type;
				$plug_light=$this->check_plug_light($bri,$type);
				if($plug_light=="light")continue;
				if($lightId == $searchid){
					$searchuni=$uni;
					break;
				}	
			}
		}	
		if($searchuni){
			$lights = RB_Request($this->GetBridge(), '/sensors', null);
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
									if(@(float)$value['mult_factor'] >0)
										@$Sensor[$val]=@$Sensor[$val]*@$value['mult_factor'];
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

    protected function Request_change(string $path, array $data = null){

			
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
		
		$r=array();	
		$r['status'] = $status;
		if ($result){
			$result=json_decode($result,true);
			if(@isset($result[0]['error']['description'])){
				$result=$result[0]['error']['description'];
				$r['result'] = $result;
			}else{
				
				if(@isset($result[0]['success'])){
					$r['result'] = $result[0]['success'];
					$r['status'] = "OK";
				}
			}
		}else{
			$r['result'] = "unbekannter Fehler";
			
		}
		return $r;
	}

protected function time2string($time) {
    $d = floor($time/86400);
    $_d = ($d < 10 ? '0' : '').$d;

    $h = floor(($time-$d*86400)/3600);
    $_h = ($h < 10 ? '0' : '').$h;

    $m = floor(($time-($d*86400+$h*3600))/60);
    $_m = ($m < 10 ? '0' : '').$m;

    $s = $time-($d*86400+$h*3600+$m*60);
    $_s = ($s < 10 ? '0' : '').$s;

    $time_str = $_d.':'.$_h.':'.$_m.':'.$_s;

    return $time_str;
}



protected function get_timestamp($l1){

$r1=explode("T",$l1);
$datum1=$r1[0];

$rx=explode("-",$datum1);
$y1=$rx[0];
$m1=$rx[1];
$d1=$rx[2];

$zeit1=$r1[1];
$rx=explode(":",$zeit1);
$h1=$rx[0];
$mi1=$rx[1];
$s1=$rx[2];
$timestamp = mktime($h1,$mi1,$s1,$m1,$d1,$y1);
return($timestamp);
}

 
}

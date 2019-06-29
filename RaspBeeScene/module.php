<?php

require_once __DIR__ . "/../libs/RaspBeeDevice.php";
//require_once ('/var/www/variables.php');
class RaspBeeScene extends RaspBeeDevice
{
    public function Create()
    {
        parent::Create();
        $this->RegisterPropertyString('SceneId', '');
		$this->RegisterPropertyString('SceneName', '');
		$this->RegisterPropertyInteger('Id', 0);
        $this->RegisterPropertyString('GroupId', '');
		$this->RegisterPropertyString('Group_Name', '');
		$this->RegisterPropertyBoolean('GROUPNAME',true);				
		$this->RegisterPropertyBoolean('ON',true);					
		//$this->RegisterPropertyBoolean('TRANSITIONTIME',true);					
		
    }

    protected function BasePath()
    {
        $groupid = $this->ReadPropertyString('GroupId');
		$id = $this->ReadPropertyInteger('Id');
		$sceneid = $this->ReadPropertyString('SceneId');
		return "/groups/$groupid/scenes/$id";
    }
	
	    public function GetConfigurationForm()
    {
		
		$Liste = array();

		$data = json_decode(file_get_contents(__DIR__ . "/form.json"), true);		

        $groupid = $this->ReadPropertyString('GroupId');
		$id = $this->ReadPropertyInteger('Id');
		$sceneid = $this->ReadPropertyString('SceneId');



		$L = array('type' => 'ValidationTextBox','name' => "Id",'caption' => "Scene Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "SceneName",'caption' => "Scene Name");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "GroupId",'caption' => "Group Id");
		$Liste[]=$L;
		$L = array('type' => 'ValidationTextBox','name' => "Group_Name",'caption' => "Group Name");
		$Liste[]=$L;

				$L = array(
						'type' => 'CheckBox',
						'name' => "GROUPNAME",
						'caption' => "GROUPNAME"
				);
				$Liste[]=$L;

				$L = array(
						'type' => 'CheckBox',
						'name' => "ON",
						'caption' => "CALL"
				);
				
				$Liste[]=$L;
				/*$L = array(
						'type' => 'CheckBox',
						'name' => "TRANSITIONTIME",
						'caption' => "TRANSITIONTIME"
				);
				$Liste[]=$L;*/

		$Liste1 =array(
			'elements' => $Liste
		);

		$data = array_merge($data, $Liste1);		
		
		$lights = RB_Request($this->GetBridge_Conf_scene(),'/groups/'.$groupid.'/scenes/'.$id,NULL);
		$lights=json_encode($lights,true);
		$lights=json_decode($lights,true);

		
		$Liste=array();
		
		$t=-1;	
		$lights=$lights['lights'];
		foreach ($lights as $lightId =>$value) {			
			if(@$value['bri']){
				$bri=@$value['bri'];
				$hue=@$value['hue'];				
				$sat=@$value['sat'];				
				$ct=@$value['ct'];
				$colormode=@$value['colormode'];
				$transtime=@$value['transitiontime'];
				$x=@$value['x'];
				$y=@$value['y'];

			}else{
				$bri=null;
				$ct=null;
				$colormode=null;
				$transtime=null;
			}

			$light_id=@$value['id'];
			$reachable=@$value['reachable'];
			$on=@$value['on'];
			$light=$t;

			$lightsn = RB_Request($this->GetBridge_Conf_scene(),'/lights/'.$light_id,NULL);
			$lightsn=json_encode($lightsn,true);
			$lightsn=json_decode($lightsn,true);
			$name=$lightsn['name'];
			
			$t++;
            $Plug = array(
                'group' => $groupid,
				'scene' => $id,
				'scid' => $sceneid,
				'light' => $t,
				'bri' => $bri,
				'colormode' => $colormode,
                'ct' => $ct,
				'id' => $light_id,
				'name' => $name,
                'on' => $on,
				'sat' => $sat,
				'hue' => $hue,
				'x' => $x,
				'y' => $y,
				'reachable' => $reachable,
                'transtime' => $transtime
            );
			$Liste[] = $Plug;
			
		}			

		$data['actions'][1]['values'] = array_merge($data['actions'][1]['values'], $Liste);

		return json_encode($data);
		

	}
	
    protected function GetBridge_Conf_scene()
    {
        $instance = IPS_GetInstance($this->InstanceID);
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }
	

}

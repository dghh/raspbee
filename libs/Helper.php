<?php
/*
 *
 */
 
 
if (!defined("IPS_BASE")) {
    // --- BASE MESSAGE
    define('IPS_BASE', 10000);                             //Base Message
    define('IPS_KERNELSTARTED', IPS_BASE + 1);             //Post Ready Message
    define('IPS_KERNELSHUTDOWN', IPS_BASE + 2);            //Pre Shutdown Message, Runlevel UNINIT Follows
}
if (!defined("IPS_KERNELMESSAGE")) {
    // --- KERNEL
    define('IPS_KERNELMESSAGE', IPS_BASE + 100);           //Kernel Message
    define('KR_CREATE', IPS_KERNELMESSAGE + 1);            //Kernel is beeing created
    define('KR_INIT', IPS_KERNELMESSAGE + 2);              //Kernel Components are beeing initialised, Modules loaded, Settings read
    define('KR_READY', IPS_KERNELMESSAGE + 3);             //Kernel is ready and running
    define('KR_UNINIT', IPS_KERNELMESSAGE + 4);            //Got Shutdown Message, unloading all stuff
    define('KR_SHUTDOWN', IPS_KERNELMESSAGE + 5);          //Uninit Complete, Destroying Kernel Inteface
}
if (!defined("IPS_LOGMESSAGE")) {
    // --- KERNEL LOGMESSAGE
    define('IPS_LOGMESSAGE', IPS_BASE + 200);              //Logmessage Message
    define('KL_MESSAGE', IPS_LOGMESSAGE + 1);              //Normal Message                      | FG: Black | BG: White  | STLYE : NONE
    define('KL_SUCCESS', IPS_LOGMESSAGE + 2);              //Success Message                     | FG: Black | BG: Green  | STYLE : NONE
    define('KL_NOTIFY', IPS_LOGMESSAGE + 3);               //Notiy about Changes                 | FG: Black | BG: Blue   | STLYE : NONE
    define('KL_WARNING', IPS_LOGMESSAGE + 4);              //Warnings                            | FG: Black | BG: Yellow | STLYE : NONE
    define('KL_ERROR', IPS_LOGMESSAGE + 5);                //Error Message                       | FG: Black | BG: Red    | STLYE : BOLD
    define('KL_DEBUG', IPS_LOGMESSAGE + 6);                //Debug Informations + Script Results | FG: Grey  | BG: White  | STLYE : NONE
    define('KL_CUSTOM', IPS_LOGMESSAGE + 7);               //User Message                        | FG: Black | BG: White  | STLYE : NONE
}
if (!defined("IPS_MODULEMESSAGE")) {
    // --- MODULE LOADER
    define('IPS_MODULEMESSAGE', IPS_BASE + 300);           //ModuleLoader Message
    define('ML_LOAD', IPS_MODULEMESSAGE + 1);              //Module loaded
    define('ML_UNLOAD', IPS_MODULEMESSAGE + 2);            //Module unloaded
}
if (!defined("IPS_OBJECTMESSAGE")) {
    // --- OBJECT MANAGER
    define('IPS_OBJECTMESSAGE', IPS_BASE + 400);
    define('OM_REGISTER', IPS_OBJECTMESSAGE + 1);          //Object was registered
    define('OM_UNREGISTER', IPS_OBJECTMESSAGE + 2);        //Object was unregistered
    define('OM_CHANGEPARENT', IPS_OBJECTMESSAGE + 3);      //Parent was Changed
    define('OM_CHANGENAME', IPS_OBJECTMESSAGE + 4);        //Name was Changed
    define('OM_CHANGEINFO', IPS_OBJECTMESSAGE + 5);        //Info was Changed
    define('OM_CHANGETYPE', IPS_OBJECTMESSAGE + 6);        //Type was Changed
    define('OM_CHANGESUMMARY', IPS_OBJECTMESSAGE + 7);     //Summary was Changed
    define('OM_CHANGEPOSITION', IPS_OBJECTMESSAGE + 8);    //Position was Changed
    define('OM_CHANGEREADONLY', IPS_OBJECTMESSAGE + 9);    //ReadOnly was Changed
    define('OM_CHANGEHIDDEN', IPS_OBJECTMESSAGE + 10);     //Hidden was Changed
    define('OM_CHANGEICON', IPS_OBJECTMESSAGE + 11);       //Icon was Changed
    define('OM_CHILDADDED', IPS_OBJECTMESSAGE + 12);       //Child for Object was added
    define('OM_CHILDREMOVED', IPS_OBJECTMESSAGE + 13);     //Child for Object was removed
    define('OM_CHANGEIDENT', IPS_OBJECTMESSAGE + 14);      //Ident was Changed
}
if (!defined("IPS_INSTANCEMESSAGE")) {
    // --- INSTANCE MANAGER
    define('IPS_INSTANCEMESSAGE', IPS_BASE + 500);         //Instance Manager Message
    define('IM_CREATE', IPS_INSTANCEMESSAGE + 1);          //Instance created
    define('IM_DELETE', IPS_INSTANCEMESSAGE + 2);          //Instance deleted
    define('IM_CONNECT', IPS_INSTANCEMESSAGE + 3);         //Instance connectged
    define('IM_DISCONNECT', IPS_INSTANCEMESSAGE + 4);      //Instance disconncted
    define('IM_CHANGESTATUS', IPS_INSTANCEMESSAGE + 5);    //Status was Changed
    define('IM_CHANGESETTINGS', IPS_INSTANCEMESSAGE + 6);  //Settings were Changed
    define('IM_CHANGESEARCH', IPS_INSTANCEMESSAGE + 7);    //Searching was started/stopped
    define('IM_SEARCHUPDATE', IPS_INSTANCEMESSAGE + 8);    //Searching found new results
    define('IM_SEARCHPROGRESS', IPS_INSTANCEMESSAGE + 9);  //Searching progress in %
    define('IM_SEARCHCOMPLETE', IPS_INSTANCEMESSAGE + 10); //Searching is complete
}
if (!defined("IPS_VARIABLEMESSAGE")) {
    // --- VARIABLE MANAGER
    define('IPS_VARIABLEMESSAGE', IPS_BASE + 600);              //Variable Manager Message
    define('VM_CREATE', IPS_VARIABLEMESSAGE + 1);               //Variable Created
    define('VM_DELETE', IPS_VARIABLEMESSAGE + 2);               //Variable Deleted
    define('VM_UPDATE', IPS_VARIABLEMESSAGE + 3);               //On Variable Update
    define('VM_CHANGEPROFILENAME', IPS_VARIABLEMESSAGE + 4);    //On Profile Name Change
    define('VM_CHANGEPROFILEACTION', IPS_VARIABLEMESSAGE + 5);  //On Profile Action Change
}
if (!defined("IPS_SCRIPTMESSAGE")) {
    // --- SCRIPT MANAGER
    define('IPS_SCRIPTMESSAGE', IPS_BASE + 700);           //Script Manager Message
    define('SM_CREATE', IPS_SCRIPTMESSAGE + 1);            //On Script Create
    define('SM_DELETE', IPS_SCRIPTMESSAGE + 2);            //On Script Delete
    define('SM_CHANGEFILE', IPS_SCRIPTMESSAGE + 3);        //On Script File changed
    define('SM_BROKEN', IPS_SCRIPTMESSAGE + 4);            //Script Broken Status changed
}
if (!defined("IPS_EVENTMESSAGE")) {
    // --- EVENT MANAGER
    define('IPS_EVENTMESSAGE', IPS_BASE + 800);             //Event Scripter Message
    define('EM_CREATE', IPS_EVENTMESSAGE + 1);             //On Event Create
    define('EM_DELETE', IPS_EVENTMESSAGE + 2);             //On Event Delete
    define('EM_UPDATE', IPS_EVENTMESSAGE + 3);
    define('EM_CHANGEACTIVE', IPS_EVENTMESSAGE + 4);
    define('EM_CHANGELIMIT', IPS_EVENTMESSAGE + 5);
    define('EM_CHANGESCRIPT', IPS_EVENTMESSAGE + 6);
    define('EM_CHANGETRIGGER', IPS_EVENTMESSAGE + 7);
    define('EM_CHANGETRIGGERVALUE', IPS_EVENTMESSAGE + 8);
    define('EM_CHANGETRIGGEREXECUTION', IPS_EVENTMESSAGE + 9);
    define('EM_CHANGECYCLIC', IPS_EVENTMESSAGE + 10);
    define('EM_CHANGECYCLICDATEFROM', IPS_EVENTMESSAGE + 11);
    define('EM_CHANGECYCLICDATETO', IPS_EVENTMESSAGE + 12);
    define('EM_CHANGECYCLICTIMEFROM', IPS_EVENTMESSAGE + 13);
    define('EM_CHANGECYCLICTIMETO', IPS_EVENTMESSAGE + 14);
}
if (!defined("IPS_MEDIAMESSAGE")) {
    // --- MEDIA MANAGER
    define('IPS_MEDIAMESSAGE', IPS_BASE + 900);           //Media Manager Message
    define('MM_CREATE', IPS_MEDIAMESSAGE + 1);             //On Media Create
    define('MM_DELETE', IPS_MEDIAMESSAGE + 2);             //On Media Delete
    define('MM_CHANGEFILE', IPS_MEDIAMESSAGE + 3);         //On Media File changed
    define('MM_AVAILABLE', IPS_MEDIAMESSAGE + 4);          //Media Available Status changed
    define('MM_UPDATE', IPS_MEDIAMESSAGE + 5);
}
if (!defined("IPS_LINKMESSAGE")) {
    // --- LINK MANAGER
    define('IPS_LINKMESSAGE', IPS_BASE + 1000);           //Link Manager Message
    define('LM_CREATE', IPS_LINKMESSAGE + 1);             //On Link Create
    define('LM_DELETE', IPS_LINKMESSAGE + 2);             //On Link Delete
    define('LM_CHANGETARGET', IPS_LINKMESSAGE + 3);       //On Link TargetID change
}
if (!defined("IPS_FLOWMESSAGE")) {
    // --- DATA HANDLER
    define('IPS_FLOWMESSAGE', IPS_BASE + 1100);             //Data Handler Message
    define('FM_CONNECT', IPS_FLOWMESSAGE + 1);             //On Instance Connect
    define('FM_DISCONNECT', IPS_FLOWMESSAGE + 2);          //On Instance Disconnect
}
if (!defined("IPS_ENGINEMESSAGE")) {
    // --- SCRIPT ENGINE
    define('IPS_ENGINEMESSAGE', IPS_BASE + 1200);           //Script Engine Message
    define('SE_UPDATE', IPS_ENGINEMESSAGE + 1);             //On Library Refresh
    define('SE_EXECUTE', IPS_ENGINEMESSAGE + 2);            //On Script Finished execution
    define('SE_RUNNING', IPS_ENGINEMESSAGE + 3);            //On Script Started execution
}
if (!defined("IPS_PROFILEMESSAGE")) {
    // --- PROFILE POOL
    define('IPS_PROFILEMESSAGE', IPS_BASE + 1300);
    define('PM_CREATE', IPS_PROFILEMESSAGE + 1);
    define('PM_DELETE', IPS_PROFILEMESSAGE + 2);
    define('PM_CHANGETEXT', IPS_PROFILEMESSAGE + 3);
    define('PM_CHANGEVALUES', IPS_PROFILEMESSAGE + 4);
    define('PM_CHANGEDIGITS', IPS_PROFILEMESSAGE + 5);
    define('PM_CHANGEICON', IPS_PROFILEMESSAGE + 6);
    define('PM_ASSOCIATIONADDED', IPS_PROFILEMESSAGE + 7);
    define('PM_ASSOCIATIONREMOVED', IPS_PROFILEMESSAGE + 8);
    define('PM_ASSOCIATIONCHANGED', IPS_PROFILEMESSAGE + 9);
}
if (!defined("IPS_TIMERMESSAGE")) {
    // --- TIMER POOL
    define('IPS_TIMERMESSAGE', IPS_BASE + 1400);            //Timer Pool Message
    define('TM_REGISTER', IPS_TIMERMESSAGE + 1);
    define('TM_UNREGISTER', IPS_TIMERMESSAGE + 2);
    define('TM_SETINTERVAL', IPS_TIMERMESSAGE + 3);
    define('TM_UPDATE', IPS_TIMERMESSAGE + 4);
    define('TM_RUNNING', IPS_TIMERMESSAGE + 5);
}
if (!defined("IS_ACTIVE")) { //Nur wenn Konstanten noch nicht bekannt sind.
// --- STATUS CODES
    define('IS_SBASE', 100);
    define('IS_CREATING', IS_SBASE + 1); //module is being created
    define('IS_ACTIVE', IS_SBASE + 2); //module created and running
    define('IS_DELETING', IS_SBASE + 3); //module us being deleted
    define('IS_INACTIVE', IS_SBASE + 4); //module is not beeing used
// --- ERROR CODES
    define('IS_EBASE', 200);          //default errorcode
    define('IS_NOTCREATED', IS_EBASE + 1); //instance could not be created
}
if (!defined("vtBoolean")) { //Nur wenn Konstanten noch nicht bekannt sind.
    define('vtBoolean', 0);
    define('vtInteger', 1);
    define('vtFloat', 2);
    define('vtString', 3);
}

//test ob man mit konfigurationsfile arbeiten kann um unbekannte devices ohne programmänderung hinzuzufügen
//*****************************************************************************************************
//*****************************************************************************************************
//*****************************************************************************************************

if (!defined("D_LIGHT")) {
	define('D_LIGHT', json_encode(array(
	'ON'=>array('choose'=>true,'ident'=>"ON",'original'=>'on','type'=>vtBoolean,'profile'=>"~Switch",'pos'=>1,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'COLORMODE'=>array('choose'=>true,'ident'=>"COLORMODE",'original'=>'colormode','type'=>vtInteger,'profile'=>"ColorModeSelect.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'CT'=>array('choose'=>true,'ident'=>"CT",'original'=>'ct','type'=>vtInteger,'profile'=>"ColorTemperatureSelect.RaspBee",'pos'=>4,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SAT'=>array('choose'=>true,'ident'=>"SAT",'original'=>'sat','type'=>vtInteger,'profile'=>"Intensity.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'BRI'=>array('choose'=>true,'ident'=>"BRI",'original'=>'bri','type'=>vtInteger,'profile'=>"Intensity.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'HUE'=>array('choose'=>true,'ident'=>"HUE",'original'=>'hue','type'=>vtInteger,'profile'=>"",'pos'=>20,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'REACHABLE'=>array('choose'=>true,'ident'=>"REACHABLE",'original'=>'reachable','type'=>vtBoolean,'profile'=>"",'pos'=>22,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'ALERT'=>array('choose'=>false,'ident'=>"ALERT",'original'=>'alert','type'=>vtFloat,'profile'=>"Alert.RaspBee",'pos'=>23,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'EFFECT'=>array('choose'=>false,'ident'=>"EFFECT",'original'=>'effect','type'=>vtFloat,'profile'=>"Effect.RaspBee",'pos'=>24,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0))
	));
}
if (!defined("D_PLUG")) {
	define('D_PLUG', json_encode(array(
	'ON'=>array('choose'=>true,'ident'=>"ON",'original'=>'on','type'=>vtBoolean,'profile'=>"~Switch",'pos'=>1,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'REACHABLE'=>array('choose'=>true,'ident'=>"REACHABLE",'original'=>'reachable','type'=>vtBoolean,'profile'=>"",'pos'=>22,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'ALERT'=>array('choose'=>false,'ident'=>"ALERT",'original'=>'alert','type'=>vtFloat,'profile'=>"Alert.RaspBee",'pos'=>23,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'CONSUMPTION'=>array('choose'=>false,'ident'=>"CONSUMPTION",'original'=>'consumption','type'=>vtFloat,'profile'=>"Consumption.RaspBee",'pos'=>25,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0.01),
	'CURRENT'=>array('choose'=>false,'ident'=>"CURRENT",'original'=>'current','type'=>vtFloat,'profile'=>"Current.RaspBee",'pos'=>26,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0.01),
	'VOLTAGE'=>array('choose'=>false,'ident'=>"VOLTAGE",'original'=>'voltage','type'=>vtFloat,'profile'=>"Voltage.RaspBee",'pos'=>27,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'POWER'=>array('choose'=>false,'ident'=>"POWER",'original'=>'power','type'=>vtFloat,'profile'=>"~Watt.3680",'pos'=>24,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0))
	));
}

if (!defined("D_SENSOR")) {
	define('D_SENSOR', json_encode(array(
	'DARK'=>array('choose'=>false,'ident'=>"DARK",'original'=>'dark','type'=>vtBoolean,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'DAYLIGHT'=>array('choose'=>false,'ident'=>"DAYLIGHT",'original'=>'daylight','type'=>vtBoolean,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'SUNRISEOFFSET'=>array('choose'=>true,'ident'=>"SUNRISEOFFSET",'original'=>'sunriseoffset','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SUNSETOFFSET'=>array('choose'=>true,'ident'=>"SUNSETOFFSET",'original'=>'sunsetoffset','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'STATUS'=>array('choose'=>false,'ident'=>"STATUS",'original'=>'status','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'BUTTONEVENT'=>array('choose'=>true,'ident'=>"BUTTONEVENT",'original'=>'buttonevent','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'GROUP'=>array('choose'=>false,'ident'=>"GROUP",'original'=>'group','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LIGHTLEVEL'=>array('choose'=>true,'ident'=>"LIGHTLEVEL",'original'=>'lightlevel','type'=>vtFloat,'profile'=>"~Illumination.F",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'HUMIDITY'=>array('choose'=>true,'ident'=>"HUMIDITY",'original'=>'humidity','type'=>vtFloat,'profile'=>"~Humidity.F",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'OPEN'=>array('choose'=>true,'ident'=>"OPEN",'original'=>'open','type'=>vtBoolean,'profile'=>"~Lock",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LUX'=>array('choose'=>false,'ident'=>"LUX",'original'=>'lux','type'=>vtFloat,'profile'=>"~Illumination.F",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'TEMPERATURE'=>array('choose'=>true,'ident'=>"TEMPERATURE",'original'=>'temperature','type'=>vtFloat,'profile'=>"~Temperature",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0.01),
	'OFFSET'=>array('choose'=>false,'ident'=>"OFFSET",'original'=>'offset','type'=>vtFloat,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'PRESENCE'=>array('choose'=>true,'ident'=>"PRESENCE",'original'=>'presence','type'=>vtBoolean,'profile'=>"~Motion",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'BATTERY'=>array('choose'=>false,'ident'=>"BATTERY",'original'=>'battery','type'=>vtInteger,'profile'=>"~Battery.100",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LOWBATTERY'=>array('choose'=>false,'ident'=>"LOWBATTERY",'original'=>'lowbattery','type'=>vtBoolean,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'DELAY'=>array('choose'=>false,'ident'=>"DELAY",'original'=>'delay','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'DURATION'=>array('choose'=>false,'ident'=>"DURATION",'original'=>'duration','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SENSITIVITY'=>array('choose'=>false,'ident'=>"SENSITIVITY",'original'=>'sensitivity','type'=>vtInteger,'profile'=>"Sensitivity.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SENSITIVITYMAX'=>array('choose'=>false,'ident'=>"SENSITIVITYMAX",'original'=>'sensitivitymax','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LASTUPDATED'=>array('choose'=>false,'ident'=>"LASTUPDATED",'original'=>'lastupdated','type'=>vtString,'profile'=>"",'pos'=>24,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'CONSUMPTION'=>array('choose'=>true,'ident'=>"CONSUMPTION",'original'=>'consumption','type'=>vtFloat,'profile'=>"Consumption.RaspBee",'pos'=>25,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0.01),
	'CURRENT'=>array('choose'=>true,'ident'=>"CURRENT",'original'=>'current','type'=>vtFloat,'profile'=>"Current.RaspBee",'pos'=>26,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0.01),
	'VOLTAGE'=>array('choose'=>true,'ident'=>"VOLTAGE",'original'=>'voltage','type'=>vtFloat,'profile'=>"Voltage.RaspBee",'pos'=>27,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LEDINDICATION'=>array('choose'=>false,'ident'=>"LEDINDICATION",'original'=>'ledindication','type'=>vtBoolean,'profile'=>"~switch",'pos'=>29,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'POWER'=>array('choose'=>true,'ident'=>"POWER",'original'=>'power','type'=>vtFloat,'profile'=>"~Watt.3680",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'ALARM'=>array('choose'=>true,'ident'=>"ALARM",'original'=>'alarm','type'=>vtString,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'CARBONMONOXIDE'=>array('choose'=>true,'ident'=>"CARBONMONOXIDE",'original'=>'carbonmonoxide','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'FIRE'=>array('choose'=>true,'ident'=>"FIRE",'original'=>'fire','type'=>vtString,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
/*	'THOLDDARK'=>array('choose'=>true,'ident'=>"THOLDDARK",'original'=>'tholddark','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'THOLDDARK'=>array('choose'=>true,'ident'=>"THOLDDARK",'original'=>'tholddark','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'THOLDOFFSET'=>array('choose'=>true,'ident'=>"THOLDOFFSET",'original'=>'tholdoffset','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),*/
	'OPEN'=>array('choose'=>true,'ident'=>"OPEN",'original'=>'open','type'=>vtBoolean,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'PRESSURE'=>array('choose'=>true,'ident'=>"PRESSURE",'original'=>'pressure','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'HEATSETPOINT'=>array('choose'=>true,'ident'=>"HEATSETPOINT",'original'=>'heatsetpoint','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'LOCKED'=>array('choose'=>true,'ident'=>"LOCKED",'original'=>'locked','type'=>vtBoolean,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'MODE'=>array('choose'=>true,'ident'=>"MODE",'original'=>'mode','type'=>vtString,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'VALVE'=>array('choose'=>true,'ident'=>"VALVE",'original'=>'valve','type'=>vtFloat,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'ORIENTATION'=>array('choose'=>true,'ident'=>"ORIENTATION",'original'=>'orientation','type'=>vtString,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'VIBRATION'=>array('choose'=>true,'ident'=>"VIBRATION",'original'=>'vibration','type'=>vtBoolean,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'TAMPERED'=>array('choose'=>true,'ident'=>"TAMPERED",'original'=>'tampered','type'=>vtBoolean,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'WATER'=>array('choose'=>true,'ident'=>"WATER",'original'=>'water','type'=>vtBoolean,'profile'=>"",'pos'=>28,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0))
	));
}
if (!defined("D_SWITCH")) {
	define('D_SWITCH', json_encode(array(
	'BUTTONEVENT'=>array('choose'=>true,'ident'=>"BUTTONEVENT",'original'=>'buttonevent','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'GROUP'=>array('choose'=>false,'ident'=>"GROUP",'original'=>'group','type'=>vtInteger,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'BATTERY'=>array('choose'=>false,'ident'=>"BATTERY",'original'=>'battery','type'=>vtInteger,'profile'=>"~Battery.100",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'REACHABLE'=>array('choose'=>true,'ident'=>"REACHABLE",'original'=>'reachable','type'=>vtBoolean,'profile'=>"",'pos'=>22,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>false,'hidden'=>false,'mult_factor'=>0),
	'ON'=>array('choose'=>true,'ident'=>"ON",'original'=>'on','type'=>vtBoolean,'profile'=>"~Switch",'pos'=>1,'flag'=>true,
	'state'=>false,'config'=>true,'action'=>false,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'LASTUPDATED'=>array('choose'=>false,'ident'=>"LASTUPDATED",'original'=>'lastupdated','type'=>vtString,'profile'=>"",'pos'=>3,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>true,'mult_factor'=>0))
	));
}

if (!defined("D_GROUP")) {
	define('D_GROUP', json_encode(array(
	'ANY_ON'=>array('choose'=>false,'ident'=>"ANY_ON",'original'=>'any_on','type'=>vtBoolean,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>true,'mult_factor'=>0),
	'ALL_ON'=>array('choose'=>false,'ident'=>"ALL_ON",'original'=>'all_on','type'=>vtBoolean,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>true,'config'=>false,'action'=>false,'enableaction'=>false,'hidden'=>true,'mult_factor'=>0),
	'COLORMODE'=>array('choose'=>true,'ident'=>"COLORMODE",'original'=>'colormode','type'=>vtInteger,'profile'=>"ColorModeSelect.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'CT'=>array('choose'=>true,'ident'=>"CT",'original'=>'ct','type'=>vtInteger,'profile'=>"ColorTemperatureSelect.RaspBee",'pos'=>4,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SAT'=>array('choose'=>true,'ident'=>"SAT",'original'=>'sat','type'=>vtInteger,'profile'=>"Intensity.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'BRI'=>array('choose'=>true,'ident'=>"BRI",'original'=>'bri','type'=>vtInteger,'profile'=>"Intensity.RaspBee",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'HUE'=>array('choose'=>true,'ident'=>"HUE",'original'=>'hue','type'=>vtInteger,'profile'=>"",'pos'=>20,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'EFFECT'=>array('choose'=>false,'ident'=>"EFFECT",'original'=>'effect','type'=>vtFloat,'profile'=>"Effect.RaspBee",'pos'=>24,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'SCENE'=>array('choose'=>true,'ident'=>"SCENE",'original'=>'scene','type'=>vtString,'profile'=>"",'pos'=>2,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0),
	'ON'=>array('choose'=>true,'ident'=>"ON",'original'=>'on','type'=>vtBoolean,'profile'=>"~Switch",'pos'=>1,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0))
	));
}

if (!defined("D_SCENE")) {
	define('D_SCENE', json_encode(array(
	'ON'=>array('choose'=>true,'ident'=>"ON",'original'=>'on','type'=>vtBoolean,'profile'=>"~Switch",'pos'=>1,'flag'=>true,
	'state'=>false,'config'=>false,'action'=>true,'enableaction'=>true,'hidden'=>false,'mult_factor'=>0))
	));
}

//die Sensoren sollten funktionieren
if (!defined("ZHA_TYPES")) {
	define('ZHA_TYPES', json_encode(array(
	"ZHACarbonMonoxide"=>1,
	"DAYLight"=>1,
	"ZHAFire"=>1,
	"CLIPGenericFlag"=>1,
	"CLIPGenericStatus"=>1,
	"ZHAHumidity"=>1,
	"CLIPHumidity"=>1,
	"ZHALightLevel"=>1,
	"CLIPLightLevel"=>1,
	"ZHAOpenClose"=>1,
	"CLIPOpenClose"=>1,
	"ZHAPresence"=>1,
	"CLIPPresence"=>1,
	"ZHAPressure"=>1,
	"CLIPPressure"=>1,
	"ZGPSwitch"=>1,
	"CLIPSwitch"=>1,
	"ZHATemperature"=>1,
	"CLIPTemperature"=>1,
	"ZHAThermostat"=>1,
	"CLIPThermostat"=>1,
	"ZHAVibration"=>1,
	"ZHAWater"=>1,
	"ZHAAlarm"=>1,
	"ZHASwitch"=>1,
	"ZHAConsumption"=>1,
	"ZHAPower"=>1)
	));
}
				
//if =1 then combine under this device

/*if (!defined("SENSORS")) {
	define('SENSORS', json_encode(array(
	'Philips'=>array('modelid'=>"SML001",'ZHATemperature'=>1,'ZHAPresence'=>1,'ZHALightLevel'=>1))
//	'innr'=>array('modelid'=>"SP 120",'ZHAPower'=>1,'ZHAConsumption'=>1,'ZHALightLevel'=>0))
	));
	
}*/
//test
if (!defined("SPECIAL_TYPES")) {
	define('SPECIAL_TYPES', json_encode(array(
	//"CLIPGenericStatus"=>1,"ZHASwitch"=>1,"ZHAConsumption"=>1,"ZHAPower"=>1)
	"ZHASwitch"=>1,"ZHAConsumption"=>1,"ZHAPower"=>1)
	));
}

/*
Light level in 10000 log10 (lux) +1 measured by sensor. Logarithm scale used because the human eye adjusts to light levels and small changes at low lux levels are more noticeable than at high lux levels.
Example 									Lux 	MeasuredValue
Outdoor: Overcast moonless night sky 		0.0001 	0
Outdoor: Bright moonlight 						1 	1
Home: Night light							 	2 	3000
Home: Dimmed light							 	10 	10000
Home: ‘Cosy’ living room					 	50 	17000
Home: ‘Normal’ non-task light				 	150 	22000
Home: Working / reading 						350 	25500
Home: Specialized tasks, Inside daylight	 	700 	28500
Home: Maximum to avoid glare				 	2000 	33000
Outdoor: Clear daylight						 	> 10000 	> 40000
Outdoor: Brightest direct sunlight			 	120000 	51000

*/



//*****************************************************************************************************
//*****************************************************************************************************
//*****************************************************************************************************

function get_device_value($devices,$parameter,$detail){

		$devices_p=array();
		$devices_p=json_decode($devices,true);
		
		foreach ($devices_p as $deviceId => $d) {
			if($deviceId==$parameter && !$detail)return $devices_p[$deviceId];
			if($deviceId==$parameter && $detail)return $devices_p[$deviceId][$detail];				
		}
		return false;
}

/**
 * DebugHelper ergänzt SendDebug um die Möglichkeit Array und Objekte auszugeben.
 *
 */
 
 	function set_info_1($i1){

	
	if(!file_exists("/var/www/info.txt"))return;
	
	if($i1=="")
			return;
	
	date_default_timezone_set('Europe/Berlin');		
	
	$datum=date("d-m-Y H:i:s");

	if(!is_array($i1)){
		$datei = fopen("/var/www/info.txt","a");
		if(!$datei){
			fopen("/var/www/info.txt","w");
			system("sudo chmod 777 /var/www/info.txt");
			fclose($datei);
			$datei = fopen("/var/www/info.txt","a");
		}
		fwrite($datei, "\n"." * ".$datum." ".$i1);
		fclose($datei);
	}
	if(is_array($i1)){
		file_put_contents('/var/www/info.txt', "\n"." * ".$datum." ".$i1, FILE_APPEND);
	}
}	


function set_info_2($message,$Data){

	 if (is_object($Data)) {
            foreach ($Data as $Key => $DebugData) {
				IPS_LogMessage("RaspBee Debug: ", $Key."-->".$DebugData);
            }
        } elseif (is_array($Data)) {
            foreach ($Data as $Key => $DebugData) {
				IPS_LogMessage("RaspBee Debug: ", $Key."-->".$DebugData);
            }
        } elseif (is_bool($Data)) {
			IPS_LogMessage("RaspBee Debug: ", ($Data ? 'TRUE' : 'FALSE'));

	} else {
		IPS_LogMessage("RaspBee Debug: ", (string) $Data);
    }
}	
	
trait DebugHelper
{
    /**
     * Ergänzt SendDebug um Möglichkeit Objekte und Array auszugeben.
     *
     * @access protected
     * @param string $Message Nachricht für Data.
     * @param LMSResponse|LMSData|array|object|bool|string|int $Data Daten für die Ausgabe.
     * @return int $Format Ausgabeformat für Strings.
     */
    protected function SendDebug($Message, $Data, $Format)
    {
        if (is_a($Data, 'GHMessage')) {
            /* @var $Data GHMessage */
            $this->SendDebug($Message . "->Command", GHMessage::CMDtoString($Data->Command), 0);
            $this->SendDebug($Message . "->Payload", $Data->Payload, 1);
        } elseif (is_array($Data)) {
            foreach ($Data as $Key => $DebugData) {
                $this->SendDebug($Message . ":" . $Key, $DebugData, $Format);
            }
        } elseif (is_object($Data)) {
            foreach ($Data as $Key => $DebugData) {
                $this->SendDebug($Message . "->" . $Key, $DebugData, $Format);
            }
        } elseif (is_bool($Data)) {
            parent::SendDebug($Message, ($Data ? 'TRUE' : 'FALSE'), 0);
        } else {
            parent::SendDebug($Message, (string) $Data, $Format);
        }
    }
}
/**
 * Trait mit Hilfsfunktionen für den Datenaustausch.
 * @property integer $ParentID
 */
trait InstanceStatus
{
    /**
     * Interne Funktion des SDK.
     *
     * @access public
     */
    protected function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    {
        switch ($Message) {
            case FM_CONNECT:
/*                $this->RegisterParent();
                if ($this->HasActiveParent()) {
                    $this->IOChangeState(IS_ACTIVE);
                } else {
                    $this->IOChangeState(IS_INACTIVE);
                }*/
                break;
            case FM_DISCONNECT:
/*                $this->RegisterParent();
                $this->IOChangeState(IS_INACTIVE);*/
                break;
            case IM_CHANGESTATUS:
/*                if ($SenderID == $this->ParentID) {
                    $this->IOChangeState($Data[0]);
                }*/
                break;
        }
		
    }
    /**
     * Ermittelt den Parent und verwaltet die Einträge des Parent im MessageSink
     * Ermöglicht es das Statusänderungen des Parent empfangen werden können.
     *
     * @access protected
     * @return int ID des Parent.
     */
    protected function RegisterParent()
    {
/*        $OldParentId = $this->ParentID;
        $ParentId = @IPS_GetInstance($this->InstanceID)['ConnectionID'];
        if ($ParentId <> $OldParentId) {
            if ($OldParentId > 0) {
                $this->UnregisterMessage($OldParentId, IM_CHANGESTATUS);
            }
            if ($ParentId > 0) {
                $this->RegisterMessage($ParentId, IM_CHANGESTATUS);
            } else {
                $ParentId = 0;
            }
            $this->ParentID = $ParentId;
        }
        return $ParentId;
		*/
    }
    /**
     * Prüft den Parent auf vorhandensein und Status.
     *
     * @access protected
     * @return bool True wenn Parent vorhanden und in Status 102, sonst false.
     */
    protected function HasActiveParent()
    {
    /*    $instance = IPS_GetInstance($this->InstanceID);
        if ($instance['ConnectionID'] > 0) {
            $parent = IPS_GetInstance($instance['ConnectionID']);
            if ($parent['InstanceStatus'] == 102) {
                return true;
            }
        }
        return false;*/
    }
}
/**
 * Trait welcher Objekt-Eigenschaften in den Instance-Buffer schreiben und lesen kann.
 */
trait BufferHelper
{
    /**
     * Wert einer Eigenschaft aus den InstanceBuffer lesen.
     *
     * @access public
     * @param string $name Propertyname
     * @return mixed Value of Name
     */
    public function __get($name)
    {
        if (strpos($name, 'Multi_') === 0) {
            $Lines = "";
            foreach ($this->{"BufferListe_" . $name} as $BufferIndex) {
                $Lines .= $this->{'Part_' . $name . $BufferIndex};
            }
            return unserialize($Lines);
        }
        return unserialize($this->GetBuffer($name));
    }
    /**
     * Wert einer Eigenschaft in den InstanceBuffer schreiben.
     *
     * @access public
     * @param string $name Propertyname
     * @param mixed Value of Name
     */
    public function __set($name, $value)
    {
        $Data = serialize($value);
        if (strpos($name, 'Multi_') === 0) {
            $OldBuffers = $this->{"BufferListe_" . $name};
            if ($OldBuffers == false) {
                $OldBuffers = array();
            }
            $Lines = str_split($Data, 8000);
            foreach ($Lines as $BufferIndex => $BufferLine) {
                $this->{'Part_' . $name . $BufferIndex} = $BufferLine;
            }
            $NewBuffers = array_keys($Lines);
            $this->{"BufferListe_" . $name} = $NewBuffers;
            $DelBuffers = array_diff_key($OldBuffers, $NewBuffers);
            foreach ($DelBuffers as $DelBuffer) {
                $this->{'Part_' . $name . $DelBuffer} = "";
            }
            return;
        }
        $this->SetBuffer($name, $Data);
    }
}

/** @} */
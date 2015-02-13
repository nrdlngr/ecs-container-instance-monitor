<?php
require 'Utils/Config.class.php';
$Config = new Config();


$datas = array();

if (count($Config->get('services')) > 0)
{
    foreach ($Config->get('services') as $service)
    {
        $host = $service['host'];
        $command = $service['command'];
        $expected_response = $service['expected_response'];
        
        exec("$command", $output, $return);
		$pos = strpos($output, $expected_response);
		if ($pos === false)
			{
            $datas[] = array(
                'port'      => $service['port'],
                'name'      => $service['name'],
                'status'    => 0,
            );
        	}
		else
			{
            $datas[] = array(
                'port'      => $service['port'],
                'name'      => $service['name'],
                'status'    => 1,
            );
        	}
        unset($output);
    }
}


echo json_encode($datas);
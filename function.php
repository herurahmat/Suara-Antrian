<?php
function audio_list()
{
	$output=array();
	$directory = 'audio/';
	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	foreach($scanned_directory as $r)
	{
		$ext=pathinfo($r,PATHINFO_EXTENSION);
		if(in_array($ext,array("MP3","mp3","wav")))
		{
			$explode=explode(".",$r);
			$ID=$explode[0];
			$output[]=array(
				'path'=>$directory.$r,
				'file'=>$r,
				'ID'=>$ID,
			);
		}
	}
	return $output;
}
?>
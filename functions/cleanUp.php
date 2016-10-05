<?php function cleanUp()
{
    $files =scandir ( __DIR__);

    foreach ($files as $file)
    {
        if(strrpos($file,'.xls') !=false)
        {
            $url =  __DIR__.'/'. $file  ;
            unlink($url);
        }
    }

}
?>

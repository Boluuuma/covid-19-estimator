<?php

class DumpHTTPRequestToFile 
{

  
  public function execute($targetFile) {
    $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    $data = sprintf(
      "%s %s %s %s %s\n\n",
      $_SERVER['REQUEST_METHOD'],
      $_SERVER['REQUEST_URI'],
      $_SERVER['REQUEST_TIME_FLOAT'],
      http_response_code(),
      $url
    );

    file_put_contents(
      $targetFile,
      $data,
      FILE_APPEND
    );
  }


}


?>
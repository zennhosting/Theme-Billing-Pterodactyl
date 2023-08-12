<?php


// return all categories (array)
function getPluginsCategories()
{
  $REQUEST_URL = "https://api.spiget.org/v2/categories?size=100";
  $response    = @file_get_contents($REQUEST_URL, false);
  $data = json_decode($response, true);
  return $data;
}

// Param: $category_id - (int), $options - example array('size' => 50, 'page' => 2)
// return array
function getPluginsInCategory($server, $category_id, $options = NULL)
{

  if ($options != NULL) {
    $options_str = '?sort=-downloads';
    foreach ($options as $key => $value) {
      $options_str = $options_str . '&' . $key . '=' . $value;
    }
  } else {
    $options_str = '';
  }
  $REQUEST_URL = "https://api.spiget.org/v2/categories/{$category_id}/resources{$options_str}";
  $response    = @file_get_contents($REQUEST_URL, false);
  $data = json_decode($response, true);

  return $data;
}

// Param: $options - example array('size' => 50, 'page' => 2)
// return array
function getAllPlugins($options = NULL)
{
  if ($options != NULL) {
    $options_str = '?sort=-downloads';
    foreach ($options as $key => $value) {
      $options_str = $options_str . '&' . $key . '=' . $value;
    }
  } else {
    $options_str = '';
  }
  $REQUEST_URL = "https://api.spiget.org/v2/resources{$options_str}";
  $response    = @file_get_contents($REQUEST_URL, false);
  $data = json_decode($response, true);
  return $data;
}

function search($find, $p = 1)
{
  $REQUEST_URL = "https://api.spiget.org/v2/search/resources/{$find}?size=21&sort=-downloads&page={$p}";
  $response    = @file_get_contents($REQUEST_URL, false);
  $data = json_decode($response, true);
  return $data;
}

function getUpURL($server)
{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => config('app.url') . '/api/client/servers/' . $server . '/files/upload',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_COOKIE => 'pterodactyl_session=' . $_COOKIE['pterodactyl_session'],
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $response = json_decode($response);
    return $response->attributes->url;
  }
}


function installPlugin($server, $pl_id, $file_name)
{
  $file_path = getFileUrl($pl_id);
  $path_parts = pathinfo($file_path);
  $file_name = str_replace(' ', '', $file_name) . '.' . $path_parts['extension'];

  $url = getUpURL($server) . '&directory=/plugins/';
  $headers = [
    "Accept: application/json",
    "Content-Type: multipart/form-data",
  ];

  $fields = [
    'files' => new \CurlFile($file_path, '', $file_name),
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

  var_dump(curl_exec($ch));
  var_dump(curl_error($ch));
}


function getFileUrl($id)
{
  $host = "https://api.spiget.org/v2/resources/{$id}/download";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $host);
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_AUTOREFERER, false);
  curl_setopt($ch, CURLOPT_REFERER, "https://resourcemc.net");
  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $result = curl_exec($ch);
  curl_close($ch);
  $result = explode('g to ', $result);
  $result = trim($result['1']);
  return $result;
  print_r($result); // prints the contents of the collected file before writing..
}

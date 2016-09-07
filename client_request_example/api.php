<?php

$key;
$p;
$api = new apiCalls();

$key = $api->login();

echo '<head><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style></head><body><h1>Using API</h1></br>' .
'<p>Your api key: </p>'.
$key['token'] . '</br>';
$p = $api->getProducts($key);
echo '</br><table id="customers">
            <tr>
              <th>Category</th>
              <th>Name</th>
            </tr>';
      foreach($p AS $product)
        echo '<tr>
                  <td>'.$product->category.'</td>
                  <td>'.$product->name.'</td>
                </tr>
                ';
      echo '</table></body>';

class apiCalls {

  public function signup() {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8000",
      CURLOPT_URL => "http://localhost:8000/api/auth/signup",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"name\"\r\n\r\nd4rk\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\nzubslam@dgmail.com\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\n0711254466zs\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001"
        ),
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }

  public function login() {
    $key;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8000",
      CURLOPT_URL => "http://localhost:8000/api/auth/login",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\nzubslam@gmail.com\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\nzub123@\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001")
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $key = json_decode($response, true);
    }

    return $key;
  }

  public function getBook ($key) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8000",
      CURLOPT_URL => "http://localhost:8000/api/books?token=".$key['token'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001")
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }  
  }
  public function getProducts($key){
    $products;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8000",
      CURLOPT_URL => "http://localhost:8000/api/products?token=".$key['token'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"name\"\r\n\r\nside\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"category\"\r\n\r\ncooldrink\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001"
        )
      ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $products = json_decode($response);
      return $products;
    }
    return $products;
  }
}
?>
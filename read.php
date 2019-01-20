<?PHP

// #####################
// make your changes in settings.php
// #####################


include('settings.php');



// #####################
// Do NOT edit below !!!
// #####################






$csvData = file_get_contents($csvFile);
$lines = explode(PHP_EOL, $csvData);
$csv = array();
foreach ($lines as $line) {
    $csv[] = str_getcsv($line);
}

if ($array_show == "true") {
print_r($csv);
}





//function readCSV($csvFile){
//    $file_handle = fopen($csvFile, 'r');
//    while (!feof($file_handle) ) {
//        $line_of_text[] = fgetcsv($file_handle, 1024);
//    }
//    fclose($file_handle);
//    return $line_of_text;
//}


//$csv = readCSV($csvFile);
//echo '<pre>';
//print_r($csv);
//echo '</pre>';


$min=1000;
$max=9999;
$random_number = rand($min,$max);
echo "Your task has the following id (you can this number in the logs) ";
echo $random_number;
echo "\r\n";

include('library/Requests.php');

$myfile = fopen("logs/log-$random_number.txt", "w");
$txt = 'Start of Logging ...' . PHP_EOL ;
fwrite($myfile, $txt);

if ($upload_to_sleek == "true") {
foreach(($csv ? $csv : array()) as $item) {





  // #####################
  // edit section!
  // #####################




    $name_input = $item["$name_number"];
    $preis_input = $item["$price_number"];
    $picture_input = $item["$picture_number"];
    $description_input = $item["$description_number"];

    $ean_input = $item['$ean_number'];




    // #####################
    // end of edit section!
    // #####################







    if ($name_to_permalink == "false") {
        $permalink = $item['0'];
    }

    echo "\r\n";
    echo "\r\n";
    echo "\r\n";
    echo "Upload of ";
    echo $name_input;
    echo " to Sleekshop started ...";
    echo "\r\n";
    echo "\r\n";
    echo "\r\n";
    echo "Name: ";
    echo $name_input;
    echo "\r\n";
    echo "Preis: ";
    echo $preis_input;
    echo "\r\n";
    echo "\r\n";

    $txt2 = 'Upload Started:' . PHP_EOL . PHP_EOL . PHP_EOL;
    fwrite($myfile, $txt2);

    if ($name_to_permalink == "true") {
      $name_input = $permalink;
    }

    Requests::register_autoloader();
    $headers = array();
    $data = array(
        'licence_username' => $licence_username,
        'licence_password' => $licence_password,
        'licence_secret_key' => $licence_secret_key,
        'request' => 'create_product',
        'class' => $product_class,
        'name' => $name_input,
        'shop_active' => $shop_active,
        'attributes' => '{"' . "$language" . '":{"' . "$name_text" . '":"' . "$name_input" . '","' . "$price_text" . '":"' . "$preis_input" . '","' . "$description_text" . '":"' . "$description_input" . '","' . "$picture_text" . '":"' . "$picture_input" . '"}}',
        'metadata' => '{"element_number":"' . "$ean_input" . '"}',
        'categories' => '{"categories":"' . "$category" . '"}',
        'seo' => '{"' . "$language" . '":{"permalink":"' . "$permalink" . '"}}'
    );
    $response = Requests::post($api_url, $headers, $data);

    fwrite($myfile, print_r($data, true));
    fwrite($myfile, print_r($response, true));

    echo "\r\n";
    echo "Upload Finished!";
    echo "\r\n";
    echo "\r\n";
    echo "\r\n";


    // to know what's in $item
    //echo '<pre>';
    //var_dump($item);
  }
}

fclose($myfile);

?>

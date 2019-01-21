# CSV Data importer 
To use the Importer you will need a web server with a secured folder or a bash like Apple Terminal!

### *This Script is just working with Sleekshop!*

# Introduction
This script was made to go through a CSV file, line by line, and send the inputs sorted into an API.
To make these functions even better, you can configure everything and even add your own custom inputs like described below!

### [Sleekshop](https://sleekshop.io)
Sleekshop is a modular Webshop API which lets you create your own classes and objects to fit exactly your needs of your shop! Because of this we need custom names for classes, which you will find below explained!

# How To!
First of all go into the settings.php and edit it with a program like ATOM or Notepad++ which are both free. There you will find a lot of settings we will go through now!

    // Set path to CSV file
    $csvFile = 'file2.csv';
    
First of all here you can change the setting which .csv is going to be loaded. Please consider copying your CSV file into the directory of the settings.php and read.php! 

Then the next part of interest is in the bottom of the file:

    // ######################
    // Developement options
    // ######################
    
    // Upload
    $upload_to_sleek = "true";
    
    // Copy Name into Perma Link
    $name_to_permalink = "false";
    
    // Show Array in Terminal
    $array_show = "false";
I recommend setting $upload_to_sleek to false and $array_show to true.
What this will do, is showing you the input of csv in a structure you will need later on!

Let's try running it!

 

 1. On MacOS open Terminal
 2. enter: `cd /your/file/path/` until you're in the folder which you edited the file before!
 3. run the read.php file by running `php read.php`

It will produce an output like the following:

    Array 
    (
	    [0] => Array
		    (
			    [0] => ﻿Casio123
			    [1] => 123
			    [2] => http://www.webhostingottawa.ca/images/test-img.jpg
			    [3] => Short description …
			    [4] => 12345678987
		    )
    )
    
    Your task has the following id (you can this number in the logs) 2079

You can see in the Array 

0 => Casio123

which is in my case the name, so i can now edit the settings.php further,  because i can see, name=0

    // ######################
    // CSV Sorting
    // ######################
    
    // Class Object : Name
    $name_text = "name";
    $name_number = "0";
    
    // Class Object : Name
    $price_text = "price";
    $price_number = "1";
    
    // Class Object : Name
    $picture_text = "img1";
    $picture_number = "2";
    
    // Class Object : Name
    $description_text = "description";
    $description_number = "3";
    
    // EAN Number
    $ean_number = "4";

You can see $name_number already equals 0 which is in my case correct. Please change it accordingly to your output above! Please ignore the $name_text for now, I will go through that later on.

The Process is the same for price, img1, description, ean number!

Now we have to take a look into our sleekshop backend where you should have already a class where your products should be in!

This class has to be setup in the settings.php too:

    // Your Products class
    $product_class = 'product';

This is also correct for my case where the Product Class of Sleekshop is named "product".

In this Product class you probably have attributes like Name, Price etc. these may differ from my, so please keep in mind to change them.

    // ######################
    // CSV Sorting
    // ######################
    
    // Class Object : Name
    $name_text = "name";
    $name_number = "0";
    
    // Class Object : Name
    $price_text = "price";
    $price_number = "1";
    
    // Class Object : Name
    $picture_text = "img1";
    $picture_number = "2";
    
    // Class Object : Name
    $description_text = "description";
    $description_number = "3";
The $name_text is the name according to sleekshops backend which tells me Name=name so it's simple to change these names here.

If you want to import more than Name, Price, Img1, description and ean you can do this too, but this will take some changes to the read.php. I will go through that later on.

Now after changing these lines, you just need to specify which category the products should be in after import:

    // Category
    $category = 'Music';

You can easily change the name to smth different than Music ;)

### (Optional)

Now if you want you can set the products to be inactive after import just change 

    // Should the uploaded Products be shopactive? 1 = Yes; 0 = No;
    $shop_active = '1';
to 1 for active and 0 for inactive

### Setting up the sleekshop-connection
The last step before uploading is to setup the connection with the correct api license keys.

    // Sleekshop Credentials
    $licence_username = '';
    $licence_password = '';
    $licence_secret_key = '';
    $api_url = '';

All of these things can be found in the sleekshop backend under Administration > Settings > API

### Running the script

Now like described above just change 

    // Upload
    $upload_to_sleek = "true";
    
    // Copy Name into Perma Link
    $name_to_permalink = "false";
    
    // Show Array in Terminal
    $array_show = "false";
Upload_to_sleek to true and show array if you want to false.

And run it in console : `php read.php`

It should show something like this:

    Your task has the following id (you can this number in the logs) 9464
    
    Upload of ﻿Casio123 to Sleekshop started ...
    
    Name: ﻿Casio123
    Preis: 123
    
    Upload Finished!
This means your taks (uploading process) has the number 9464 which you use to find the log connected to this upload, where you can see what has happened and the answer of the api.

# Adding uploading attributes
This changes will require you to have programming knowledge:

E.g. I want to upload a second picture i have to define in the settings.php the name of the second picture in sleekshop and the position of the link in the csv file and last but not least add it to the uploader API call.

This may sound confusing but you will see that it is pretty straight forward.

Add something like this to the CSV order section in the settings.php

    // Class Object : Img2
    $image2_text = "image2";
    $image2_number = "6";

The image2 has to have a custom name, else you will be experiencing some issues.
After adding this you will need to add 2 things in the read.php

At line 79 you will need to add this:

    $image2_input = $item["$image2_number"];

You will need to use the name from above.

To include this new element to the uploading process you will need to add on line 137 in the attributes section this:

    ,"' . "$image2_text" . '":"' . "$image2_input" . '"

before the two closing brackets. Please be carefull that all brackets are correct.

Once you have done this editing the new Attribute e.g. image will be uploaded.

# Understand the code

    $csvData = file_get_contents($csvFile);
    $lines = explode(PHP_EOL, $csvData);
    $csv = array();
    foreach ($lines as $line) {
        $csv[] = str_getcsv($line);
    }
    
    if ($array_show == "true") {
    print_r($csv);
    }
This will read your .csv and convert every line into an array.

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
This will start the logging and will create a new file with a random number which is created by php rand function.

    foreach(($csv ? $csv : array()) as $item) {
This will loop through every array which is not empty.

        $name_input = $item["$name_number"];
        $preis_input = $item["$price_number"];
        $picture_input = $item["$picture_number"];
        $description_input = $item["$description_number"];
    
        $ean_input = $item['$ean_number'];
This defines in what position the content is in the CSV file. These values are set up in the settings.php

    if ($name_to_permalink == "false") {
            $permalink = $item['0'];
        }
If you want your products on your site to have a permalink you could use this function to setup copy the name to permalink.

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
That's the full request which is being sent to Sleekshop for each product.

    fwrite($myfile, print_r($data, true));
    fwrite($myfile, print_r($response, true));

These fwrite php functions write your request and then the answer (or response) to the Log file.

# Permissions
Sleekshop is a product of Sleekcommerce UG.

This script was written for use with Sleekshop. If you'd like to use it differently or you have questions please contact us here: [LINK](https://go-on.io)

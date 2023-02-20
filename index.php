<?php

$error = null;
$message = null;

if (isset(($_POST["submit"]))) {
    //Validate Data
    if (empty($_POST["productName"])) {
        $error = "<label class='text-danger'>Enter product name</label>";
    } else if (empty($_POST["quantity"])) {
        $error = "<label class='text-danger'>Enter quantity</label>";
    } else if (empty($_POST["price"])) {
        $error = "<label class='text-danger'>Enter price</label>";
    }

    if ($error == null) {
        //start to insert
        if (file_exists('file.json')) {

            $current_data = file_get_contents('file.json');
            $array_data = json_decode($current_data, true);
            $extra = array(
                'name'      => $_POST['productName'],
                'quantiy'   => $_POST["quantity"],
                'price'     => $_POST["price"],
                'date_time' => date('Y-m-d h:i:sa'),
                'total_value' => $_POST["quantity"] * $_POST["price"],
            );
            $array_data[] = $extra;
            $final_data = json_encode($array_data);


            if (file_put_contents('file.json', $final_data)) {
                $message = "<label class='text-success'>Data added Success fully</p>";
            }
        } else {

            $file = fopen("file.json", "w");
            $array_data = array();
            $extra = array(
                'name'      => $_POST['productName'],
                'quantiy'   => $_POST["quantity"],
                'price'     => $_POST["price"],
                'date_time' => date('Y-m-d h:i:sa'),
                'total_value' => $_POST["quantity"] * $_POST["price"],
            );
            $array_data[] = $extra;
            $final_data = json_encode($array_data);
            fclose($file);

            if (file_put_contents('file.json', $final_data)) {
                $message = "<label class='text-success'>File createed and  data added Success fully</p>";
            }
        }
    }
}


//Get json content and sho on table
if (file_exists('file.json')) {
    $filename = 'file.json';
    $data = file_get_contents($filename); //data read from json file
    $allStacks = json_decode($data);  //decode a data
} else {
    $message = "<h3 class='text-danger'>JSON file Not found</h3>";
}

include('form.html');
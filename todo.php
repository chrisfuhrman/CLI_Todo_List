<?php

// Create array to hold list of todo items
$items = [];

//List array items formatted for CLI
function listItems($list) {

    $listString = "";

    foreach ($list as $key => $item) {
        $key++;
        $listString .= "[{$key}] {$item}\n";
    }
    return $listString;
}

//Function for trimming user input and making input uppercase if needed
function getInput($upper = false) {
    $input = trim(fgets(STDIN));
    if ($upper) {
        $input = strtoupper($input);
    }
    return $input;
}

//Function to sort menu
function sortMenu($items) {
    $sortBy = getInput(true);
    if ($sortBy == 'A') {
        sort($items);
    } elseif ($sortBy == 'Z') {
        rsort($items);
    }
    return $items;
}

//Function to add new item to the end or beginning of the list depending on user choice
function itemPlacement($items, $item) {
    $placement = getInput(true);

    if ($placement == 'B') {
        //add new item to beginning of list
        array_unshift($items, $item);
   //add item to end of list if 'B' is not selected
    } else {
        array_push($items, $item);
    }
    return $items;
}

//Function to remove the first item from the list
function removeFirst($items) {
    array_shift($items);
    return $items;
}

//Function to remove the last item from the list
function removeLast($items) {
    array_pop($items);
    return $items;
}
//function to open a file, read it, and turn contents into an array
function readList($filename) {
    $handle = fopen($filename, 'r');

    if (filesize($filename) > 0) {
        $contents = fread($handle, filesize($filename));
        $contentsArray = explode(PHP_EOL, $contents);
    } else {
        $contentsArray = [];
    }
    
    fclose($handle); 
    return $contentsArray;
}


// The loop!
do {
    
    echo listItems($items);

    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit, (S)ort, (O)pen: ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = getInput(true);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        //assign new item to $item to use in itemPlacement function
        $item = getInput();
        echo 'Would you like to add this item to the (B)eginning or the (E)nd of the list? ';
        //overwrite the array with the additional variables
        $items = itemPlacement($items, $item);
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = getInput();
        //The $key-- brings the index value back to the actual index value
        $key--;
        // Remove from array
        unset($items[$key]);
        // reindex numerical array
        $items = array_values($items);
    } elseif ($input == 'S') {
        // Remove which item?
        echo 'Would you like to order these from (A) - Z or from (Z) - A: ';
        // Get array key
        $items = sortMenu($items);
    } elseif ($input == 'F') {
        // removes the first item on the list when the 'F' key is hit. hidden feature
         $items = removeFirst($items);
    } elseif ($input == 'L') {
        // removes the last item on the list when the 'L' key is hit. hidden feature
        $items = removeLast($items);
    }
    elseif ($input = 'O') {
        echo 'Please enter filename: ';
        $filename = getInput();

        $contentsArray = readList($filename);
        $items = array_merge($contentsArray, $items); 
    }

// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);
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

// The loop!
do {
        echo listItems($items);

    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = getInput(true);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = getInput();
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
    }
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);
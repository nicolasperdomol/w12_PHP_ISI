<?php
// Exercise 10-0
//1.display the current working directory
$current_directory = getcwd();
echo $current_directory;

$my_text = "ex10-0_text.txt";
//2.verify that file ex10-0_text.txt exists in current directory, if not display message "file does not exist"
if (!file_exists($my_text)) {
    echo "<br>file does not exist";
}

//3.display the file size of file ex10-0_text.txt in bytes
echo "<br>" . filesize($my_text);

//4.read whole content of file ex10-0_text.txt and save in a variable. Display content on web page.
$file_content = file_get_contents($my_text);
echo "<br>" . $file_content;

//5.copy file to ex10-0_text.txt to HELLO.txt
if (!file_exists("HELLO.txt")) {
    fopen("HELLO.txt", 'w');
}

if (copy($my_text, "HELLO.txt")) {
    echo "<br>Text copied!";
}


//6.replace whole file content of HELLO.txt by the text "Hello World"
file_put_contents("HELLO.txt", "Hello World!");


//7.rename file HELLO.TXT to HELLO2.txt
rename("HELLO.txt", "HELLO2.txt");


//8.delete file HELLO2.txt
unlink("HELLO2.txt");

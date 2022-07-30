<?php
function getLetterGrade($grade)
{
    if ($grade >= 90 and $grade < 100) {
        return "A";
    } elseif ($grade >= 80 and $grade < 90) {
        return "B";
    } elseif ($grade >= 70 and $grade < 80) {
        return "C";
    } elseif ($grade >= 60 and $grade < 70) {
        return "D";
    } elseif ($grade >= 0 and $grade < 60) {
        return "F";
    } else {
        return "grade outside range[0-100](%)";
    }
}

echo getLetterGrade(70) . "<br>";
echo getLetterGrade(90) . "<br>";

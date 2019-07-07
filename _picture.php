<?php
function rgbcalc($calc) {
    if ($calc < 0) return 0;
    if ($calc > 255) return 255;
    return $calc;
}
if ($file == "sao") {
    $D1 = "2019-03-30";
    $D2 = "2019-10-26";
} else if ($file == "snk") {
    $D1 = "2019-06-30";
    $D2 = "2020-10-25";
} else {
    exit;
}
$plaintext = explode("-", $D2)[2]."-".explode("-", $D2)[1]."-".explode("-", $D2)[0];

// Date now
$dateNow   = new DateTime(date('Y-m-d'));

// Days
$waitStart = new DateTime($D1);
$waitEnd   = new DateTime($D2);
$daysPassed  = $dateNow->diff($waitStart)->format("%a");
$daysLeft    = $dateNow->diff($waitEnd)->format("%a");
$daysBetween = $waitStart->diff($waitEnd)->format("%a");

// Get percentage to tweet
$percentage = floor($daysPassed / $daysBetween * 100);
$realPerc = $daysPassed / $daysBetween * 100;

// Set image
$image = imagecreatefrompng($file.".png");
$font = "Montserrat-Medium.ttf";

$white = imagecolorallocate($image, 255, 255, 255);
// Own colors
if ($file == "sao") {
    $baseR = 90;
    $baseG = 190;
    $baseB = 230;
} else if ($file == "snk") {
    $baseR = 230;
    $baseG = 90;
    $baseB = 70;
}
$dark = imagecolorallocate($image, rgbcalc($baseR-170), rgbcalc($baseG-170), rgbcalc($baseB-170));
$darktxt = imagecolorallocate($image, rgbcalc($baseR-130), rgbcalc($baseG-130), rgbcalc($baseB-130));
$bar = imagecolorallocate($image, $baseR, $baseG, $baseB);

$finalX = round(780 * $realPerc / 100) + 36;

/* TOP */
imagettftext($image, 20, 0, 10, 30, $bar, $font, "@".ucfirst($file)."Timer"); // Arobase
imagettftext($image, 20, 0, 27, 180, $darktxt, $font, "Days left: $daysLeft | Days passed: $daysPassed"); // Passed

/* MIDDLE */
imagefilledrectangle($image, 27, 200, 826, 340, $dark); // Black border
imagefilledrectangle($image, 27+10, 200+10, 826-10, 340-10, $white); // White background

if ($percentage > 0) imagefilledrectangle($image, 37, 200+10, $finalX, 340-10, $bar); // Green bar
if ($percentage < 10) imagettftext($image, 60, 0, 367, 300, $dark, $font, "$percentage%"); // One digit percentage
else imagettftext($image, 60, 0, 345, 300, $dark, $font, "$percentage%"); // Two digits percentage

/* BOTTOM */
imagettftext($image, 20, 0, 27, 380, $darktxt, $font, "PS: As the date is still not released,\nthe estimated release date is $plaintext.");

imagepng($image, "file.png");
?>

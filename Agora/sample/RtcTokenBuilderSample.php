<?php
include("../src/RtcTokenBuilder.php");

$appID = "bdd0b71f200c416c900de9920176dd8f";
$appCertificate = "4f639e4ae471451bada5a26035c23077";
$channelName = "7d72365eb983485397e3e3f9d460bdda";
$uid = 0;
$uidStr = "0";
$role = RtcTokenBuilder::RoleAttendee;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

//$token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
//echo 'Token with int uid: ' . $token . PHP_EOL;

$token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
echo 'Token with user account: ' . $token . PHP_EOL;
?>

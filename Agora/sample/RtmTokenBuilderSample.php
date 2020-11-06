<?php
include("../src/RtmTokenBuilder.php");

$appID = "bdd0b71f200c416c900de9920176dd8f";
$appCertificate = "4f639e4ae471451bada5a26035c23077";
$user = "test_user_id";
$role = RtmTokenBuilder::RoleRtmUser;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

$token = RtmTokenBuilder::buildToken($appID, $appCertificate, $user, $role, $privilegeExpiredTs);
echo 'Rtm Token: ' . $token . PHP_EOL;

?>

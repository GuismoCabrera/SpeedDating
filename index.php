<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document Temp</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
      crossorigin="anonymous"
    />
    <!-- Font Awsome -->
    <script
      src="https://kit.fontawesome.com/6786fb1d76.js"
      crossorigin="anonymous"
    ></script>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link
    rel="stylesheet"
    href="./css/notifications.css"
    />

    <!-- PUSHER -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

  </head>
  <body>
  <?php
  /*
    function generateRandomString($length) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
*/
    //ESTO DEBERIA CAMBIAR POR UN SESSION
    if(isset($_GET['userId'])){
      $userId = $_GET['userId'];
    }else{
      $userId = null;
    }

    include("./Agora/src/RtcTokenBuilder.php");
    $appID = "a57a1fa77f8f43e9acbbe37d0a7c75ac";
    $appCertificate = "360d3f2af797466fa1eb5d4da1c1e497";
    //$channelName = "Xtend_".generateRandomString(20);
    $channelName = "B2B_".$userId;
    $uid = 0;
    $uidStr = "0";
    $role = RtcTokenBuilder::RoleAttendee;
    $expireTimeInSeconds = 3600;
    $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
  
    $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    //echo 'Token with int uid: ' . $token . PHP_EOL;
  
    $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
    //echo 'Token with user account: ' . $token . PHP_EOL;
    echo '<script type="text/javascript">console.log("Channel: '.$channelName.'")</script>';
    echo '<script type="text/javascript">console.log("Token: '.$token.'")</script>';
    ?>
    <button
      id="<?php echo $channelName ;?>"
      onclick="videoCall(this,'<?php echo $token ;?>','<?php echo $userId ;?>','<?php echo $userId-1 ;?>',true)"
      type="button"
      class="btn btn-primary"
    >
      <i class="fas fa-video"></i> Videollamada
    </button>
    <!-- PUSHER -->
    <script>
       // PUSHER SET UP ------------------

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("55c8b85e6ba3e79dfa0e", {
          cluster: "us3",
        });

        var notificationChannel = pusher.subscribe("notificationChannel_"+<?php echo $userId; ?>);
        notificationChannel.bind("videoCalling-event", function (data) {
          var videoCall = JSON.parse(data);
        someoneIsCallingYou(videoCall.channel,videoCall.token,<?php echo $userId; ?>, false);
        });
        // PUSHER SET UP ------------------


//---------------------------------------------------
// NOTIFICATIONS
//---------------------------------------------------
function someoneIsCallingYou(element, token, userId,calling) {
  Swal.fire({
    //title: "<strong>Your Notifications</strong>",
    html:
      '<div class="notifications-container">' +
      "  <ul>" +
      "    <li>" +
      "      <img" +
      '        class="notificationFrom_user_image"' +
      `        src="./images/users/${userId}.jpg"` + //IMG DEL USUARIO
      '        alt="User Image"' +
      "      />" +
      /*'      <div class="notificationFrom_user_name">' +*/
      "        <center><b>Nombre del Usuario</b></center>" +
      /*"      </div>" + */
      /*'      <div class="notificationFrom_user_text">' +*/
      "        <center><p>te esta marcando.</p></center>" +
      /*"      </div>" +*/
      "    </li>" +
      "  </ul>" +
      "</div><hr>",
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: '<i class="fa fa-video"></i>  Answer',
    confirmButtonAriaLabel: "Responder Video Llamada",
    cancelButtonText: '<i class="fa fa-video-slash"></i> Decline',
    cancelButtonAriaLabel: "Rechazar Vídeo Llamada",
  }).then((result) => {
    if (result.isConfirmed) {
      videoCall(element, token, userId,calling);
    }
  });
}



    </script>
  </body>
  <!-- Script Video Llamada -->
  <script type="text/javascript" src="./js/videoCall.js"></script>
</html>

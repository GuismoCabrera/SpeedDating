<div id="callingNotification">
<?php
 if(isset($_POST['callingTo'])){
  require __DIR__  . '/vendor/autoload.php';
  $notificationData = $_POST['notificationData'];
  $eventType = $_POST['eventType'];
  $callingTo = $_POST['callingTo'];
  $options = array(
    'cluster' => 'us3',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '55c8b85e6ba3e79dfa0e',
    '2e73654432da9d7bddfd',
    '1101091',
    $options
  );

  $data['message'] = json_encode($notificationData) ;
  $pusher->trigger('notificationChannel_'.$callingTo,$eventType,$notificationData);

  //echo '<script>alert("'.$callingTo.'")</script>'; 
}
?>
</div>

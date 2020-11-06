/**
 * @name handleFail
 * @param err - error thrown by any function
 * @description Helper function to handle the errors
 */
let handleFail = function (err) {
  console.log("Error: ", err);
};

//Queries the container in which the remote feeds belong
let remoteContainer = document.getElementById("remote-container");
/**
 * @name addVideoStream
 * @param elementId is the name of the element tha is to be inserted into the DOM
 * @description Helper function to add the video stram to "remote-container"
 */

function addVideoStream(elementId) {
  let streamDiv = document.createElement("div");
  streamDiv.id = elementId;
  //streamDiv.style.transform = "rotateY(180deg)";
  remoteContainer.appendChild(streamDiv);
}
/**
 * @name removeVideoStream
 * @param elementId is the name of the element that is to be removed into the DOM
 * @description Helper function to remove the video stream from "remote-container"
 */
function removeVideoStream(elementId) {
  let remDiv = document.getElementById(elementId);
  if (remDiv) remDiv.parentNode.removeChild(remDiv);
}

let client = AgoraRTC.createClient({
  mode: "rtc",
  codec: "vp8",
});

var url_string = window.location.href;
var url = new URL(url_string);
var channel = url.searchParams.get("channel");
var token = url.searchParams.get("token");
var userId = url.searchParams.get("userId");
var callingTo = url.searchParams.get("callingTo");
var calling = url.searchParams.get("calling");

client.init("a57a1fa77f8f43e9acbbe37d0a7c75ac");
client.join(
  token,
  channel,
  "B2B_".userId,
  (uid) => {
    let localStream = AgoraRTC.createStream({
      video: true,
      audio: true,
    });
    localStream.init(() => {
      localStream.play("me");
      client.publish(localStream, handleFail);
    }, handleFail);
  },
  handleFail
);

client.on("stream-added", function (evt) {
  client.subscribe(evt.stream, handleFail);
});

client.on("stream-subscribed", function (evt) {
  let stream = evt.stream;
  let streamId = String(stream.getId());
  addVideoStream(streamId);
  stream.play(streamId);
});

client.on("stream.removed", function (evt) {
  let stream = evt.stream;
  let streamId = String(stream.getId());
  stream.close();
  removeVideoStream(streamId);
});

client.on("peer-leave", function (evt) {
  let stream = evt.stream;
  let streamId = String(stream.getId());
  stream.close();
  removeVideoStream(streamId);
});

if (calling) {
  var videoCall = {
    from: channel,
    token: token,
    channel: channel,
    userId: userId,
  };
  var videoCall_data = JSON.stringify(videoCall);
  console.log(videoCall_data);
  $("#callingNotification").load("./pusher.php", {
    notificationData: videoCall_data,
    callingTo: callingTo,
    eventType: "videoCalling-event",
  });
}

//---------------------------------------------------
// NOTIFICATIONS
//---------------------------------------------------

function someoneIsCallingYou(element, token, userId) {
  Swal.fire({
    //title: "<strong>Your Notifications</strong>",
    html:
      '<div class="notifications-container">' +
      "  <ul>" +
      "    <li>" +
      "      <img" +
      '        class="notificationFrom_user_image"' +
      `        src="./images/users/${userId}.jpg"` +
      '        alt="User Image"' +
      "      />" +
      /*'      <div class="notificationFrom_user_name">' +*/
      "        <center><b>Nombre del Usuario</b></center>" +
      /*"      </div>" + */
      /*'      <div class="notificationFrom_user_text">' +*/
      "        <center><p>is calling you</p></center>" +
      /*"      </div>" +*/
      "    </li>" +
      "  </ul>" +
      "</div><hr>",
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: '<i class="fa fa-video"></i>  Answer',
    confirmButtonAriaLabel: "Answer Video Call",
    cancelButtonText: '<i class="fa fa-video-slash"></i> Decline',
    cancelButtonAriaLabel: "Decline",
  }).then((result) => {
    if (result.isConfirmed) {
      join_videoCall(element, token, userId);
    }
  });
}

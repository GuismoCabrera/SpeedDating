function videoCall(element, token, userId, callingTo, calling) {
  var channel = "";
  if (typeof element !== "string") {
    channel = element.id;
  } else {
    channel = element;
  }
  window.open(
    `https://videomeet.eventosweb.net//callingB2B.php?channel=${channel}&token=${token}&userId=${userId}&callingTo=${callingTo}&calling=${calling}`,
    "_blank"
  );
}

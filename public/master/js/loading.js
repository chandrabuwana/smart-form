function showLoading() {
  $("body").css("overflow-y", "hidden")
  $("#loading-animation").css("display", "flex")
}

function stopLoading() {
  $("body").css("overflow-y", "auto")
  $("#loading-animation").css("display", "none")
}
var content_add_bottombar_send = document.getElementById("content_add_bottombar_send");
var content_add_textarea       = document.getElementById("content_add_textarea");

content_add_bottombar_send.addEventListener("click", function() {
    var question = content_add_textarea.value;
    if (question.length == 0) {
        showNotification("No escribiste tu pregunta bobooo", NOTIFICATION_ERROR);
        return;
    }

    var httpRequest = new XMLHttpRequest();

    content_add_textarea.disabled = true;

    httpRequest.onreadystatechange = function () {
        content_add_textarea.disabled = false;

        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status == 200) {
                showNotification("Pregunta enviada con éxito", NOTIFICATION_SUCCESS);
                content_add_textarea.value = "";
            } else {
                showNotification("Hubo un error interno. " + httpRequest.responseText, NOTIFICATION_ERROR);
            }
        }
    };
    httpRequest.open('GET', URL + "action.php?action=ask&question=" + question + "&user_id=" + profileUserId);
    httpRequest.send();
});
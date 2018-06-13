/**
 * Created by brianvalente on 1/13/17.
 */

var question_bottom_reply_send = document.querySelectorAll(".question_bottom_reply_send");
var btn_twitter_share_profile = document.querySelector("#btn_twitter_share_profile");

for (var i=0; i<question_bottom_reply_send.length; i++) {
    question_bottom_reply_send[i].onclick = function (e) {
        var button = e.target;
        var questionId = button.dataset.questionid;
        var textarea = document.getElementById("textarea_question_" + questionId);
        var answer = textarea.value;

        textarea.disabled = true;

        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                textarea.disabled = false;
                console.log(httpRequest.responseText);
                if (httpRequest.status === 200) {
                    textarea.value = httpRequest.responseText;
                } else if (httpRequest.status >= 600) {
                    showNotification(httpRequest.responseText, NOTIFICATION_ERROR);
                } else {
                    showNotification("Hubo un problema al conectarse con el servidor.", NOTIFICATION_ERROR);
                }
            }
        };
        httpRequest.open('GET', URL + "action.php?action=reply&question=" + questionId + "&answer=" + answer);
        httpRequest.send();
    }
}

if (btn_twitter_share_profile !== null) {
    btn_twitter_share_profile.onclick = function () {
        showNotification("Compartiendo...", NOTIFICATION_SUCCESS);
        var formData = new FormData();
        formData.append("action", "tweet_profile");
        sendData(formData, function (client) {
            if (client.status === 200) {
                showNotification("Perfil compartido en Twitter", NOTIFICATION_SUCCESS);
            } else {
                showNotification("Hubo un error. " + client.responseText, NOTIFICATION_ERROR);
            }
        })
    };
}

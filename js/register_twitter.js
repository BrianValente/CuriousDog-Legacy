/**
 * Created by brianvalente on 1/13/17.
 */

var register_password = document.querySelector("#register_password");
var send = document.querySelector("#send");

send.onclick = function () {
    if (register_password.value.length === 0) {
        showNotification("Escribí una contraseña, boluda...", NOTIFICATION_ERROR);
        return;
    }

    showNotification("Verificando...", NOTIFICATION_SUCCESS);
    var formData = new FormData();
    formData.append("action", "register_twitter_checkpassword");
    formData.append("password", register_password.value);
    sendData(formData, function (client) {
        if (client.status === 200) {
            showNotification("Redirigiendo...", NOTIFICATION_SUCCESS);
            window.location.replace(URL);
        } else {
            showNotification("Hubo un error. " + client.responseText, NOTIFICATION_ERROR);
        }
        console.log(client.responseText);
    });
};
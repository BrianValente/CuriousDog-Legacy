/**
 * Created by brianvalente on 5/1/17.
 */

var login_username = document.getElementById("login_username");
var login_password = document.getElementById("login_password");
var login_button   = document.getElementById("login_button");


// Index Login Panel

if (login_button !== null) {
    login_button.onclick = function() {
        var username = document.getElementById("login_username").value;
        var password = document.getElementById("login_password").value;
        login_button.classList.add("disable");
        var formData = new FormData();
        formData.append("action", "login");
        formData.append("username", username);
        formData.append("password", password);

        sendData(formData, function(xmlHttpRequest) {
            console.log(xmlHttpRequest.responseText);
            switch (xmlHttpRequest.status) {
                case 200:
                    showNotification("Recargando...", NOTIFICATION_SUCCESS);
                    location.reload();
                    break;
                case 601:
                    showNotification("Usuario y/o contraseña incorrecta", NOTIFICATION_ERROR);
                    break;
                default:
                    showNotification("Hubo un error", NOTIFICATION_ERROR);
                    break;
            }

            login_button.classList.remove("disable");
        })
    }
}

// Login when Enter key is pressed on both fields
if (login_username !== null && login_password !== null) {
    var login_inputs = [login_username, login_password];
    login_inputs.forEach(function(input) {
        input.addEventListener('keyup', function (event) {
            if (event.keyCode === 13) {
                login_button.click();
            }
        });
    });
}

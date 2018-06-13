/**
 * Created by brianvalente on 2/15/17.
 */

var settings_personalinfo_save = document.getElementById("settings_personalinfo_save");
var settings_personalinfo_picture_input = document.getElementById("settings_personalinfo_profile_picture_input");
var settings_sections = document.querySelectorAll(".settings_section");
var settings_sections_buttons = document.querySelectorAll(".settings_tab");

settings_personalinfo_save.onclick = function () {
    var element_name        = document.getElementById("settings_personalinfo_name");
    var element_description = document.getElementById("settings_personalinfo_description");
    var element_username    = document.getElementById("settings_personalinfo_username");
    var element_email       = document.getElementById("settings_personalinfo_email");

    var formData = new FormData();
    formData.append('action', "update_personal_info");
    formData.append('name',        element_name.innerText);
    formData.append('description', element_description.innerText);
    formData.append('username',    element_username.value);
    formData.append('email',       element_email.value);

    sendData(formData, function(client) {
        console.log("Data received: " + client.responseText);
        var json;

        try {
            json = JSON.parse(client.responseText);
        } catch (err) {
            json = {"status":"Unable to connect to server"};
        }

        switch (client.status) {
            case 200:
                showNotification('Settings changed successfully', NOTIFICATION_SUCCESS);
                break;
            default:
                showNotification('There was an error (' + client.status + '): ' + json.status, NOTIFICATION_ERROR);
                break;
        }
    })
};

settings_personalinfo_picture_input.onchange = function () {
    var reader = new FileReader();
    var element_img = document.getElementById("settings_personalinfo_profile_picture");
    var original_img = element_img.style.backgroundImage;
    var loading = document.getElementById("settings_personalinfo_profile_picture_uploading");

    loading.style.display = "block";

    reader.onload = function() {
        var pictureBase64 = reader.result;

        element_img.style.backgroundImage = "url(" + pictureBase64 + ")";

        var formData = new FormData();
        formData.append("action", "update_profile_picture");
        formData.append("picture", pictureBase64);

        sendData(formData, function(client) {
            loading.style.display = "none";

            if (client.status === 200) {
                showNotification("Profile picture uploaded. " + client.responseText, NOTIFICATION_SUCCESS);
            } else {
                element_img.style.backgroundImage = original_img;
                showNotification("There was an error changing your profile picture.", NOTIFICATION_ERROR);
            }
        });
    };

    reader.readAsDataURL(settings_personalinfo_picture_input.files[0]);
}

for (var i=0; i<settings_sections_buttons.length; i++) {
    settings_sections_buttons[i].addEventListener("click", function(e) {
        var newSection = document.querySelector("#" + e.target.dataset.section);
        if (!newSection) {
            console.log("nope");
            return;
        }
        console.log("?");
        for (var i2=0; i2 < settings_sections.length; i2++)
            settings_sections[i2].style.display = "none";
        newSection.style.display = "block";
    });
}
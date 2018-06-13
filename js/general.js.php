/**
 * Created by brianvalente on 1/10/17.
 */

var URL = "https://curiousdog.tk/";

// Main header
var main_header_navigation_logged_in = document.getElementById("main_header_navigation_logged_in");
var main_header_navigation_profile = document.getElementById("main_header_navigation_profile");
var main_header_profile_menu = document.getElementById("main_header_profile_menu");
var main_header_profile_menu_logout = document.getElementById("main_header_profile_menu_logout");

var NOTIFICATION_SUCCESS = 0;
var NOTIFICATION_ERROR   = 1;

function sendData(formData, callback) {
    var client = new XMLHttpRequest();
    client.onreadystatechange = function () {
        if (client.readyState === XMLHttpRequest.DONE) {
            callback(client);
        }
    }
    client.open("POST", URL + "action.php");
    client.send(formData);
}

function showNotification(text, type) {
    var existingToast = document.querySelector("body > .toast");
    if (existingToast != null) {
        existingToast.classList.add("toast_fadeFast");
        existingToast.classList.remove("toast");
    }

    var toast = document.createElement("div");
    toast.innerText = text;
    toast.classList.add("toast");
    if (type == NOTIFICATION_ERROR)
        toast.classList.add("toast_error");
    toast.addEventListener("animationend", function(event){
        var toast = event.target;
        toast.parentElement.removeChild(toast);
    });
    document.body.appendChild(toast);
}


// Account

function login(username, password, callback) {
    var http = new XMLHttpRequest();
    var postUrl = URL + "action.php";
    var params = "action=login&username=" + username + "&password=" + password;
    http.open("POST", postUrl, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if (http.readyState == XMLHttpRequest.DONE) {
            callback(http.status == 200);
        }
    };

    http.send(params);
}

function logout(callback) {
    var http = new XMLHttpRequest();
    var postUrl = URL + "action.php";
    var params = "action=logout";
    http.open("POST", postUrl, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if (http.readyState == XMLHttpRequest.DONE) {
            callback(http.status == 200);
        }
    };
    http.send(params);
}



// Main header

if (main_header_navigation_logged_in != null) {
    main_header_navigation_profile.onclick = function () {
        main_header_profile_menu.classList.toggle("show");
    };

    main_header_profile_menu_logout.onclick = function() {
        logout(function () {
            location.reload();
        });
    };
}

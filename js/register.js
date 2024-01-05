const registerButton = document.getElementsByTagName('button')[0];
registerButton.addEventListener('click', registerRequest);

function registerRequest(event) {
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'php/registration.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    const login = document.getElementById('register-form').children[0];
    const password = document.getElementById('register-form').children[2];
    const passwordRepeat = document.getElementById('register-form').children[3];
    const email = document.getElementById('register-form').children[1];

    xhttp.onload = function() {console.log(JSON.parse(this.responseText))};

    xhttp.send('login=' + login + '&password='+ password + '&password_repeat=' + passwordRepeat + '&email=' + email + '&g-recaptcha-response=' + grecaptcha.getResponse());
}
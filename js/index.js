
var loginButton = document.getElementsByTagName('button')[0];
loginButton.addEventListener('click', loginRequest);

function loginRequest(event) {
    let login = document.getElementById('login-form').children[0].value;
    let password = document.getElementById('login-form').children[1].value;
    var responseLoginObject;
    
    event.target.innerHTML=`
    <svg viewBox="0 0 100 100">
        <circle cy="50" cx="50" r="50" stroke="white" stroke-width="10" fill="transparent"/>
    </svg>`;
    event.target.classList.add('button-loading');

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'php/login.php');
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhttp.onload = function() {
        responseLoginObject = JSON.parse(this.responseText);

        event.target.classList.remove('button-loading');
        event.target.innerHTML='Login';

        if(responseLoginObject.err_no === 0)
            window.location.href = "manager.php";
        else
            alert(responseLoginObject.err_message);
    }

    xhttp.send('login=' + login + '&password=' + password);

}

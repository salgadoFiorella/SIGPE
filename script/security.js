//This function verifies if the password is strong enough to accept it.
//It must be minimum 8 characters, 1 uppercase letter and 1 number.
//Got it from https://martech.zone/javascript-password-strength/
function verifyPasswordStrength() {
    var strength = document.getElementById('strength');
    var confirm = document.getElementById('confirmPassword');
    var passwordMsg = document.getElementById('passwordMsg');
    var strong = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enough = new RegExp("(?=.{6,}).*", "g");
    var pwd = document.getElementById("password");
    if(password.value.length===0){
        strength.innerHTML ='';
        passwordMsg.innerHTML = '';
        confirm.style.backgroundColor = 'transparent'; 
    }
    else if (strong.test(pwd.value)) {
            strength.innerHTML = '<span style="color:green">Contraseña segura</span>';
           // document.getElementById("add_userB").disabled = false;
    }   else {
            strength.innerHTML = '<span style="color:red">Contraseña debe ser de minimo 8 caracteres, una mayúscula, una minúscula y un número</span>';
           // document.getElementById("add_userB").disabled = true;
    }
}
//This function verifies if the password and the confirm password are equals
//https://keithscode.com/tutorials/javascript/3-a-simple-javascript-password-validator.html
function conPassword() {
   // var green = "#66cc66";
    //var red = "#ff6666";
    var password = document.getElementById('password');
    var passwordMsg = document.getElementById('passwordMsg');
    var confirm = document.getElementById('confirmPassword');
    if(confirm.value.length ===0 || password.value.length===0){
        passwordMsg.innerHTML = '';
        //confirm.style.backgroundColor = 'transparent'; 
    }
    else if(password.value===confirm.value){
      //  confirm.style.backgroundColor = green;
        passwordMsg.innerHTML = '<span style="color:green">Contraseñas son iguales.</span>';
    }
    else {
       // confirm.style.backgroundColor = red;
        passwordMsg.innerHTML = '<span style="color:red">Contraseñas no son iguales.</span>';
    }
}



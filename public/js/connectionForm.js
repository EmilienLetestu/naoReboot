/**
 * Created by Emilien on 13/02/2018.
 */
function validateText(id,min,max,errorId){
    var validate  = true;
    var userInput = $id(id).value.length;

    if(userInput < min || userInput > max){
      swappClass($id(errorId),'noError','has-error');
      return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    return validate;
}

function validatePswd(id,min,max,errorId){
    var validate           = true;
    var pswd               = $id(id).value;
    var mixLetterAndNumber = /^(?=.*[a-zA-z])(?=.*\d)/;
    var series             = /(\d)\1{3}/;

    if(pswd.length < min || pswd.length > max || !mixLetterAndNumber.test(pswd) || series.test(pswd)){
        swappClass($id(errorId),'noError','has-error');
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    return validate;
}

function validateMail(id,errorId){
    var validate = true;
    var email    = $id(id).value;
    var regex    =   /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    if(!regex.test(email)){
        swappClass($id(errorId),'noError','has-error');
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    return validate;
}

function required(){

    var validate = true;
    var req = $id('registerForm').querySelectorAll('[required]');
    var userInput = [];
    for(var i=0; i < req.length; i++) {
        var val = req[i].value.length;
        if(!req[i].value.length){
            return validate = false;
        }
    }
    return validate;
}

function disable() {

    if (!$id('registerForm').querySelectorAll('.has-error').length && required()) {
        $id('registerBtn').removeAttribute('disabled');
    } else {
        $id('registerBtn').setAttribute('disabled', 'true')
    }
}
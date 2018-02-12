/**
 * Created by Emilien on 12/02/2018.
 */
function fullname(id,min,max){
    var validate = true;
    var userInput = $id(id).value.length;
    if(userInput < min || userInput > max){
        swappClass($id('fullnameError'),'noError','has-error');
        return validate = false;
    }
    swappClass($id('fullnameError'),'has-error','noError');
    return validate;
}

function message(id,min,max) {
    var validate = true;
    var userInput = $id(id).value;
    var total = wordCount(userInput);

    if(total < min || total > max){
        swappClass($id('contactMsgError'),'noError','has-error');
        return validate = false;
    }
    swappClass($id('contactMsgError'),'has-error','noError');
    return validate;
}


function disable() {
    if(!$id('contact').querySelectorAll('.has-error').length){
        $id('contactBtn').removeAttribute('disabled');
    }else{
        $id('contactBtn').setAttribute('disabled','true')
    }
}



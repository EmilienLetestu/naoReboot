/**
 * Created by Emilien on 12/02/2018.
 */
/**
 * @param id
 * @param min
 * @param max
 * @returns {boolean}
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

/**
 * @param id
 * @param min
 * @param max
 * @returns {boolean}
 */
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

/**
 * @returns {boolean}
 */
function required(){

    var validate = true;
    var req = $id('contatcForm').querySelectorAll('[required]');

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

    if(!$id('contact').querySelectorAll('.has-error').length && required()){
        $id('contactBtn').removeAttribute('disabled');
    }else{
        $id('contactBtn').setAttribute('disabled','true')
    }
}


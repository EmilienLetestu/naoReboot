/**
 * Created by Emilien on 13/02/2018.
 */
/**
 * @param id
 * @param min
 * @param max
 * @param errorId
 * @returns {boolean}
 */
function validateText(id,min,max,errorId){

    var validate  = true;
    var userInput = $id(id).value.length;

    if(userInput < min || userInput > max){
      swappClass($id(errorId),'noError','has-error');

      checked(userInput,errorId);
      return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    checked(userInput,errorId);

    return validate;
}

/**
 * @param id
 * @param min
 * @param max
 * @param errorId
 */
function validateOptionalText(id,min,max,errorId){

    var userInput = $id(id).value;
    if(userInput.length !== 0){
        validateText(id,min,max,errorId);
    }else{
        swappClass($id(errorId),'has-error','noError');
    }
}

/**
 * @param id
 * @param min
 * @param max
 * @param errorId
 */
function validateInteger(id,min,max,errorId){

    var validate = true;
    var userInput = $id(id).value;

    if(userInput < min || userInput > max || !userInput.match(/\d+/)){
        swappClass($id(errorId),'noError','has-error');

        checked(userInput,errorId);
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    checked(userInput,errorId);

    return validate;
}

/**
 * @param id
 * @param min
 * @param max
 * @param errorId
 * @returns {boolean}
 */
function validatePswd(id,min,max,errorId){

    var validate           = true;
    var pswd               = $id(id).value;
    var mixLetterAndNumber = /^(?=.*[a-zA-z])(?=.*\d)/;
    var series             = /(\d)\1{3}/;

    if(pswd.length < min || pswd.length > max || !mixLetterAndNumber.test(pswd) || series.test(pswd)){
        swappClass($id(errorId),'noError','has-error');

        checked(pswd,errorId);
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    checked(pswd,errorId);

    return validate;
}

/**
 * @param id
 * @param errorId
 * @returns {boolean}
 */
function validateMail(id,errorId){

    var validate = true;
    var email    = $id(id).value;
    var regex    =   /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    if(!regex.test(email)){
        swappClass($id(errorId),'noError','has-error');

        checked(email,errorId);
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');

    checked(email,errorId);

    return validate;
}

/**
 * @param id
 * @param refId
 * @param errorId
 * @returns {boolean}
 */
function matching(id,refId,errorId){
    var validate = true;
    var confirmPswd     = $id(id).value;
    var pswd            = $id(refId).value;

    if(confirmPswd !== pswd){
        swappClass($id(errorId),'noError','has-error');
        checked(confirmPswd,errorId);

        return validate = false
    }

    swappClass($id(errorId),'has-error','noError');
    checked(confirmPswd,errorId);

    return validate;
}

/**
 *
 * @param id
 * @param min
 * @param max
 * @param errorId
 * @param meterId
 * @returns {boolean}
 */
function validateTextArea(id,min,max,errorId,meterId) {

    var validate = true;
    var userInput = $id(id).value;
    var total = wordCount(userInput);

    var totalMeter = userInput === "" ? 0 : total;

    liveWordCount(totalMeter,max,meterId);

    if(total < min || total > max){
        swappClass($id(errorId),'noError','has-error');

        total >= max ? alert('Vous avez atteint le nombre maximum de mots'):null;

        checked(userInput,errorId);
        return validate = false;
    }

    swappClass($id(errorId),'has-error','noError');
    checked(userInput,errorId);

    return validate;
}

/**
 * @param total
 * @param max
 * @param meterId
 * @returns {string}
 */
function liveWordCount(total,max,meterId) {

    (total/max)*100 > 90 ? $id(meterId).style.color = '#ff5240' : $id(meterId).style.color = 'inherit';

    return $id(meterId).innerHTML = total + '/' + max;
}

/**
 *
 * @param textId
 * @param meterId
 * @param max
 * @returns {string}
 */
function liveCharCount(textId,meterId,max) {

    var total = $id(textId).value.length;
    var evaluate = (total/max)*100;

    evaluate > 90 ? $id(meterId).style.color = '#ff5240' : $id(meterId).style.color = 'inherit';

    return $id(meterId).innerHTML = total + '/' + max;
}

/**
 * @returns {boolean}
 */
function fileType(id){

    if($id(id).value !== ''){
        var file = $id(id).value.replace(/ /g,"_").split('.');

        if(file[file.length-1] !== 'jpg' && file[file.length-1] !== 'png' ){

            generateMsg('jsGenerated','jsGeneratedMsg','Veuillez fournir un fichier au format .jpg ou .png','#ff5240');

        } else{

            generateMsg('jsGenerated','jsGeneratedMsg','Image ajoutée','#5fdda1');
        }
    }
}

/**
 * @returns {boolean}
 */
function required(formId){

    var validate = true;
    var req = $id(formId).querySelectorAll('[required]');

    for(var i=0; i < req.length; i++) {
        var val = req[i].value.length;
        if(!req[i].value.length){

            return validate = false;
        }
    }
    return validate;
}

/**
 * @param btnId
 * @param formId
 */
function disable(btnId,formId) {

    if (!$id(formId).querySelectorAll('.has-error').length && required(formId)) {
        $id(btnId).removeAttribute('disabled');
    } else {
        $id(btnId).setAttribute('disabled', 'true')
    }
}


/**
 * @param inputValue
 * @param errorId
 */
function checked(inputValue,errorId) {
  if(inputValue !== "" && $id(errorId).className === 'form-control-feedback noError' ){
      $id(errorId).previousElementSibling.style.visibility = 'visible';
  } else {
      $id(errorId).previousElementSibling.style.visibility = "hidden";
  }
}


function selectCurrentDate(){
    var date = new Date();

    //prevent date to be reset to current day on page reload after server side validation failure
    if($id("report_nbrOfBirds").value === ""){

        $id("report_addedOn_day").value = date.getDate();
        $id("report_addedOn_month").value = date.getMonth()+1;
        $id("report_addedOn_year").value = date.getFullYear();
    }
}

function loginError(){

    if($id('loginFailed')){

        var msg = $id('loginFailed').innerHTML;
        switch (msg){
          case 'User account is disabled.':
              $id('loginFailed').innerHTML = 'Veuillez activer votre compte, ' + generateSendActivationLink();

              break;
          case 'User account is locked.':
              $id('loginFailed').innerHTML = ' Votre compte a été bloqué par l’administrateur';
              break;
          default:
              $id('loginFailed').innerHTML = 'L\'email et le mot de passe ne correspondent pas';
        }
    }
}


function generateSendActivationLink(){
    return '<a class="askMail" href="/mail-activation/' + $id('username').value +'">renvoyer l\'email d\'activation ?</a>';
}


function serverValidationFailed(){

    if($class('help-block')){

        var errors = $class('help-block');
        for(var i= 0; i<errors.length; i++ ){
            errors[i].previousElementSibling.classList.add("has-error");
            errors[i].previousElementSibling.classList.remove("noError");
            errors[i].remove();
        }
    }

}

if(window.location.pathname === "/observations/nouvelle-observation"){
    window.addEventListener('load',function () {
        selectCurrentDate();
    });
}

if(window.location.pathname === "/connexion"){
    window.addEventListener('load',function () {
        loginError();
    })
}

window.addEventListener('load',function () {
    serverValidationFailed();
});


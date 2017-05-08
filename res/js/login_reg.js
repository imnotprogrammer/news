function alert_func(abody){
  var d = dialog({
    title: '就要去便民超市提醒您',
    content: abody
  })
  .width(400)
  .height(150)
  .show();
}
function if_phone(phoneval){
  var phone_regobj=/[1-9]{1}[0-9]{10}/;
  return phone_regobj.test(phoneval);
}
function if_email(emailval){
  var email_reg=/^([a-zA-Z0-9]+[_|-|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|-|.]?)*[a-zA-Z0-9]+.[a-zA-Z]{2,3}$/gi;
  return email_reg.test(emailval);
}
function if_pass(passval){
  if(passval.length>3){
    return true;
  }
  return false;
}
$(function(){ 
})
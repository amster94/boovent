
//-----------------------------------VALIDATE EMAIL---------------------------------------------//
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

//-----------------------------VALIDATE INDIAN PHONE ---------------------------------------------//
function isPhone(phone) {
  var regex = /^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/;
  return regex.test(phone);
}
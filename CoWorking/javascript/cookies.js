function setCookie() {
  if(document.getElementById("age").checked == true)
  {
    document.cookie = "meerderjarig" + "=" + "true" + ";" + "expires = Thu, 01 Jan 2070 00:00:00 GMT" + ";path=/";
    closeWindow();
  }
  else
  {
    alert("Je bent niet ouder dan 18!");
    history.back();
  }
}
  
function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function checkCookie() {
  let user = getCookie("meerderjarig");
  if (user == "true") {
    closeWindow();
  } else {
    //scherm met vraag of je ouder bent dan 18
  }
}
//delete cookie -> test doeleinden
function delCookie()
{
  document.cookie = "meerderjarig" + "=" + "true" + ";" + "expires = Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
}

function closeWindow()
{
  document.querySelector(".popup").style.display = "none";
}
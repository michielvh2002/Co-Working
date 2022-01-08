function setCookie() {
  document.cookie = "meerderjarig" + "=" + "true" + ";" + "expires = Thu, 01 Jan 2070 00:00:00 GMT" + ";path=/";
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
    alert("Je bent ouder dan 18 ");
    //laat binnen in de site
  } else {
    //scherm met vraag of je ouder bent dan 18
  }
}
//delete cookie -> test doeleinden
function delCookie()
{
  document.cookie = "meerderjarig" + "=" + "true" + ";" + "expires = Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
}
$(document).ready(function(){
  mwal_wiki_auth(mwal_user, mwal_pass, wgServer+wgScript);
});

function mwal_wiki_auth(login, pass, ref) {
  var login_url = 'api.php?action=login&lgname=' + login + '&lgpassword=' + pass + '&format=json';
  $.post(login_url, function(data) {
    if(data.login.result == 'NeedToken') {
      $.post(login_url + '&lgtoken='+data.login.token, function(data) {
        if(!data.error){
          if (data.login.result == "Success") {
            document.location.href=ref; 
          } else {
            console.log('Result: '+ data.login.result);
          }
        } else {
          console.log('Error: ' + data.error);
        }
      });
    } else {
      console.log('Result: ' + data.login.result);
    }
    if(data.error) {
      console.log('Error: ' + data.error);
    }
  });
}

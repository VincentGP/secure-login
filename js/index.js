var app = new Vue({
  el: '#app',
  data: {
    userName: "",
    password: "",
    loggedIn: false,
    tryAgain: false
  },
  methods: {
    logIn: function () {
      let vm = this;
      const request = new XMLHttpRequest();
      const sUrl = 'login.php?username=' + this.userName + '&password=' + this.password + '';
      //Indstil parametre til Ajax request
      request.open('GET', sUrl, true);
      //AJAX funktionen
      request.onload = function () {
        //Hvis statuskoden er OK
        if (request.status >= 200 && request.status < 400) {
          //Vi gjorde det sgu og nu får vi noget tilbage fra serveren
          var resp = request.responseText;
          if (resp == "success") {
            vm.loggedIn = true;
            vm.tryAgain = false;
          } else {
            vm.loggedIn = false;
            vm.tryAgain = true;
          }
        } else {
          alert("Ja, vi kom igennem til serveren, men der skete en fejl.");
        }
      };

      request.onerror = function () {
        alert("Vi kom slet ikke i forbindelse med serveren");
      };
      //Metode som sender det request vi har gjort klart indtil videre
      request.send();
    }
  }
});
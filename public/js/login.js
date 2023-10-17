new Vue({
    el : '#login-form',
    data : {
      passwordFieldType : 'password',
    },
    methods : {
        togglePasswordType(){
            this.passwordFieldType = this.passwordFieldType == 'password' ? 'text' : 'password';
        }
    }
  })
new Vue({
    el : '#register-form',
    data : {
        atLeast3 : false,
        password : '',
        password_confirmation : '',
        passwordLengthValid : false,
        passwordLowerValid : false,
        passwordUpperValid : false,
        passwordNumberValid : false,
        passwordSpecialValid : false,
        passwordFieldType : 'password',
        confirmPasswordFieldType : 'password',
    },
    methods : {
        //check validation from input
        validatePassword() {
            this.passwordLengthValid = this.password.length > 8 ? true : false;
            this.passwordLowerValid = /[a-z]/.test(this.password)? true : false;
            this.passwordUpperValid =/[A-Z]/.test(this.password)? true : false;
            this.passwordNumberValid = /[0-9]/.test(this.password)? true : false;
            this.passwordSpecialValid = /[!@#$%^&*]/.test(this.password)? true : false;
            const trueCount = [
                this.passwordLowerValid,
                this.passwordUpperValid,
                this.passwordNumberValid,
                this.passwordSpecialValid
            ].filter(value => value).length;
            this.atLeast3 = trueCount >= 3 ? true : false;
        },
        togglePasswordVisibility() {
            this.passwordFieldType = this.passwordFieldType == 'password'? 'text' : 'password';
        },
        toggleConfirmPasswordVisibility() {
            this.confirmPasswordFieldType = this.confirmPasswordFieldType == 'password'? 'text' : 'password';
        }
    }
})

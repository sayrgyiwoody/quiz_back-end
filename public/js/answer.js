

new Vue({
    el : '#answer',
    data : {
        formTitle : '',
        selectedChoice : '',
        answer : '',
        questionText : '',
        multipleText : '',
        questionList : '',
        currentQuiz : 1,
        answerStatus : null,
        marks : 0,
        try : 1,
        darkModeStatus : false,
        answerMessage : '',
        nextQuiz : 'Next Quiz',
        question_id : 0,
        quiz_id : '',//quiz id in db
        search_input : '',
        searched_quizzes : '',
        currentPage : 1,
        itemsPerPage : 4,
        loading : false,
    },
    computed : {

        paginatedQuizzes() {
            return this.questionList.slice(this.currentQuiz-1,this.currentQuiz);
        },
        paginatedQuestions() {
            // const descList = this.questionList.slice().reverse();
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.searched_quizzes.slice(startIndex,endIndex);
        },
        totalPages() {
            return Math.ceil(this.searched_quizzes.length/this.itemsPerPage);
        }
    },
    mounted() {
        this.loadFromLocalStorage();
        const darkModeStored = localStorage.getItem('darkMode');
        if(darkModeStored!==null) {
            this.darkModeStatus = JSON.parse(darkModeStored);
        }
    },
    filters: {
        formatDate(timestamp) {
          const date = new Date(timestamp);
          const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true,
          };
          return date.toLocaleString('en-US', options);
        },
      },
    methods: {
        clearSearchInput() {
            this.search_input = '';
        },
        truncatedDesc(desc) {
            if (desc.length > 50) {
                return desc.substring(0, 50) + "...";
              }
              return desc;
        },
        showRules(){
            Swal.fire({
                title: 'Quiz Rules',
                text: "If you get it right on your first try, you get a mark. If you have a problem with an answer or don't know an answer, click Need Answer?. However, requesting answers does not earn marks for this quiz.",
                imageUrl: '/images/good.gif',
                imageAlt: 'Rules',
                imageWidth: '300',
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Understood !",
              })
        },
        changeURL(id) {
            window.location.assign(`/answerCheck/${id}`);
          },
        //search
        search(){
            if (this.search_input.length >= 3) { // Adjust the minimum search query length as needed
                axios.get('/quiz/search', { params: { search_key: this.search_input } })
                  .then(response => {
                    this.searched_quizzes = response.data;
                  })
                  .catch(error => {
                    console.error(error);
                  });
              } else {
                // this.searchResults = [];
              }
        },
        backToHome(){
            Swal.fire({
                title: 'Are you sure?',
                text: "Your all current processes will be lost.",
                imageUrl: '/images/fail.gif',
                imageAlt: 'back',
                imageWidth: '300',
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText: "No",
                cancelButtonColor: '#d33',
              }).then((result)=>{
                if(result.isConfirmed){
                    window.location.assign('/home');
                }
              })
        },
        getQuestionList() {
            Swal.fire({
                title: 'Are you ready?',
                text: "You cannot proceed to the next quiz until you select or enter the correct answer.",
                imageUrl: '/images/lazy.gif',
                imageWidth: '300',
                imageAlt: 'Ready',
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Let's do this!",
              }).then((result)=>{
                if(result.isConfirmed){
                    this.question_id = appData.question.id;
                    axios.post('getQuestionList',{id : this.question_id}).then(response=>{
                        this.questionList = response.data.question_list;
                        this.formTitle = response.data.question.title;
                        this.quiz_id = response.data.question.id;
                    }).catch(error=>{
                        console.log('error');
                    })
                }
              })

        },

        isCurrentRoute(route){
            return window.location.pathname === route;
        },
        // toggle dark mode
        toggleDarkMode() {
            this.darkModeStatus = !(this.darkModeStatus);
            localStorage.setItem('darkMode', JSON.stringify(this.darkModeStatus));
        },
        //load questionList from local storage
        loadFromLocalStorage() {
            const localQuestionList = localStorage.getItem('questionList');
            const localFormTitle = localStorage.getItem('formTitle');
            if(localQuestionList) {
                this.questionList = JSON.parse(localQuestionList);
                this.formTitle = JSON.parse(localFormTitle);
            }
        },
        checkAnswer(question_id){
            this.answerMessage = null;
            if(this.answer !== '') {
                this.loading = true;
            }else if (this.answer === '' && this.selectedChoice) {
                this.loading = true;
            }
            if((this.selectedChoice!=='' || this.answer !== '') && this.answerStatus !== true) {
                axios.post('checkAnswer',{quiz_id : this.quiz_id , question_id : question_id,user_answer:this.answer,user_choice:this.selectedChoice})
                .then(response=>{
                    this.loading = false;
                    this.answerStatus=response.data;
                    if(this.answerStatus === true) {
                        if(this.try ==1) {
                            this.marks++;
                            this.try--;
                        }
                        this.nextQuiz = (this.currentQuiz === this.questionList.length)? 'View Your Marks' : 'Next Quiz';
                        if(this.currentQuiz === this.questionList.length){
                            this.answerMessage = "<i class='fa-solid fa-thumbs-up me-2'></i>Congratulations on finishing all the quizzes! Now it's time to check your marks. Good luck, and remember to be proud of your hard work.";


                        }else {
                            this.answerMessage = '<i class="fa-solid fa-thumbs-up me-2"></i>Your answer is correct and now you can move to the next quiz.';


                        }
                    }else{
                        this.answerMessage = '<i class="fa-solid fa-thumbs-down me-2"></i>Your answer is incorrect, try again for the correct answer.';

                        if(this.try === 1) {
                            this.try--;
                        }
                    }
                }).catch(error=>{
                    this.loading = false;
                    console.log('error')
                })

            }
        },
        changePage(pageNumber) {
            if(pageNumber >= 1 && pageNumber <= this.totalPages) {
                this.currentPage = pageNumber;
            }
        },
        changeQuiz(quizNumber) {

            this.try = 1;
            this.answerStatus = null;
            this.currentQuiz = quizNumber;
            this.selectedChoice = '';
            this.answer = '';

            if(quizNumber === (this.questionList.length + 1)) {
                const marks = Math.floor(this.marks / (this.questionList.length/100));
                Swal.fire({
                    title: 'Congratulations',
                    html: `<b class="text-primary fs-4">You got ${marks}/100 marks.</b>`,
                    imageUrl: '/images/congratulation.gif',
                    imageAlt: 'Congratulation',
                    confirmButtonText: 'Back to Home',
                }).then((result)=> {
                    if(result.isConfirmed) {
                        this.marks = 0;
                        this.currentQuiz = 1;
                    }
                    window.location.replace('/home');
                });
            }

        },
        showAnswer(question_id) {
            Swal.fire({
                title: 'Need answer?',
                text: "You won't get any marks if you request for the answer,",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No, I'll try myself"
              }).then((result) => {
                if (result.isConfirmed) {
                    this.try--;
                    axios.post('getAnswer',{quiz_id : this.quiz_id , question_id : question_id}).then(response=>{
                        const answer = response.data;
                        Swal.fire({
                            title: 'Answer for Quiz ' + this.currentQuiz ,
                            html: `<b class="text-primary fs-4">${answer}</b>`,
                            imageUrl: '/images/hint.gif',
                            imageAlt: 'Preett',
                        });
                    }).catch(error=>{
                        console.log('error');
                    })

                }
              })

        },


    },

})




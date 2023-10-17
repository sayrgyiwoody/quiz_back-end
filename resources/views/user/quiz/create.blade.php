@extends('user.layout.master')
@section('vue-id')
<div id="main">
@endsection
@section('previewDiv')
<div class="d-md-none me-4">
    <button ref="previewToggle" class="rounded border-0 px-3 w-100 py-2" :class="{'text-light bg-muted':darkModeStatus,'border border-2':!darkModeStatus}"  @click="togglePreview">
      <i class="bi bi-ui-checks-grid me-2"></i>Preview
    </button>
  </div>
@endsection

@section('content')
<div class="row mt-10" id="create" >
    <!-- <div class="d-md-none pt-3">
      <button ref="previewToggle" class="btn btn-primary w-100 py-2" @click="togglePreview">
        <i class="bi bi-ui-checks-grid me-2"></i>Preview Quiz
      </button>
    </div> -->
    <div v-if="!previewMode || !isMobile" class="col-md-4 offset-md-1 p-3 mt-2 mt-lg-0" id="create-box">
      <div id="form-create" class="form-create p-4 rounded" :class="{'bg-white shdw':!darkModeStatus,'card-body-dark':darkModeStatus}">
        <div class="d-flex align-items-center justify-content-between">
          <div class="">
            <h3 class="fw-bold"><i class="bi bi-ui-checks me-2"></i>Quiz builder</h3>
            <span :class="{'text-light opacity-50':darkModeStatus,'text-muted':!darkModeStatus}" class="fw-semibold">Create your own quiz forms</span>
          </div>
          <button @click="removeChoice()" v-show="selectOption === 'option2' && choices.length > 1 "
            class="btn bg-white fw-semibold border border-2 border-primary"><i
              class="bi bi-arrow-counterclockwise fs-5 fw-semibold"></i> undo</button>
        </div>
        <hr>
        <div class="input-gp mt-4">
          <input required="" name="formTitle" type="text" v-model="formTitle" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}">
          <label for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Enter Form Title</label>
        </div>
        <label for="" class="form-label"></label>
        <textarea v-model="formDesc" :class="{'answer-input':!darkModeStatus,'answer-input-dark':darkModeStatus}" class=" mb-4" rows="4" cols="" placeholder="Quiz description here"></textarea>
        <p>
          <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample" @click="toggleCaret">
            Choose Question Type <i class="bi align-middle"
              :class="{'bi-caret-up-fill':isCaretUp,'bi-caret-down-fill' : !isCaretUp}"></i>
          </button>
        </p>
        <div class="collapse" id="collapseExample">
          <div :class="{'card':!darkModeStatus,'answer-input-dark':darkModeStatus}" class="card px-3 py-2">
            <div class="form-check mb-2">
              <input v-model="selectOption" class="form-check-input" type="radio" value="option1"
                name="flexRadioDefault" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">
                Question
              </label>
            </div>
            <div class="form-check mb-2">
              <input v-model="selectOption" class="form-check-input" type="radio" value="option2"
                name="flexRadioDefault" id="flexRadioDefault2">
              <label class="form-check-label" for="flexRadioDefault2">
                Multiple Choices
              </label>
            </div>
          </div>
        </div>

        <form v-show="selectOption === 'option1'" @submit.prevent="addToForm">
          <div class="row">
            <div class="col-sm-12">
              <!-- question input start -->
              <div class="input-gp mt-4 mb-3">
                <input required="" name="questionInput" type="text" v-model="questionText" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}">
                <label for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Enter Question</label>
              </div>
              <div v-if="questionText" class="input-gp mb-1">
                <input required="" name="" type="text" v-model="answer" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}">
                <label for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Enter Answer</label>
              </div>
              <!-- question input end  -->
            </div>

          </div>


          <button v-if="editStatus == false" type="submit" class="create-btn border border-2 border-primary btn btn-white mt-3">
            <span class="paragraph">Add form</span>
            <span class="icon-wrapper">
              <svg class="icon mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M10 18V16H8V14H10V12H12V14H14V16H12V18H10Z" fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z"
                  fill="currentColor" /></svg>
            </span>
          </button>
          <button  v-if="editStatus == true"  class="create-btn border border-2 border-primary btn btn-white mt-3">
            <span class="paragraph">Edit form</span>
            <span class="icon-wrapper">
              <svg class="icon mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M21.2635 2.29289C20.873 1.90237 20.2398 1.90237 19.8493 2.29289L18.9769 3.16525C17.8618 2.63254 16.4857 2.82801 15.5621 3.75165L4.95549 14.3582L10.6123 20.0151L21.2189 9.4085C22.1426 8.48486 22.338 7.1088 21.8053 5.99367L22.6777 5.12132C23.0682 4.7308 23.0682 4.09763 22.6777 3.70711L21.2635 2.29289ZM16.9955 10.8035L10.6123 17.1867L7.78392 14.3582L14.1671 7.9751L16.9955 10.8035ZM18.8138 8.98525L19.8047 7.99429C20.1953 7.60376 20.1953 6.9706 19.8047 6.58007L18.3905 5.16586C18 4.77534 17.3668 4.77534 16.9763 5.16586L15.9853 6.15683L18.8138 8.98525Z"
                  fill="currentColor" />
                <path d="M2 22.9502L4.12171 15.1717L9.77817 20.8289L2 22.9502Z" fill="currentColor" /></svg>
            </span>
          </button>
        </form>
        <form v-show="selectOption === 'option2'" @submit.prevent="addToForm">
          <div class="row">
            <div class="col-sm-12">
              <div class="input-gp my-3">
                <input required="" name="choiceText" type="text" v-model="multipleText" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}">
                <label for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Enter Multiple Choice Question</label>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="input-gp mb-3 " v-for="(c,index) in choices" :key="index">
                <input required="" :name="'choiceInput' + index" type="text" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}" v-model="c.choice">

                <label for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Enter Choice @{{ index+1 }}</label>
                <div v-show="index == choices.length - 1" @click="addChoice" class="input-icon"><i
                    class="bi bi-plus-circle-fill" :class="{'text-primary':!darkModeStatus,'text-info':darkModeStatus}"></i></div>
              </div>
              <select v-if="choices[0].choice" name="" v-model="answer" :class="{'card-body-dark':darkModeStatus}"  class="form-select p-3 border-1 border-secondary mb-2">
                <option value="">Choose Answer</option>
                <option :value="c.choice" v-for="c in choices">@{{ c.choice }}</option>
              </select>
              <span v-if="answerValidateStatus == false" class="text-danger mt-2">Please choose answer for form.</span>
            </div>
          </div>
          <button type="submit" v-if="editStatus == false" class="create-btn border border-2 border-primary btn btn-white mt-2">
            <span class="paragraph">Add form</span>
            <span class="icon-wrapper">
              <svg class="icon mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M10 18V16H8V14H10V12H12V14H14V16H12V18H10Z" fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z"
                  fill="currentColor" /></svg>
            </span>
          </button>
          <button  v-if="editStatus == true"  class="create-btn border border-2 border-primary btn btn-white mt-2">
            <span class="paragraph">Edit form</span>
            <span class="icon-wrapper">
              <svg class="icon mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M21.2635 2.29289C20.873 1.90237 20.2398 1.90237 19.8493 2.29289L18.9769 3.16525C17.8618 2.63254 16.4857 2.82801 15.5621 3.75165L4.95549 14.3582L10.6123 20.0151L21.2189 9.4085C22.1426 8.48486 22.338 7.1088 21.8053 5.99367L22.6777 5.12132C23.0682 4.7308 23.0682 4.09763 22.6777 3.70711L21.2635 2.29289ZM16.9955 10.8035L10.6123 17.1867L7.78392 14.3582L14.1671 7.9751L16.9955 10.8035ZM18.8138 8.98525L19.8047 7.99429C20.1953 7.60376 20.1953 6.9706 19.8047 6.58007L18.3905 5.16586C18 4.77534 17.3668 4.77534 16.9763 5.16586L15.9853 6.15683L18.8138 8.98525Z"
                  fill="currentColor" />
                <path d="M2 22.9502L4.12171 15.1717L9.77817 20.8289L2 22.9502Z" fill="currentColor" /></svg>
            </span>
          </button>
        </form>
      </div>
    </div>

    <div v-if="previewMode || !isMobile" id="form-preview" class="col-md-6 p-md-3 ps-md-0">
      <div class="preview-container overflow-auto">
        <div class="preview-heading shdw rounded py-4 px-4" :class="{'bg-dark border border-2 border-light text-white':darkModeStatus,'bg-white border border-2 border-dark':!darkModeStatus}" >
          <h4 class="fw-bold"><span><b class="me-1" :class="{'text-success':darkModeStatus,'text-primary':!darkModeStatus}">Form Title :</b> @{{ formTitle }} </span></h4>
          <span class="fw-semibold" :class="{'text-muted':!darkModeStatus,'text-light':darkModeStatus}">Total Quizzes : @{{ questionList.length }} </span>
          <p class="text-warning fw-semibold mt-3" v-if="questionList.length === 0"><i
              class="bi bi-info-square me-2"></i>No form added here</p>
        </div>
        <div class="preview-form px-2 px-md-4">
          <div class="" v-for="question in paginatedQuestions" :key="question.id">
            <div class="d-flex">
              <div class="btn rounded-bottom-0 btn-primary me-2 fw-semibold" :class="{'btn-primary':!darkModeStatus,'btn-light':darkModeStatus}">
                Question @{{ question.id + 1 }}
              </div>
              <div class="d-flex">
                <div class="border-0 me-2  d-flex align-items-center fw-semibold" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}"
                  @click="editForm(question.id)">
                  <i class="bi bi-pencil-square fs-5 me-2 fw-semibold" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}"
                    style="cursor: pointer;"></i><span>Edit</span>
                </div>
                <span class="fw-semibold fs-4 me-2" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}">|</span>
                <div class="border-0 d-flex align-items-center fw-semibold" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}"
                  @click="removeQuestion(question.id)">
                  <i class="bi bi-dash-circle fs-5 me-2 fw-semibold" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}"
                    style="cursor: pointer;"></i><span>Remove</span>
                </div>
              </div>
            </div>
            <div :class="{'bg-muted':darkModeStatus}" class="form-box card card-body pb-0 mb-4 border border-2 rounded-top-0 rounded-end">

              <div class="d-flex justify-content-between">
                <div class="mb-2">
                  <p class="fw-semibold mb-1" v-if="question.questionText">@{{ question.questionText }}</p>
                  <div v-if="question.multipleText">
                    <p class="mb-0 fw-semibold">@{{ question.multipleText }}</p>
                  </div>
                </div>
              </div>
              <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="form-check">
                <input class="form-check-input" :name="'choice'+question.id"
                  :id="'choice' + question.id + choiceIndex" type="radio" v-model="question.selectedChoice"
                  :value="choice">
                <label class="form-check-label" :for="'choice' + question.id + choiceIndex">
                  @{{ choice }}
                </label>
              </div>
              <input v-if="question.questionText" placeholder="Your answer here" name="userAnswer" type="text"
                class="answer-input">
                <p class="my-2">( Answer : <span class="fw-semibold text-success">@{{ question.answer }}</span> )</p>
            </div>
          </div>
        </div>
        <div v-if="totalPages>=1" class="float-end me-md-2" :class="{'text-white':darkModeStatus}">
          <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="btn border-0" :class="{'text-white':darkModeStatus}"><i class="bi bi-arrow-left-square fs-3"></i></button>
        Page @{{ currentPage }} / @{{ totalPages }}
        <button @click="changePage(currentPage + 1)" :disabled="currentPage >= totalPages" class="btn border-0" :class="{'text-white':darkModeStatus}"><i class="bi bi-arrow-right-square fs-3"></i></button>
        </div>

      </div>
      <div class="preview-footer ms-4 d-flex">
        <button  @click="sendToDatabase" class="create-btn bg-white shdw mt-3 rounded-0 rounded-start-2">
          <span class="paragraph ms-3">Upload</span>
          <span class="icon-wrapper">
            <svg class="icon mb-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M14.8543 11.9741L16.2686 10.5599L12.0259 6.31724L7.78327 10.5599L9.19749 11.9741L11.0259 10.1457V17.6828H13.0259V10.1457L14.8543 11.9741Z"
                fill="currentColor" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1 19C1 21.2091 2.79086 23 5 23H19C21.2091 23 23 21.2091 23 19V5C23 2.79086 21.2091 1 19 1H5C2.79086 1 1 2.79086 1 5V19ZM5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21Z"
                fill="currentColor" /></svg>
          </span>
        </button>
        <button @click="deleteAll" class="create-btn bg-white shdw my-3 rounded-0 rounded-end-2">
          <span class="paragraph ms-2 text-danger">Delete All</span>
          <span class="icon-wrapper">
            <svg class="icon mb-1 text-danger" width="24" height="24" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z"
                fill="currentColor" />
              <path d="M9 9H11V17H9V9Z" fill="currentColor" />
              <path d="M13 9H15V17H13V9Z" fill="currentColor" /></svg>
          </span>
        </button>

      </div>
    </div>

  </div>
@endsection

@section('scriptSource')
<script src="{{asset('./js/main.js')}}"></script>
@endsection

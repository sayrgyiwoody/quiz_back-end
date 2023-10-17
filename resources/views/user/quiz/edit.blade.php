@extends('user.layout.master')

@section('vue-id')
<div id="edit">
@endsection

@section('content')
<div class="col-md-6 offset-md-3 swiper-container" style="height: 40vh;margin-top: 100px;">

    <div class="row mt-4">
        @foreach ($question as $q)
        <div class="col-md-6">
            <div class="card info-card card-body mb-3 " :class="{'card-body-dark':darkModeStatus,'bg-white border border-2':!darkModeStatus}">
                <h4 class="fw-bold">{{$q->title}}</h4>
                <span :class="{'text-muted':!darkModeStatus,'text-light opacity-75':darkModeStatus}" class="m-0">{{Str::limit($q->desc,100,'...')}}</sp>
                    <input class="question_id" type="hidden" value="{{$q->id}}">
                    <div class="row g-2 mt-1">
                    <div class="col">
                    <a href="" class="btn btn-light my-2 w-100" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="fa-solid fa-pen me-2"></i>Edit</a>
                    </div>
                    <div class="col">
                    <button class="btn btn-light my-2 w-100 btn-delete" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="fa-solid fa-trash me-2"></i>Delete</button>

                    </div>
                </div>


            </div>
        </div>
        @endforeach



    </div>
</div>
@endsection

@section('scriptSource')
<script src="{{asset('js/edit.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        $('.btn-delete').click(function(){
            $parentNode = $(this).parents('.card');
            $question_id = $parentNode.find('.question_id').val();
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected quiz will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        url: '/user/quiz/delete',
                        type: 'POST',
                        dataType : "json",
                        data : {'question_id':$question_id},
                        success: function(response) {

                            console.log('Quiz deleted successfully');
                        },
                        error: function(xhr, status, error) {

                            console.log(error);
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your quiz has been deleted.',
                        'success'
                      ).then((result)=>{
                        if(result.isConfirmed) {
                            window.location.reload();
                        }
                      })
                }
              })

        })
    })
</script>
@endsection

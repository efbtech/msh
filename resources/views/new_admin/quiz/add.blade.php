@extends('new_admin.layouts.app')

@section('content')

<add-question-section></add-question-section>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Quiz</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Create Quiz</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title" style="color:green">Create Quiz</h3>
                  <!-- <a href="#" class="btn btn-primary float-sm-right  " role="button" aria-disabled="true">Add Question</a> -->

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <!-- <add-question-form></add-question-form> -->

                @if ($errors->any())
                    <div class="alert alert-danger">
                        There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.quiz.create') }}" method="POST">
                @csrf

                        <div class="form-group">
                            <label for="title"  style="color:darkgreen"> Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title">
                        </div>
                        
                        <div class="form-group">
                            <label for="description"  style="color:darkgreen"> Description</label>
                            <textarea class="form-control" name="description"  rows="3" placeholder="Type Your description Here.."></textarea>
        
                        </div>

                        <div class="form-group">
                            <label for="questions" style="color:darkgreen">Select multiple Question</label>
                            <select multiple class="form-control"  name="questions[]" >
                            @foreach($questions as $question)
                            <option value="{{$question->id}}" >{{$question->question}}</option>
                            @endforeach
                            </select>

                        </div>

    
                        <div class="form-group">
                            <label for="totaltime"  style="color:darkgreen"> Total Time</label>
                            <input type="number" class="form-control" name="totaltime" placeholder="total time ">
                        </div>


                        <!-- <div class="form-group" >
                       
                            <label for="exampleFormControlInput1">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Example select</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Example multiple select</label>
                            <select multiple class="form-control" id="exampleFormControlSelect2">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            </select>
                        </div> -->

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Create Quiz</button>
                                </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
      </div>
    </div>
  </section>
@endsection


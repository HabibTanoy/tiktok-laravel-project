@extends('master',['from' => 'ERROR'])
@section('content')
    <div class="container-fluid text-center" style="min-height: 75vh">
       <div class="mt-5" style="margin-top: 150px !important;">
           <img src="{{asset('/assets/image/something-wrong.png')}}" alt="">
           <br>
           <br>
           @if(isset($code) && $code == 'REACHED_LIMIT')
               <h3><b>YOU HAVE REACHED YOUR DAILY LIMIT!PLEASE TRY AGAIN TOMORROW!</b></h3>
           @else
               <h3><b>SOMETHING WENT WRONG!</b></h3>
           @endif
       </div>
    </div>
@endsection

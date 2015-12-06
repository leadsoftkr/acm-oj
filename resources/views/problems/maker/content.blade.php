@extends('master')

@section('content')

  @include('problems.maker.step',
    ['step1' => 'active', 'step2' => 'disabled', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(['url' => '/problems/create/', 'class' => 'ui form', 'id' => 'problem']) !!}

  @include('problems.maker.form')

  <div class="ui divider hidden"></div>

  <div class="ui centered grid">
    {!! Form::submit('다음 단계', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

@stop

@section('script')
  <script>
  $('.ui.dropdown').dropdown();
  $('button.preview')
    .on('click', function(){
      var form = $('form').has($(this));
      form.attr('action', $(this).attr('action'));
      form.submit();
    })
  ;
  </script>
@stop
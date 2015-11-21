@extends('master')

@section('content')
  <table class="ui striped blue table compact unstackable">
    <thead>
      <tr>
        <th>채점 번호</th>
        <th>제출자</th>
        <th>문제</th>
        <th>결과</th>
        <th>언어</th>
        <th>시간</th>
        <th>메모리</th>
        <th>코드 길이</th>
        <th>제출한 시간</th>
      </tr>
    </thead>
    <tbody>
    @foreach($solutions as $solution)
      <tr>
        <td>{{ $solution->id }}</td>
        <td>{{ $solution->user_id }}</td>
        <td>
          <a href="/problems/{{ $solution->problem->id }}">{{ $solution->problem->title }}</a>
        </td>
        <td>{{ $solution->result_id }}</td>
        <td>{{ $solution->lang_id }}</td>
        <td>{{ $solution->time }} MS</td>
        <td>{{ $solution->memory }} KB</td>
        <td>{{ $solution->size }} B</td>
        <td>{{ $solution->created_at->diffForHumans() }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  @include('includes.pagination', ['paginator' => $solutions])

@stop

@section('script')

@stop
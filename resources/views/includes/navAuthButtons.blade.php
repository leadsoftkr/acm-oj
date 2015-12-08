
  @if ( ! Sentinel::check() )
  <div class="ui right index sign item">
    <div class="ui breadcrumb">
      <a class="section" href="/login">로그인</a>
      <span class="divider">/</span>
      <a class="section" href="/register">회원가입</a>
    </div>
  </div>
  @else
  <div class="ui right index dropdown item">
    <img class="ui avatar image" src="/images/no-image.png">&nbsp;&nbsp;
    {{ Sentinel::getUser()->name }}
    <i class="dropdown icon"></i>
    <div class="menu">
      <a class="item" href="#">설정</a>
      <a class="item" href="/logout">로그 아웃</a>
    </div>
  </div>
  @endif
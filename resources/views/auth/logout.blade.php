
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
    <p>ログアウトしますか？</p>
    <button type="submit">ログアウト</button>
</form>

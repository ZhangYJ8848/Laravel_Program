<form action="http://cms.dev/pc_application/post" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="name">
    <input type="submit" value="submit">
</form>
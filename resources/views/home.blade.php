<html>

<body>

hello

<form action="v1/courses/6/assignments/create" method="POST">
    @csrf
    <input type="text" name="title" placeholder="title">
    <input type="text" name="due_date" placeholder="due_date">
    <input type="text" name="body" placeholder="body">
    <input type="file" name="file">
    <input type="submit">
</form>

?? {{isset($data)}} ??

@if(isset($data))
    {{$data}}
@else
    yok
@endif

</body>

</html>

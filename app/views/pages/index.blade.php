@extends('partials.master')

@section('content')
<h1>{{'Welcome!!' , Session::get('user_name')}}</h1>
<h4>your pages</h4>

<ul class="list-group">
@foreach($pages as $page)
<li class="list-group-item">{{ link_to("pages/$page->pid",$page->name)}}
</li>
@endforeach

</ul>
@stop
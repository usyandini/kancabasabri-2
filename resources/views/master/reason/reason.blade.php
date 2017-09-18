@if(count($blogs))
<h4>List data</h4>
	<ul>
		@foreach($blogs as $blog)
			<li><a href="{{ url('blog',$blog->id) }}">Judul : {{ $blog->judul }}</a></li>
		@endforeach
	</ul>
	@else
	<p>Post tidak ada.</p>
@endif
@foreach(json_decode($record->images) as $image)
    <img src="{{$image}}" alt="">
@endforeach

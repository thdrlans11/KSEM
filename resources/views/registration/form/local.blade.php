<option value="">선택</option>
@foreach( config('site.registration.local_sub')[$local] as $key => $val )
<option value="{{ $key }}" {{ ( $localSub ?? '' ) == $key ? 'selected' : '' }}>{{ $val }}</option>
@endforeach
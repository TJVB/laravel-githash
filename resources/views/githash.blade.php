<div {{ $attributes ?? ''}}>
    @if($version !== 'long')
        {{$short}}
    @endif
    @if($version !== 'short' && $version !== 'long')
        (
    @endif
    @if($version !== 'short')
        {{$githash}}
    @endif
    @if($version !== 'short' && $version !== 'long')
        )
    @endif
</div>

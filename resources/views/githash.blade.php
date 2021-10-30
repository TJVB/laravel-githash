<div {{ $attributes ?? ''}}>
    @if($version !== 'long')
        {{$short}}
        @if($version !== 'short')
            (
        @endif
    @endif
    @if($version !== 'short')
        {{$githash}}
        @if($version !== 'long'
            )
        @endif
    @endif
</div>
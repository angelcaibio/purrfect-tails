<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>{{ $title }}</h2>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            @if(!empty($url) && !empty($buttonTitle))
                <a href="{{ $url }}" 
                   class="btn btn-primary" 
                   @if(!empty($data_toggle)) data-toggle="{{ $data_toggle }}" @endif
                   @if(!empty($data_target)) data-target="{{ $data_target }}" @endif>
                   {{ $buttonTitle }}
                </a>
            @endif
        </div>
    </div>
</div>

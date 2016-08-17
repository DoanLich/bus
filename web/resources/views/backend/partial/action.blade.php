@if(isset($buttons) && !empty($buttons))
    @foreach($buttons as $index => $button)
        {{--*/ $htmlOptions = ''; /*--}}
        {{--*/ $class = ''; /*--}}
        @if(isset($button['htmlOptions']))
            @foreach($button['htmlOptions'] as $key => $option)
                @if($key == 'class')
                    {{--*/ $class .= ' ' . $option . ' '; /*--}}
                @else
                    {{--*/ $htmlOptions .= $key.'="' . $option . '" '; /*--}}
                @endif
            @endforeach
        @endif
        @if($index === 'view')
            <a {!! !isset($button['htmlOptions']['onclick']) ? 'onclick="return showModalWithAjax(this)"' : '' !!} href="{!! isset($button['url']) ? $button['url'] : '#' !!}" class="{!! $class !!}btn table-action-button btn-xs btn-{!! isset($button['type']) ? $button['type'] : 'primary' !!}" {!! $htmlOptions !!}>
                <i class="fa fa-{!! isset($button['icon']) ? $button['icon'] : 'eye' !!}"></i>
                <span class="hidden-xs hidden-sm">{!! isset($button['label']) ? $button['label'] : trans('backend/systems.view') !!}</span></a>
        @elseif($index === 'edit')
            <a href="{!! isset($button['url']) ? $button['url'] : '#' !!}" class="{!! $class !!}btn table-action-button btn-xs btn-{!! isset($button['type']) ? $button['type'] : 'primary' !!}" {!! $htmlOptions !!}>
                <i class="fa fa-{!! isset($button['icon']) ? $button['icon'] : 'pencil' !!}"></i>
                <span class="hidden-xs hidden-sm"> {!! isset($button['label']) ? $button['label'] : trans('backend/systems.edit') !!}</span>
            </a>
        @elseif($index === 'delete')
            <a {!! !isset($button['htmlOptions']['onclick']) ? 'onclick="return confirmAction(this)"' : '' !!} {!! (!isset($button['htmlOptions']['data-confirm']) && isset($button['message'])) ? 'data-confirm="'.$button['message'].'"' : '' !!} href="{!! isset($button['url']) ? $button['url'] : '#' !!}" class="{!! $class !!}btn table-action-button btn-xs btn-{!! isset($button['type']) ? $button['type'] : 'danger' !!}" {!! $htmlOptions !!}>
                <i class="fa fa-{!! isset($button['icon']) ? $button['icon'] : 'trash' !!}"></i>
                <span class="hidden-xs hidden-sm">{!! isset($button['label']) ? $button['label'] : trans('backend/systems.delete') !!}</span>
            </a>
        @else
            <a href="{!! isset($button['url']) ? $button['url'] : '#' !!}" class="{!! $class !!}btn table-action-button btn-xs btn-{!! isset($button['type']) ? $button['type'] : 'default' !!}" {!! $htmlOptions !!}>
                <i class="fa fa-{!! isset($button['icon']) ? $button['icon'] : '' !!}"></i>
                <span class="hidden-xs hidden-sm">{!! isset($button['label']) ? $button['label'] : '' !!}</span>
            </a>
        @endif
    @endforeach
@endif
<form method="POST" action="{{ route($route, ['id' => $row->id]) }}">
    @method('PUT')
    @csrf
    <input type="hidden" name="field" value="{{ $field }}">
    <input type="checkbox" name="{{ $field }}" id="switcher_{{ $row->id }}" value="1" class="switcher form-switch" switch="bool" @if($row->$field) checked @endif />
    <label class="switcher_label" for="switcher_{{ $row->id }}" data-on-label="Yes" data-off-label="No"></label>
</form>

<script>
    $(document).ready(function(){
        $('#switcher_{{ $row->id }}').on('change', function(){
            $(this).parent().submit();
        })
    });
</script>


@extends('layouts.master')

@section('title')
    @lang('translation.wikiCategory.wikiCategories')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.wikiCategory.wikiCategories')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('wiki-categories.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.name')</th>
			<th>@lang('translation.fields.action')</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('wiki-categories.index') }}",
                lengthMenu: [
                    [100, 250, 500],
                    [100, 250, 500]
                ],
                columns: [
					{
						data: 'DT_RowIndex',
						name: 'No',
						searchable: false,
					},
					{
						data: 'name',
						name: 'name',
					},
					{
						data: 'action',
						name: 'action',
					},
                ],
                initComplete: function () {
                    var tr = document.createElement('tr');

                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.header().innerHTML;

                            var th = document.createElement('th');
                            th.style.paddingLeft = '10px';
                            th.style.paddingRight = '10px';

                            let input = document.createElement('input');
                            input.placeholder = title;
                            input.style.width = '100%';

                            input.addEventListener('keyup', () => {
                                if (column.search() !== this.value) {
                                    column.search(input.value).draw();
                                }
                            });

                            th.append(input);
                            tr.append(th);
                        });

                    $('#smart-datatable').children('thead').append(tr);
                }
            });
        });
    </script>
@endsection

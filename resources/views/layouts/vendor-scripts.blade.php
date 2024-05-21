<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js')}}"></script>
<script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
<script src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    function buildDtColumns(api, columns){
        var tr = document.createElement('tr');
        var dropdowns = [];
        var dateranges = [];
        var datepickers = [];

        for(var i = 0; i < columns.length; i++){
            var th = document.createElement('th');
            th.style.paddingLeft = '10px';
            th.style.paddingRight = '10px';

            var column = columns[i];
            let dtColumn = api.columns(i);
            try{
                var searchType = columns[i].search.type;
            } catch(e){
                var searchType = 'text';
            }

            if(searchType == 'dropdown'){
                var searchUrl = columns[i].search.url;
                var columnName = column.name;

                if (typeof columns[i].search.default != 'undefined'){
                    var selectHtml = '<select class="form-control" name="'+columnName+'" id="'+columnName+'"><option value="">Select option...</option><option value="'+columns[i].search.default.value+'" selected="selected">'+columns[i].search.default.text+'</option></select>';
                } else{
                    var selectHtml = '<select class="form-control" name="'+columnName+'" id="'+columnName+'"><option value="">Select option...</option></select>';
                }


                th.insertAdjacentHTML('beforeend', selectHtml);
                tr.append(th);

                var obj = {
                    'url': searchUrl,
                    'dropdownId': '#'+columnName,
                    'dtColumn': dtColumn
                };

                dropdowns.push(obj);
            } else if(searchType == 'text'){
                let input = document.createElement('input');
                input.placeholder = column.name;
                input.style.width = '100%';
                input.className = 'form-control';

                input.addEventListener('keyup', delay(function(){
                    if (dtColumn.search() !== this.value) {
                        dtColumn.search(input.value).draw();
                    }
                }, 250));

                th.append(input);
                tr.append(th);
            } else if(searchType == 'daterange'){
                var columnName = column.name;
                var html = '<input type="text" class="form-control" id="'+columnName+'" placeholder="Select Date Range" style="min-width: 195px;">';

                th.insertAdjacentHTML('beforeend', html);
                tr.append(th);

                var obj = {
                    'id': '#'+columnName,
                    'dtColumn': dtColumn
                };

                dateranges.push(obj);
            } else if(searchType == 'datepicker'){
                var columnName = column.name;
                var html = '<input type="text" class="form-control" id="'+columnName+'" placeholder="Select Date..." style="min-width: 160px;">';

                th.insertAdjacentHTML('beforeend', html);
                tr.append(th);

                var obj = {
                    'id': '#'+columnName,
                    'dtColumn': dtColumn
                };

                datepickers.push(obj);
            } else if(searchType == 'disabled'){
                tr.append(th);
            }
        }

        $('#smart-datatable').children('thead').append(tr);

        initDtFilterDropdowns(dropdowns);
        initDtFilterDateranges(dateranges);
        initDtFilterDatepickers(datepickers);
    }

    function initDtFilterDateranges(dateranges){
        for(var i = 0; i < dateranges.length; i++) {
            let id = dateranges[i].id;
            let dtColumn = dateranges[i].dtColumn;

            $(id).daterangepicker({
                locale: {
                    'format': 'YYYY-MM-DD'
                }
            }).on('apply.daterangepicker', function(ev, picker) {
                dtColumn.search(picker.startDate.format('YYYY-MM-DD')+'::'+picker.endDate.format('YYYY-MM-DD')).draw();
            });

            dtColumn.search($(id).data('daterangepicker').startDate.format('YYYY-MM-DD')+'::'+$(id).data('daterangepicker').endDate.format('YYYY-MM-DD')).draw();
        }
    }

    function initDtFilterDatepickers(datepickers){
        for(var i = 0; i < datepickers.length; i++) {
            let id = datepickers[i].id;
            let dtColumn = datepickers[i].dtColumn;

            $(id).datepicker({
                "format": "yyyy-mm-dd"
            }).change(function() {
                if (dtColumn.search() !== this.value) {
                    dtColumn.search(this.value, true, true).draw();
                }
            });
        }
    }

    function initDtFilterDropdowns(dropdowns){
        for(var i = 0; i < dropdowns.length; i++){
            let dropdownId = dropdowns[i].dropdownId;
            let dtColumn = dropdowns[i].dtColumn;
            let url = dropdowns[i].url;

            $(dropdownId).select2({
                placeholder: 'Select an option',
                ajax: {
                    url: url,
                    delay: 250,
                    data: function (params) {
                        var query = {
                            keyword: params.term
                        }

                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.results, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            $(dropdownId).change(function(){
                dtColumn.search(this.value).draw();
            });

            dtColumn.search($(dropdownId).val()).draw();
        }
    }
</script>
@yield('script')

<!-- App js -->
<script src="{{ URL::asset('build/js/app.js')}}"></script>

@yield('script-bottom')

@stack('scripts')

<?php if(Session::has('success')): ?>
    <script type="text/javascript">
        $(function() {
            toastr.success('<?php echo e(Session::get('success')); ?>');
        });
    </script>
<?php endif; ?>
<?php if(Session::has('warning')): ?>
    <script type="text/javascript">
        $(function() {
            toastr.warning('<?php echo e(Session::get('warning')); ?>');
        });
    </script>
<?php endif; ?>
<?php if(Session::has('error')): ?>
    <script type="text/javascript">
        $(function() {
            toastr.error('<?php echo e(Session::get('error')); ?>');
        });
    </script>
<?php endif; ?>

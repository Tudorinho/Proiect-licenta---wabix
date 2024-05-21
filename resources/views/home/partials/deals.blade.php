<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Latest 20 Deals</h4>
        <div class="table-responsive">
            <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('translation.fields.title')</th>
                        <th>@lang('translation.fields.userId')</th>
                        <th>@lang('translation.fields.companiesContactsId')</th>
                        <th>@lang('translation.fields.dealsStatusesId')</th>
                        <th>@lang('translation.fields.dealsSourcesId')</th>
                        <th>@lang('translation.fields.dealSize')</th>
                        <th>@lang('translation.fields.currencyId')</th>
                        <th>@lang('translation.fields.type')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deals as $deal)
                        <tr>
                            <td>{{ $deal->title }}</td>
                            <td>{{ $deal->user->email }}</td>
                            <td>{{ $deal->companyContact->first_name.' '.$deal->companyContact->last_name.'('.$deal->companyContact->company->name.')' }}</td>
                            <td>{{ $deal->dealStatus->name }}</td>
                            <td>{{ $deal->dealSource->name }}</td>
                            <td>{{ $deal->deal_size }}</td>
                            <td>{{ $deal->currency->name }}</td>
                            <td>{{ $deal->type }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- end table-responsive -->
    </div>
</div>

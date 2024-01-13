<x-dashboard>

    {{-- title --}}
    <h1 class="mb-3">{{ __('Meeting reports') }}</h1>

    {{-- curtain --}}
    <div id="modal-curtain" class="hidden"></div>

    {{-- filter bar --}}
    <hr>
    <form action="{{ route('reporting.report') }}" method="get">
        <div class="flex gap-3 my-2 items-center flex-wrap">
            {{-- users --}}
            <label class="min-w-fit">{{ __('Users') }}</label>
            <x-form.select
                :name="'users[]'"
                :options="$users"
                :value="'id'"
                :display="'name'"
                :selected="json_encode(request()->users) ?? ''"
                class="filter-field"
                multiple
            />

            {{-- company types --}}
            <label class="min-w-fit">{{ __('Company Types') }}</label>
            <x-form.select :name="'company_types[]'" class="filter-field" :options="$companyTypes" :value="'id'"
                           :display="'name'" :selected="json_encode(request()->query('company_types')) ?? ''" multiple/>

            {{-- companies --}}
            <label class="min-w-fit">{{ __('Companies') }}</label>
            <x-form.select :name="'companies[]'" class="filter-field" :options="$companies" :value="'id'"
                           :display="'name'" :selected="json_encode(request()->query('companies')) ?? ''" multiple/>

            {{-- contacts --}}
            <label class="min-w-fit">{{ __('Contacts') }}</label>
            <x-form.select :name="'contacts[]'" class="filter-field" :options="$contacts" :value="'id'"
                           :display="'name'" :selected="json_encode(request()->query('contacts')) ?? ''" multiple/>

            {{-- date --}}
            <label for="date" class="min-w-fit">{{ __('Date') }}</label>
            <x-form.date-range-picker :name="'date_range'" :value="request()->query('date') ?? ''" class="filter-field"/>

            {{-- start time --}}

            {{-- search --}}
            <label for="search" class="min-w-fit">{{ __('Search') }}</label>
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                   class="filter-field">

            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="btn-orange min-w-[120px]">
                {{ __('Filter') }}
            </button>
            <a href="{{ route('reporting.report') }}" class="btn-transparent min-w-[120px] flex justify-center
            items-center">
                {{ __('Clear Filters') }}
            </a>

        </div>
    </form>
    <hr class="mb-3">

    {{-- list of reports --}}
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @if(count($meetings) > 0)
            @foreach ($meetings as $meeting)

                {{-- report card --}}
                <div id="report-card-{{ $meeting->id }}" class="report-card">
                    <div class="report-card-header">
                        <span>{{ __('Meeting with: ') . $meeting->contact->name }}</span>
                    </div>
                    <div class="report-card-body">
                        <div class="report-card-body-item">
                            <x-icon.company class="w-5"/>
                            <span>{{ strlen($meeting->contact->company->name) > 20 ? substr($meeting->contact->company->name,0,20)."..." : $meeting->contact->company->name }}</span>
                        </div>
                        <div class="report-card-body-item">
                            <x-icon.date-picker class="w-5"/>
                            <span>{{ $meeting->date }}</span>
                        </div>
                    </div>
                    <div class="report-card-footer">
                        <x-icon.users class="w-5"/>
                        <span>{{ $meeting->user->name }}</span>
                    </div>
                </div>

                {{-- report modal --}}
                <div id="report-modal-{{ $meeting->id }}" class="hidden">
                    <div class="report-card">
                        <div class="report-card-header">
                            <span>{{ __('Meeting with: ') . $meeting->contact->name }}</span>
                        </div>
                        <div class="report-card-body">
                            <div class="report-card-body-item">
                                <x-icon.company class="w-5"/>
                                <span>{{ strlen($meeting->contact->company->name) > 20 ? substr($meeting->contact->company->name,0,20)."..." : $meeting->contact->company->name }}</span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.date-picker class="w-5"/>
                                <span>{{ $meeting->date }}</span>
                            </div>
                            <div class="report-card-body-item">
                                <p>{{ __('Objective') . $meeting->objective }}</p>
                            </div>
                            <div class="report-card-body-item">
                                <p>{{ __('Marketing Requirements') . $meeting->marketing_requirements }}</p>
                            </div>
                        </div>
                        <div class="report-card-footer">
                            <x-icon.users class="w-5"/>
                            <span>{{ $meeting->user->name }}</span>
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            <p>No results found</p>
        @endif
    </ul>
    <br/>

    {{-- pagination --}}
    {{ $meetings->appends([
        'search' => request()->query('search') ?? '',
        'status' => request()->query('order_by') ?? '0',
        'supplier' => request()->query('order_direction') ?? '0',
    ])->links() }}

</x-dashboard>

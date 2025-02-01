<x-dashboard>

    {{-- title --}}
    <div class="flex items-center justify-between py-2">
        <h1>{{ __('Calendar export') }}</h1>
    </div>

    {{-- filters --}}
    <hr class="mb-2">
    <form
        action="{{ route('calendar.export') }}"
        method="get"
        target="_blank"
    >
        {{-- user, date and export button --}}
        <div class="mb-2 flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="flex flex-col gap-2 lg:flex-row lg:gap-3">
                {{-- user --}}
                <div>
                    <label
                        class="mb-1"
                        for="user"
                    >{{ __('User') }}</label>
                    <x-form.select
                        class="selector-for-js filter-field"
                        style="width:100%;"
                        :name="'user'"
                        :options="$users"
                        :value="'id'"
                        :display="'name'"
                    />
                </div>

                {{-- year --}}
                <div>
                    <label
                        class="mb-1"
                        for="year"
                    >{{ __('Year') }}</label>
                    <x-form.input
                        class="filter-field"
                        name="year"
                        type="number"
                        value="{{ date('Y') }}"
                        min="2000"
                        max="{{ date('Y') + 3 }}"
                    >
                        <x-icon.date-picker class="text-darkgray absolute left-3 top-1/2 w-5 -translate-y-1/2" />
                    </x-form.input>
                </div>

                {{-- month --}}
                <div>
                    <label
                        class="mb-1"
                        for="month"
                    >{{ __('Month') }}</label>
                    <select
                        class="selector-for-js filter-field"
                        name="month"
                        style="width:100%;"
                    >
                        @foreach ($months as $value => $month)
                            <option
                                value="{{ $value }}"
                                @if (date('m') == $value) selected @endif
                            >
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    class="btn-orange min-w-[120px]"
                    type="submit"
                >
                    {{ __('Export') }}
                </button>
            </div>
        </div>

        {{-- lookup fields --}}
        <div class="flex flex-col gap-2">
            <label for="lookup">{{ __('Fields to show') }}</label>
            <div class="flex flex-col gap-1">
                @foreach ($fields as $value => $display)
                    <label class="flex items-center gap-1">
                        <input
                            class="cursor-pointer"
                            name="lookup[]"
                            type="checkbox"
                            value="{{ $value }}"
                        >
                        {{ $display }}
                    </label>
                @endforeach
            </div>
        </div>

    </form>

</x-dashboard>

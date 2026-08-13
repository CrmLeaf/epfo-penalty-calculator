@props([
    'action' => null,
    'method' => 'post',
    'defaults' => [],
    'input' => [],
    'result' => null,
    'error' => null,
    'heading' => 'EPFO Penalty Calculator',
    'tagline' => 'Interest under section 7Q and damages under 14B on delayed PF deposits.',
    'showWorking' => true,
])

<section class="crmleaf-tool crmleaf-tool--epfo-penalty-calculator" data-crmleaf-tool="epfo-penalty-calculator">
    <header class="crmleaf-tool__header">
        <h2 class="crmleaf-tool__heading">{{ $heading }}</h2>
        <p class="crmleaf-tool__tagline">{{ $tagline }}</p>
    </header>

    @if ($error)
        <p class="crmleaf-tool__error" role="alert">{{ $error }}</p>
    @endif

    <form class="crmleaf-tool__form"
          method="{{ strtolower($method) === 'get' ? 'get' : 'post' }}"
          action="{{ $action }}"
          data-crmleaf-form>
        @if (strtolower($method) !== 'get')
            @csrf
        @endif

        <label class="crmleaf-field">
            <span>Contribution deposited late</span>
            <input type="number" step="0.01" min="0" inputmode="decimal" name="contribution_amount" value="{{ old('contribution_amount', $input['contribution_amount'] ?? ($defaults['contribution_amount'] ?? '')) }}" required>
        </label>

        <label class="crmleaf-field">
            <span>Wage month</span>
            <input type="date" name="wage_month" value="{{ old('wage_month', $input['wage_month'] ?? ($defaults['wage_month'] ?? '')) }}" required>
            <small>Any date within the wage month; the due date is the fifteenth of the month after.</small>
        </label>

        <label class="crmleaf-field">
            <span>Date actually deposited</span>
            <input type="date" name="actual_payment_date" value="{{ old('actual_payment_date', $input['actual_payment_date'] ?? ($defaults['actual_payment_date'] ?? '')) }}" required>
        </label>

        <label class="crmleaf-field">
            <span>Rates as on</span>
            <input type="date" name="as_of" value="{{ old('as_of', $input['as_of'] ?? ($defaults['as_of'] ?? '')) }}">
        </label>

        <input type="hidden" name="tool" value="epfo-penalty-calculator">

        <div class="crmleaf-tool__actions">
            <button type="submit" class="crmleaf-tool__submit">Calculate</button>
        </div>
    </form>

    {{-- The client-side path writes its answer here; the server-side path fills it below. --}}
    <div class="crmleaf-tool__output" data-crmleaf-output hidden></div>

    @if ($result)
        <div class="crmleaf-tool__result">
            <p class="crmleaf-tool__explain"><code>{{ $result->explain() }}</code></p>

            <table class="crmleaf-tool__figures">
                <tbody>
                @foreach ($result->toArray() as $key => $value)
                    @continue(is_array($value) || str_ends_with((string) $key, '_formatted'))
                    <tr>
                        <th scope="row">{{ ucfirst(str_replace('_', ' ', (string) $key)) }}</th>
                        <td>{{ $result->toArray()[$key.'_formatted'] ?? (is_bool($value) ? ($value ? 'Yes' : 'No') : $value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if ($showWorking && count($result->steps()))
                <details class="crmleaf-tool__working" open>
                    <summary>How this was worked out</summary>
                    <ol>
                        @foreach ($result->steps() as $step)
                            <li>
                                <span class="crmleaf-step__label">{{ $step->label }}</span>
                                @if ($step->amount)
                                    <span class="crmleaf-step__amount">{{ $step->amount->format() }}</span>
                                @endif
                                @if ($step->formula)
                                    <code class="crmleaf-step__formula">{{ $step->formula }}</code>
                                @endif
                                @if ($step->citation)
                                    <small class="crmleaf-step__citation">{{ $step->citation }}</small>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </details>
            @endif

            @if (count($result->citations()))
                <ul class="crmleaf-tool__citations">
                    @foreach ($result->citations() as $citation)
                        <li>{{ $citation }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
</section>

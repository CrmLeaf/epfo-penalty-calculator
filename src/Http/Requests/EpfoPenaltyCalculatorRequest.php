<?php

declare(strict_types=1);

namespace Crmleaf\Payroll\Tools\EpfoPenaltyCalculator\Http\Requests;

use Crmleaf\Payroll\Money;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the wire input for EPFO Penalty Calculator and turns it into named arguments
 * for Crmleaf\Payroll\Calculators\EpfoPenaltyCalculator::calculate().
 *
 * Optional fields that were not sent are left out of the payload entirely
 * rather than passed as null, so the calculator's own documented defaults apply
 * and there is exactly one place each default is written down.
 */
final class EpfoPenaltyCalculatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        if (!$this->submitted()) {
            return [];
        }

        return [
            'contribution_amount' => ['required', 'numeric', 'min:0'],
            'wage_month' => ['required', 'date'],
            'actual_payment_date' => ['required', 'date'],
            'as_of' => ['nullable', 'date'],
        ];
    }

    /**
     * Named arguments for EpfoPenaltyCalculator::calculate().
     *
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        /** @var array<string, mixed> $input */
        $input = $this->validated();

        $payload = [
            'contributionAmount' => Money::fromRupees((float) $input['contribution_amount']),
            'wageMonth' => new \DateTimeImmutable((string) $input['wage_month']),
            'actualPaymentDate' => new \DateTimeImmutable((string) $input['actual_payment_date']),
        ];

        if (array_key_exists('as_of', $input) && $input['as_of'] !== null) {
            $payload['asOf'] = new \DateTimeImmutable((string) $input['as_of']);
        }

        return $payload;
    }

    /**
     * A bare GET renders an empty form; everything else is a submission.
     */
    public function submitted(): bool
    {
        return $this->isMethod('post') || $this->expectsJson() || $this->query->count() > 0;
    }
}

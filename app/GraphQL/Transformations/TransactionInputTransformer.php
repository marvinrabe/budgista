<?php

namespace App\GraphQL\Transformations;

use App\RRule;
use Illuminate\Contracts\Support\Arrayable;

class TransactionInputTransformer implements Arrayable
{

    protected $input;

    protected function __construct($input)
    {
        $this->input = $input;
    }

    public static function transform($input)
    {
        return new static($input);
    }

    public function toArray()
    {
        return [
            'date' => $this->input['date'],
            'amount' => $this->isExpense() ? (-1 * $this->input['amount']) : $this->input['amount'],
            'payee' => $this->isExpense() ? $this->input['to']['payeeName'] : $this->input['from']['payeeName'],
            'account_id' => $this->isExpense() ? $this->input['from']['accountId'] : $this->input['to']['accountId'],
            'category_id' => $this->getCategory(),
            'rrule' => $this->getRRule()
        ];
    }

    protected function isExpense()
    {
        return isset($this->input['from']['accountId']) && isset($this->input['to']['payeeName']);
    }

    protected function getCategory()
    {
        return isset($this->input['categories'][0]) ? $this->input['categories'][0]['id'] : null;
    }

    protected function getRRule()
    {
        if (!isset($this->input['recurrence'])) {
            return null;
        }
        return new RRule("FREQ={$this->input['recurrence']['frequency']};INTERVAL={$this->input['recurrence']['interval']}");
    }

}

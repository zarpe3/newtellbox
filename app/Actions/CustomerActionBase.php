<?php

namespace App\Actions\Bases;

use App\Models\Customer;
use Exception;

/**
 * Class CustomerActionBase
 * @package App\Actions\Bases
 * @SuppressWarnings("NumberOfChildren")
 */
abstract class CustomerActionBase extends ActionBase
{
    /** @var Customer */
    protected $customer;


    /**
     * @param Customer $customer
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function execute(Customer $customer, array $data = [])
    {
        // Set global customer
        $this->customer = $customer;

        return $this->init($data);
    }
}
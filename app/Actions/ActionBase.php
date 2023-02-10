<?php

namespace App\Actions;

/**
 * Trait ModelActionBase.
 */
trait ActionBase
{
    /** @var array */
    protected $data = [];
    protected $enviroment;

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function execute(array $data = [])
    {
        // Set global model
        $this->enviroment = 'test';
        if (env('APP_ENV') == 'production') {
            $this->enviroment = 'prod';
        }

        return $this->init($data);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    protected function init(array $data = [])
    {
        try {
            // Set parameters
            if (!empty($data) || isset($this->setParameters)) {
                $this->setParameters($data);
            }

            // Execute main functions
            return $this->main();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set the parameters used throughout the class from the data passed to it
     * Override this to change how the parameters are set and add validation.
     */
    abstract protected function setParameters(array $data): void;

    /**
     * Main function - add the main logic for the class here.
     */
    abstract protected function main();
}

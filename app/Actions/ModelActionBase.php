<?php

namespace App\Actions;

/**
 * Trait ModelActionBase.
 */
trait ModelActionBase
{
    protected $actionRecord;

    /** @var array */
    protected $data = [];

    /**
     * @param \Eloquent|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder $actionRecord
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function execute($actionRecord, array $data = [])
    {
        // Set global model
        $this->actionRecord = $actionRecord;

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
            $this->setParameters($data);
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

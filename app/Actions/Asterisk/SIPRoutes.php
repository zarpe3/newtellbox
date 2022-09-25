<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use App\Models\SipRoutes as SipRouting;

class SIPRoutes
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        if ($this->data['request'] == 'GET') {
            return SipRouting::accountcode($this->actionRecord->accountcode)
                ->distinct()
                ->get(['name', 'accountCode'])
                ->toArray();
        }

        if ($this->data['request'] == 'GET_ROUTE_NAME') {
            return SipRouting::accountcode($this->actionRecord->accountcode)
                ->name($this->data['name'])
                ->get();
        }

        if ($this->data['request'] == 'DELETE') {
            return SipRouting::accountcode($this->actionRecord->accountcode)
                ->name($this->data['name'])
                ->delete();
        }

        if ($this->data['request'] == 'UPDATE') {
            SipRouting::accountcode($this->actionRecord->accountcode)
                ->name($this->data['name'])
                ->delete();

            $infos = json_decode(base64_decode($this->data['infos']));
            foreach ($infos as $route) {
                $sipRoute = new SipRouting();
                $sipRoute->name = $this->data['name'];
                $sipRoute->accountcode = $this->actionRecord->accountcode;
                $sipRoute->ddd = $route->DDD;
                $sipRoute->type = $route->type;
                $sipRoute->trunk = $route->trunk;
                $sipRoute->save();
            }
        }

        if ($this->data['request'] == 'ADD') {
            $infos = json_decode(base64_decode($this->data['infos']));
            foreach ($infos as $route) {
                $sipRoute = new SipRouting();
                $sipRoute->name = $this->data['name'];
                $sipRoute->accountcode = $this->actionRecord->accountcode;
                $sipRoute->ddd = $route->DDD;
                $sipRoute->type = $route->type;
                $sipRoute->trunk = $route->trunk;
                $sipRoute->save();
            }
        }

        if ($this->data['request'] == 'EXISTS') {
            return SipRouting::accountcode($this->actionRecord->accountcode)->exists();
        }
    }
}

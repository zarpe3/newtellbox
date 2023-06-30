<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Models\CDR;
use Carbon\Carbon;
use Storage;

class GetCDR
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $response = CDR::accountCode($this->actionRecord->accountcode)
            ->where('start_date', '>', $this->data['start_date'].' '.$this->data['start_time'])
            ->where('end_date', '<', $this->data['end_date'].' '.$this->data['end_time']);

        $response = $this->filterStatus($response);

        return $response->get()
            ->transform(function ($cdr) {
                $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $cdr['start_date']);
                $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $cdr['end_date']);

                $data = null;

                if (Storage::exists($cdr['accountCode'].'/'.$cdr['uniqueid'].'.wav')) {
                    $data = 'data:audio/wav;base64,'
                        .base64_encode(Storage::get($cdr['accountCode'].'/'.$cdr['uniqueid'].'.wav'));
                }

                return [
                    'src' => $cdr['src'],
                    'dst' => $cdr['dst'],
                    'start_date' => $startDate->format('d/m/Y H:i:s'),
                    'end_date' => $endDate->format('d/m/Y H:i:s'),
                    'status' => $this->changeStatus($cdr['status']),
                    'billsec' => $cdr['billsec'],
                    'uniqueid' => str_replace('.', '_', $cdr['uniqueid']),
                    'rating' => number_format(floatval($cdr['rating']), 2, '.', ''),
                    'audio' => $data ?? '',
                ];
            });
    }

    protected function filterStatus($response)
    {
        if ($this->data['status'] != '0') {
            $status = $this->data['status'];
            $response->where(function ($query) use ($status) {
                $query->where('status', $status);

                if ($status == 'NOANSWER') {
                    $query->orWhere('status', 'CANCEL');
                }

                return $query;
            });
        }

        return $response;
    }

    protected function changeStatus($status)
    {
        switch ($status) {
            case 'ANSWER':
                return 'Atendida';
                break;
            case 'BUSY':
                return 'Ocupado';
                break;
            case 'NOANSWER':
                return 'Não Atendida';
                break;
            case 'CANCEL':
                return 'Não Atendida';
                break;
            case 'CONGESTION':
                return 'Falha';
                break;
            case 'CHANUNAVAIL':
                return 'Tronco Indisponivel';
                break;
            case 'DROP':
                return 'Abandonada';
                break;
        }
    }
}

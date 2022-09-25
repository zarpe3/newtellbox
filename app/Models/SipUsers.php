<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SipUsers extends Model {

    protected $table = 'sip';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'ipaddr',
        'port',
        'regseconds',
        'defaultuser',
        'fullcontact',
        'regserver',
        'useragent',
        'lastms',
        'host',
        'type',
        'context',
        'permit',
        'deny',
        'secret',
        'md5secret',
        'transport',
        'dtmfmode',
        'directmedia',
        'nat',
        'callgroup',
        'pickupgroup',
        'language',
        'allow',
        'disallow',
        'insecure',
        'trustrpid',
        'progressinband',
        'accountcode',
        'setvar',
        'callerid',
        'callcounter',
        'busylevel',
        'allowoverlap',
        'allowsubscribe',
        'videosupport',
        'regexten',
        'fromdomain',
        'fromuser',
        'qualify',
        'defaultip',
        'auth',
        'parkinglot',
        'call-limit',
        'dtlsenable',
        'dtlsverify',
        'dtlsprivatekey',
        'dtlscertfile',
        'dtlssetup',
        'rtcp_mux',
        'icesupport',
        'avpf',
        'context_to'
    ];

    protected static function booted()
    {
        static::created(function ($sip) {
            $client = new \GuzzleHttp\Client();
            $client->request('GET', 'http://webdec-dev03.webdec.com.br/hints', ['query' => []]);
        });

        static::deleted(function ($sip) {
            $client = new \GuzzleHttp\Client();
            $client->request('GET', 'http://webdec-dev03.webdec.com.br/hints', ['query' => []]);
        });
    }

    public function scopeAccountcode($query, $accountCode) {
        return $query->where('accountcode', $accountCode);
    }

}

<?php
namespace Src\domain\File\Models;

use \Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'file_name',
        'rpt_dt',
        'tckr_symb',
        'mkt_nm',
        'scty_ctgy_nm',
        'isin',
        'crpn_nm'
    ];
}

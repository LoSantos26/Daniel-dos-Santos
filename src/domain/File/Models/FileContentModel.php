<?php
namespace Src\domain\File\Models;

use \Illuminate\Database\Eloquent\Model;

class FileContentModel extends Model
{
    protected $table = 'files_content';

    protected $fillable = [
        'file_id',
        'rpt_dt',
        'tckr_symb',
        'mkt_nm',
        'scty_ctgy_nm',
        'isin',
        'crpn_nm'
    ];

    public function file()
    {
        return $this->belongsTo(FilesModel::class, 'file_id', 'id');

    }
}

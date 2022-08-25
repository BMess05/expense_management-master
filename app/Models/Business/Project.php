<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name',
        'project_name',
        'contract_type',
        'project_type',
        'start_date',
        'end_date',
        'job_posting_url',
        'total_price',
        'payment_received',
        'user_id',
    ];

    protected $appends = ['contract_type','project_type'];

    public function getContractTypeAttribute() {
        return ContractType::select(['id', 'type'])->find($this->attributes['contract_type']);
    }

    public function getProjectTypeAttribute() {
        return ProjectType::select(['id', 'type'])->find($this->attributes['project_type']);
    }

    public function bidprofile() {
        return $this->belongsTo('App\Models\Business\BidProfile', 'bid_id', 'id');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getStartDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

     public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getEndDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

}

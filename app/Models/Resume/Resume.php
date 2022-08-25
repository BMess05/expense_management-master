<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'experience',
        'category',
        'resume',
        'interview_date',
        'reason_for_rejection',
        
    ];

    protected $appends = ['experience'];

    public function setInterviewDateAttribute($value)
    {
        $this->attributes['interview_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getInterviewDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getExperienceAttribute() {
        return Experience::select(['id', 'experience'])->find($this->attributes['experience']);
    }

    public function categories() {
        return $this->hasMany('App\Models\Resume\ResumeCategory', 'id', 'category');
    }
}

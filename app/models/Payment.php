<?php

class Payment extends BaseModel {

    protected $guarded = ['id'];

    protected $table="payments";

    public function refunds()
    {
        return $this->hasOne('Refund');
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function photos()
    {
        return $this->morphMany('Payment', 'payable');
    }

}
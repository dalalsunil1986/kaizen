<?php

class Refund extends BaseModel {

    protected $guarded = ['id'];

    protected $table = "refunds";

    public function payments()
    {
        return $this->belongsTo('Payment');
    }

}
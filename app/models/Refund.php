<?php

class Refund extends BaseModel {

    protected $guarded = ['id'];

    protected $table = "refunds";

    public function payment()
    {
        return $this->belongsTo('Payment');
    }

    public function user(){
        return $this->belongsTo('User');
    }

}
<div id="side-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ Lang::get('site.general.newsletter') }}
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <span class="mute">{{ Lang::get('site.general.newsletter_subscribe') }}</span>
                    {{ Form::open(array('action'=>'NewslettersController@subscribe')) }}
                    <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-envelope"></i>
                            </span>
                        {{Form::input('email','email',NULL,array('class'=>'form-control','placeholder'=>'Email','required'=>'"required"'))}}
                            <span class="input-group-btn">
                                <button id="submit" class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-arrow-left glyphicon-fw"></i> </button>
                            </span>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
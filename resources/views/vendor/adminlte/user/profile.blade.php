@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Member Profile
@endsection

@section('contentheader_title')
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Homepage</a></li>
    <li><a href="{{  url('/admincp/user/member') }}">List Member</a></li>
    <li class="active">Profile</li>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
                <?php //var_dump(session()->all()); ?>
                <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
                </h4> @endif @endforeach
        </div>

        <div class="row">
            <div class="col-sm-3 text-center"><h3>{{ $profile->name }}</h3></div>
        </div>
        <div class="row">
            <div class="col-sm-3"><!--left col-->


                <div class="text-center">
                    <img src="{{ $avatar }}"
                         class="avatar img-circle img-thumbnail" alt="avatar">
                </div>
                </hr><br>
                <p>Date of Registration: {{ \Carbon\Carbon::parse( $profile->created_at)->format('Y-m-d') }}</p>


            </div><!--/col-3-->
            <div class="col-sm-9">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Information</a></li>
                </ul>


                <div class="tab-content">
                    <div class="tab-pane tab-panel-custom active" id="home">
                        <hr>
                        <form class="form" action="##" method="post" id="registrationForm">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="first_name"><h4>Age</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->age }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="email"><h4>Email</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="phone"><h4>Phone</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="last_name"><h4>City</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->city }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="phone"><h4>Height</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>
                                                    @if($profile->height)
                                                    {{ $profile->height }} kg
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="mobile"><h4>Country</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->country }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="email"><h4>Education</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->education }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pull-left pull-left col-xs-6">
                                        <label for="password"><h4>Occupation</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->occupation }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="password2"><h4>about me</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->sumary }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pull-left col-xs-6">
                                        <label for="password2"><h4>I'm Looking For</h4></label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <span>{{ $profile->information }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <hr>

                    </div><!--/tab-pane-->

                </div><!--/tab-pane-->
            </div><!--/tab-content-->

        </div><!--/col-9-->
    </div>
@endsection

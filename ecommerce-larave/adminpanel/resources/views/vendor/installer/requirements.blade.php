@extends('vendor.installer.layouts.master')

@section('template_title')
    Requirements
@endsection

@section('title')
    <i class="fa fa-list-ul fa-fw" aria-hidden="true"></i>
    Server Requirements
@endsection

@section('container')

    @foreach($requirements['requirements'] as $type => $requirement)
        <ul class="list">
            <li class="list__item list__title">
                <strong>PHP Extensions</strong>                
            </li>

            <li class="list__item {{ $phpSupportInfo['supported'] ? 'success' : 'error' }}">
                <strong>{{ ucfirst($type) }}</strong>
                @if($type == 'php')
                    <strong>
                        <small>
                            (version {{ $phpSupportInfo['minimum'] }} required)
                        </small>
                    </strong>
                    <span class="float-right">
                        <strong>
                            {{ $phpSupportInfo['current'] }}
                        </strong>
                        <i class="fa fa-fw fa-{{ $phpSupportInfo['supported'] ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                    </span>
                @endif
            </li>
            @foreach($requirements['requirements'][$type] as $extention => $enabled)
                @if($extention == 'max_execution_time')
                <li class="list__item list__title">
                    <strong>PHP Settings</strong>                
                </li>
                @endif
                <li class="list__item {{ $enabled ? 'success' : 'error' }}">
                    @if($extention == 'gd')
                        GD Library
                    @else    
                        {{ str_replace('_', ' ', $extention) }}
                    @endif
                    
                    @if($extention == 'max_execution_time')
                    <br>
                    <small>Please Make sure your max execution time is greater than {{$requirements['extensions_limit_array']['max_execution_time']}}</small>
                    @endif
                    @if($extention == 'upload_max_filesize')
                    <br>
                    <small>Please Make sure your mupload max filesize is greater than {{$requirements['extensions_limit_array']['upload_max_filesize']}}MB</small>
                    @endif
                    @if($extention == 'post_max_size')
                    <br>
                    <small>Please Make sure your post max size is greater than {{$requirements['extensions_limit_array']['post_max_size']}}MB</small>
                    @endif
                    <i class="fa fa-fw fa-{{ $enabled ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                </li>
            @endforeach
        </ul>
    @endforeach

    @if ( !$requirements['errors'] && $phpSupportInfo['supported'] )
        <div class="buttons">
            <a class="button" href="{{ route('LaravelInstaller::permissions') }}">
                Next
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection

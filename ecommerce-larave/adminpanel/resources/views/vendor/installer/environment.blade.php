@extends('vendor.installer.layouts.master')

@section('template_title')
    Step 3 | Environment Settings
@endsection

@section('title')
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
  Environment Settings
@endsection

@section('container')

    <p class="text-center">
      Please select how you want to configure the apps <code>.env</code> file.
    </p>
    <div class="buttons">
      <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="button button-classic">
          <i class="fa fa-code fa-fw" aria-hidden="true"></i> Wizard Text Editor
      </a>
        <!-- <a href="{{ route('LaravelInstaller::environmentClassic') }}" class="button button-classic">
            <i class="fa fa-code fa-fw" aria-hidden="true"></i> Classic Text Editor
        </a> -->
    </div>

@endsection

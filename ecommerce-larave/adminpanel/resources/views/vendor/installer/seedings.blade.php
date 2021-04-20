@extends('vendor.installer.layouts.master')

@section('template_title')
    Enviroment Configured Successfully
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
	Enviroment Configured Successfully
@endsection

@section('container')

	@if(session('message')['dbOutputLog'])
		<p><strong><small>Migration &amp; Seed Console Output:</small></strong></p>
		<pre><code>{{ session('message')['dbOutputLog'] }}</code></pre>
	@endif

	<p><strong><small>Application Console Output:</small></strong></p>
	<pre><code>{{ $finalMessages }}</code></pre>

	{{-- <p><strong><small>Installation Log Entry:</small></strong></p>
	<pre><code>{{ $finalStatusMessage }}</code></pre> --}}

	<p><strong><small>Final .env File:</small></strong></p>
	<pre><code>{{ $finalEnvFile }}</code></pre>

    <div class="buttons">
		<a href="{{ route('LaravelInstaller::environmentSaveWizardSeedings') }}" class="button">Run Migrations & Seedings </a>
		
    </div>

@endsection

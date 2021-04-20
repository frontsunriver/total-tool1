@extends('vendor.installer.layouts.master')

@section('template_title')
    Complete the Wizard
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    Complete the Wizard
@endsection

@section('container')
    <div class="tabs tabs-full">

        <input id="tab1" type="radio" name="tabs" class="tab-input" checked />
        <label for="tab1" class="tab-label">
            <i class="fa fa-cog fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            Settings
        </label>

        <input id="tab2" type="radio" name="tabs" class="tab-input" />
        <label for="tab2" class="tab-label">
            <i class="fa fa-database fa-2x fa-fw" aria-hidden="true"></i>
            <br />
          Database
        </label>

        <input id="tab3" type="radio" name="tabs" class="tab-input" />
        <label for="tab3" class="tab-label">
            <i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            Application
        </label>

        <input id="tab4" type="radio" name="tabs" class="tab-input" />
        <label for="tab4" class="tab-label">
            <i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            Admin Settings
        </label>

        <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap">
            <div class="tab" id="tab1content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                    <label for="app_name">
                        Website Name
                    </label>
                    <input type="text" name="app_name" id="app_name" value="{{ old('app_name') }}" placeholder="Website Name" />
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('environment') ? ' has-error ' : '' }}">
                    <label for="environment">
                        Choose Development Mode
                    </label>
                    <select name="environment" id="environment" onchange='checkEnvironment(this.value);'>
                        <option value="local" selected>local</option>
                    </select>
                    <div id="environment_text_input" style="display: none;">
                        <input type="text" name="environment_custom" id="environment_custom" placeholder="App Debug"/>
                    </div>
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_debug') ? ' has-error ' : '' }}">
                    <label for="app_debug">
                      App Debug
                    </label>
                    <label for="app_debug_true">
                        <input type="radio" name="app_debug" id="app_debug_true" value=true checked />
                        True
                    </label>
                    <label for="app_debug_false">
                        <input type="radio" name="app_debug" id="app_debug_false" value=false />
                        False
                    </label>
                    @if ($errors->has('app_debug'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_debug') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_log_level') ? ' has-error ' : '' }}">
                    <label for="app_log_level">
                      Log Type
                    </label>
                    <select name="app_log_level" id="app_log_level">
                        <option value="debug" selected>Debug</option>
                        <option value="info">Info</option>
                        <option value="notice">Notice</option>
                        <option value="warning">Warning</option>
                        <option value="error">Error</option>
                        <option value="critical">Critical</option>
                        <option value="alert">Alert</option>
                        <option value="emergency">Emergency</option>
                    </select>
                    @if ($errors->has('app_log_level'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_log_level') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                    <label for="app_url">
                        Website URL
                    </label>
                    <input type="url" name="app_url" id="app_url" value="{{ old('app_url') }}" placeholder="Website URL" />
                    @if ($errors->has('app_url'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_url') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" onclick="showDatabaseSettings();return false">
                      Databse
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="tab" id="tab2content">

                <div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
                    <label for="database_connection">
                      DataBase Connection Type
                    </label>
                    <select name="database_connection" id="database_connection">
                        <option value="mysql" selected>Mysql</option>
                        <!-- <option value="sqlite">Sqlite</option>
                        <option value="pgsql">Pgsql</option>
                        <option value="sqlsrv">sqlsrv</option> -->
                    </select>
                    @if ($errors->has('database_connection'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_connection') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                    <label for="database_hostname">
                        HostName
                    </label>
                    <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="HostName" />
                    @if ($errors->has('database_hostname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                    <label for="database_port">
                        DataBase port
                    </label>
                    <input type="number" name="database_port" id="database_port" value="3306" placeholder="DataBase Port" />
                    @if ($errors->has('database_port'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_port') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label for="database_name">
                        Database Name
                    </label>
                    <input type="text" name="database_name" id="database_name" value="{{ old('database_name') }}" placeholder="Database Name" />
                    @if ($errors->has('database_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
                    @endif
                </div>
                <!-- <div class="form-group {{ $errors->has('table_prefix') ? ' has-error ' : '' }}">
                    <label for="table_prefix">
                        Table Prefix
                    </label>
                    <input type="text" name="table_prefix" id="table_prefix" value="{{ old('table_prefix') }}" placeholder="Table Prefix" />
                    @if ($errors->has('table_prefix'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('table_prefix') }}
                        </span>
                    @endif
                </div> -->
                <input type="hidden" class="hidden" name="table_prefix" id="table_prefix" value="" placeholder="Table Prefix" />

                <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                    <label for="database_username">
                        User Name
                    </label>
                    <input type="text" name="database_username" id="database_username" value="{{ old('database_username') }}" placeholder="User Name" />
                    @if ($errors->has('database_username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                    <label for="database_password">
                        Database Password
                    </label>
                    <input type="text" name="database_password" id="database_password" value="{{ old('database_password') }}" placeholder="Database Passwords" />
                    @if ($errors->has('database_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" onclick="showApplicationSettings();return false">
                        Application
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <input  type="hidden" name="redis_hostname" id="redis_hostname" value="127.0.0.1" placeholder="Redis Host" />
            <input  type="hidden" name="redis_password" id="redis_password" value="null" placeholder="Redis Password" />
            <input  type="hidden" name="redis_port" id="redis_port" value="6379" placeholder="Redis Port" />
            <input type="hidden" name="redis_hostname" id="redis_hostname" value="127.0.0.1" placeholder="Redis Host" />
            <input type="hidden" name="redis_password" id="redis_password" value="null" placeholder="Redis Password" />
            <input type="hidden" name="redis_port" id="redis_port" value="6379" placeholder="Redis Port" />
            <input type="hidden" name="pusher_app_id" id="pusher_app_id" value="" placeholder="Broadcast Driver" />
            <input type="hidden" name="pusher_app_key" id="pusher_app_key" value="" placeholder="Pusher App Key" />
            <input type="hidden" name="pusher_app_secret" id="pusher_app_secret" value="" placeholder="Pusher App Secret" />
            <input type="hidden" name="broadcast_driver" id="broadcast_driver" value="log" placeholder="Broadcast Driver" />
            <input type="hidden" name="cache_driver" id="cache_driver" value="file" placeholder="Cache Driver" />
            <input type="hidden" name="session_driver" id="session_driver" value="file" placeholder="Cache Driver" />
            <input type="hidden" name="queue_driver" id="queue_driver" value="sync" placeholder="Queue Driver" />

            <div class="tab" id="tab3content">
                <!-- <div class="block">
                    <input type="radio" name="appSettingsTabs" id="appSettingsTab1" value="null" checked />
                    <label for="appSettingsTab1">
                        <span>
                            Broadcasting, Caching, Session, &amp; Queue
                        </span>
                    </label>

                </div> -->
                <!-- <div class="block">
                    <input type="radio" name="appSettingsTabs" id="appSettingsTab2" value="null"/>
                    <label for="appSettingsTab2">
                        <span>
                            Redis Driver
                        </span>
                    </label>
                    <div class="info">
                        <div class="form-group {{ $errors->has('redis_hostname') ? ' has-error ' : '' }}">
                            <label for="redis_hostname">
                                Redis Host
                                <sup>
                                    <a href="https://laravel.com/docs/5.4/redis" target="_blank" title="More Info">
                                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">More Info</span>
                                    </a>
                                </sup>
                            </label>
                            <input type="text" name="redis_hostname" id="redis_hostname" value="127.0.0.1" placeholder="Redis Host" />
                            @if ($errors->has('redis_hostname'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('redis_hostname') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('redis_password') ? ' has-error ' : '' }}">
                            <label for="redis_password">Redis Password</label>
                            <input type="password" name="redis_password" id="redis_password" value="null" placeholder="Redis Password" />
                            @if ($errors->has('redis_password'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('redis_password') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('redis_port') ? ' has-error ' : '' }}">
                            <label for="redis_port">Redis Port</label>
                            <input type="number" name="redis_port" id="redis_port" value="6379" placeholder="Redis Port" />
                            @if ($errors->has('redis_port'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('redis_port') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div> -->

                        <div class="form-group {{ $errors->has('mail_driver') ? ' has-error ' : '' }}">
                            <label for="mail_driver">
                                Mail Driver
                                <sup>
                                    <a href="https://laravel.com/docs/5.4/mail" target="_blank" title="More Info">
                                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">More Info</span>
                                    </a>
                                </sup>
                            </label>
                            <input type="text" name="mail_driver" id="mail_driver" value="{{ old('mail_driver') }}" placeholder="Mail Driver e:g. sendmail" />
                            @if ($errors->has('mail_driver'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_driver') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('mail_host') ? ' has-error ' : '' }}">
                            <label for="mail_host">Mail Host</label>
                            <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host') }}" placeholder="Mail Host e:g. smtp.gmail.com" />
                            @if ($errors->has('mail_host'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_host') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('mail_port') ? ' has-error ' : '' }}">
                            <label for="mail_port">Mail Port</label>
                            <input type="number" name="mail_port" id="mail_port" value="{{ old('mail_port') }}" placeholder="Mail Port e:g. 587" />
                            @if ($errors->has('mail_port'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_port') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('mail_username') ? ' has-error ' : '' }}">
                            <label for="mail_username">Mail Username</label>
                            <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username') }}" placeholder="Mail Username / Email Address" />
                            @if ($errors->has('mail_username'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_username') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('mail_password') ? ' has-error ' : '' }}">
                            <label for="mail_password">Mail Password</label>
                            <input type="text" name="mail_password" id="mail_password" value="{{ old('mail_password') }}" placeholder="Mail Password" />
                            @if ($errors->has('mail_password'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_password') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('mail_encryption') ? ' has-error ' : '' }}">
                            <label for="mail_encryption">Mail Encryption</label>
                            <input type="text" name="mail_encryption" id="mail_encryption" value="{{ old('mail_encryption') }}" placeholder="Mail Encryption e:g. tls " />
                            @if ($errors->has('mail_encryption'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('mail_encryption') }}
                                </span>
                            @endif
                        </div>

                <!-- <div class="block margin-bottom-2">
                    <input type="radio" name="appSettingsTabs" id="appSettingsTab4" value="null"/>
                    <label for="appSettingsTab4">
                        <span>
                            Pusher
                        </span>
                    </label>
                    <div class="info">
                        <div class="form-group {{ $errors->has('pusher_app_id') ? ' has-error ' : '' }}">
                            <label for="pusher_app_id">
                                Pusher App Id
                                <sup>
                                    <a href="https://pusher.com/docs/server_api_guide" target="_blank" title="More Info">
                                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">More Info</span>
                                    </a>
                                </sup>
                            </label>
                            <input type="text" name="pusher_app_id" id="pusher_app_id" value="" placeholder="Broadcast Driver" />
                            @if ($errors->has('pusher_app_id'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('pusher_app_id') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('pusher_app_key') ? ' has-error ' : '' }}">
                            <label for="pusher_app_key">Pusher App Key</label>
                            <input type="text" name="pusher_app_key" id="pusher_app_key" value="" placeholder="Pusher App Key" />
                            @if ($errors->has('pusher_app_key'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('pusher_app_key') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('pusher_app_secret') ? ' has-error ' : '' }}">
                            <label for="pusher_app_secret">Pusher App Key</label>
                            <input type="password" name="pusher_app_secret" id="pusher_app_secret" value="" placeholder="Pusher App Secret" />
                            @if ($errors->has('pusher_app_secret'))
                                <span class="error-block">
                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $errors->first('pusher_app_secret') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div> -->
                <div class="buttons">
                    <button class="button" onclick="showAdminSettings();return false">
                        Admin Settings
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
            <div class="tab" id="tab4content">
                <div class="form-group {{ $errors->has('purchase_code') ? ' has-error ' : '' }}">
                    <label for="purchase_code">
                      Purchase Code
                    </label>
                    <input type="text" required name="purchase_code" id="purchase_code" value="{{ old('purchase_code') }}" placeholder="Purchase Code" />
                    @if ($errors->has('purchase_code'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('purchase_code') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('user_name') ? ' has-error ' : '' }}">
                    <label for="user_name">
                        User Name
                    </label>
                    <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}" placeholder="User Name" />
                    @if ($errors->has('user_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('user_name') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('first_name') ? ' has-error ' : '' }}">
                    <label for="first_name">
                        First Name
                    </label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="First Name" />
                    @if ($errors->has('first_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('first_name') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                    <label for="last_name">
                        Last Name
                    </label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Last Name" />
                    @if ($errors->has('last_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('last_name') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
                    <label for="email">
                        Email
                    </label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Email" />
                    @if ($errors->has('email'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error ' : '' }}">
                    <label for="password">
                        Password
                    </label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}" placeholder="Password" />
                    @if ($errors->has('password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password_confirm') ? ' has-error ' : '' }}">
                    <label for="password_confirm">
                        Password
                    </label>
                    <input type="text" name="password_confirmation" id="password_confirm" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" />
                    @if ($errors->has('password_confirm'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('password_confirm') }}
                        </span>
                    @endif
                </div>
                <div class="buttons">
                    <button class="button" type="submit">
                        Install
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
        function showAdminSettings() {
            document.getElementById('tab4').checked = true;
        }
    </script>
@endsection

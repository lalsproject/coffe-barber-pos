@extends('layouts.admin.base-dashboard')

@section('title', 'Settings')

@section('content')

    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header">
            <h3>Customize Appearance</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
                @csrf
                @method('PATCH')

                <div class="form-section">
                    <h3>Logo</h3>
                    <div class="form-group">
                        <label for="logo"><strong>Current Logo:</strong></label>
                        <p>{{ $settings->logo ?? 'No logo uploaded' }}</p>
                        <div class="custom-file">
                            <input type="file" name="logo" id="logo" class="custom-file-input">
                            <label class="custom-file-label" for="logo">Choose logo file</label>
                        </div>
                        <small>Upload a new logo if needed</small>
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Button Color</h3>
                    <div class="form-group">
                        <label for="button_color">Select Button Color</label>
                        <input type="color" name="button_color" id="button_color" class="form-control"
                            value="{{ $settings->button_color ?? '#007bff' }}">
                        <input type="text" name="button_color_code" id="button_color_code" class="form-control mt-2"
                            value="{{ $settings->button_color ?? '#007bff' }}" placeholder="Button Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Background Color</h3>
                    <div class="form-group">
                        <label for="background_color">Select Background Color</label>
                        <input type="color" name="background_color" id="background_color" class="form-control"
                            value="{{ $settings->background_color ?? '#ffffff' }}">
                        <input type="text" name="background_color_code" id="background_color_code"
                            class="form-control mt-2" value="{{ $settings->background_color ?? '#ffffff' }}"
                            placeholder="Background Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Input Field Background Color</h3>
                    <div class="form-group">
                        <label for="input_color">Select Input Field Color</label>
                        <input type="color" name="input_color" id="input_color" class="form-control"
                            value="{{ $settings->input_color ?? '#5A080C' }}">
                        <input type="text" name="input_color_code" id="input_color_code" class="form-control mt-2"
                            value="{{ $settings->input_color ?? '#5A080C' }}"
                            placeholder="Input Field Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Text Color</h3>
                    <div class="form-group">
                        <label for="text_color">Select Text Color</label>
                        <input type="color" name="text_color" id="text_color" class="form-control"
                            value="{{ $settings->text_color ?? '#5A080C' }}">
                        <input type="text" name="text_color_code" id="text_color_code" class="form-control mt-2"
                            value="{{ $settings->text_color ?? '#5A080C' }}" placeholder="Text Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Icon Color</h3>
                    <div class="form-group">
                        <label for="icon_color">Select Icon Color</label>
                        <input type="color" name="icon_color" id="icon_color" class="form-control"
                            value="{{ $settings->icon_color ?? '#5A080C' }}">
                        <input type="text" name="icon_color_code" id="icon_color_code" class="form-control mt-2"
                            value="{{ $settings->icon_color ?? '#5A080C' }}" placeholder="Icon Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Navbar Background Color</h3>
                    <div class="form-group">
                        <label for="navbar_background">Select Navbar Background Color</label>
                        <input type="color" name="navbar_background" id="navbar_background" class="form-control"
                            value="{{ $settings->navbar_background ?? '#F2F2F2' }}">
                        <input type="text" name="navbar_background_code" id="navbar_background_code"
                            class="form-control mt-2" value="{{ $settings->navbar_background ?? '#F2F2F2' }}"
                            placeholder="Navbar Background Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <div class="form-section">
                    <h3>Sidebar Background Color</h3>
                    <div class="form-group">
                        <label for="sidebar_background">Select Sidebar Background Color</label>
                        <input type="color" name="sidebar_background" id="sidebar_background" class="form-control"
                            value="{{ $settings->sidebar_background ?? '#F2F2F2' }}">
                        <input type="text" name="sidebar_background_code" id="sidebar_background_code"
                            class="form-control mt-2" value="{{ $settings->sidebar_background ?? '#F2F2F2' }}"
                            placeholder="Sidebar Background Color (HEX, RGB, HSL)">
                    </div>
                </div>
                <hr>

                <button type="submit" class="btn btn-primary">Save Settings</button>
                <button type="button" id="reset_to_default" class="btn btn-secondary">Reset to Default</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const defaultValues = {
                button_color: '#007bff',
                background_color: '#ffffff',
                input_color: '#5A080C',
                text_color: '#5A080C',
                icon_color: '#5A080C',
                navbar_background: '#F2F2F2',
                sidebar_background: '#F2F2F2'
            };

            function resetToDefault() {
                document.getElementById('button_color').value = defaultValues.button_color;
                document.getElementById('button_color_code').value = defaultValues.button_color;

                document.getElementById('background_color').value = defaultValues.background_color;
                document.getElementById('background_color_code').value = defaultValues.background_color;

                document.getElementById('input_color').value = defaultValues.input_color;
                document.getElementById('input_color_code').value = defaultValues.input_color;

                document.getElementById('text_color').value = defaultValues.text_color;
                document.getElementById('text_color_code').value = defaultValues.text_color;

                document.getElementById('icon_color').value = defaultValues.icon_color;
                document.getElementById('icon_color_code').value = defaultValues.icon_color;

                document.getElementById('navbar_background').value = defaultValues.navbar_background;
                document.getElementById('navbar_background_code').value = defaultValues.navbar_background;

                document.getElementById('sidebar_background').value = defaultValues.sidebar_background;
                document.getElementById('sidebar_background_code').value = defaultValues.sidebar_background;
            }

            document.getElementById('reset_to_default').addEventListener('click', resetToDefault);
        });
    </script>
@endsection

@extends('layouts.admin.base-dashboard')

@section('title', 'Create Product')

@section('content')
<div class="card">
    <form action="{{ route('products.store') }}" method="POST"
        class="form-horizontal needs-validation" enctype="multipart/form-data">
        @csrf
        <h5 class="card-header">Create Product</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Code</label>
                    <div class="col-md-5">
                        <input type="text" name="name" id="productName"
                            class="form-control @error('name') has-error @enderror" autocomplete="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('image') has-error @enderror">
                    <label for="image" class="control-label text-right col-md-3">Image</label>
                    <div class="col-md-5">
                        <input type="file" name="image" id="image" class="form-control
                            @error('image') has-error @enderror" value="{{ old('image') }}">

                        @error('image')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('description') has-error @enderror">
                    <label class="control-label text-right col-md-3">Description</label>
                    <div class="col-md-5">
                        <input type="text" name="description" id="productDescription"
                            class="form-control @error('description') has-error @enderror" autocomplete="description"
                            value="{{ old('description') }}">

                        @error('description')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('brand_id') has-error @enderror">
                    <label for="brand_id" class="control-label text-right col-md-3">Brand</label>
                    <div class="col-md-3">
                        <select name="brand_id" id="brand_id"
                            class="form-control @error('brand_id') has-error @enderror">
                            <option value="">-- Choose Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('brand_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('category_id') has-error @enderror">
                    <label for="category_id" class="control-label text-right col-md-3">Kategori</label>
                    <div class="col-md-3">
                        <select name="category_id" id="category_id"
                            class="form-control @error('category_id') has-error @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('unit_id') has-error @enderror">
                    <label for="unit_id" class="control-label text-right col-md-3">Unit</label>
                    <div class="col-md-3">
                        <select name="unit_id" id="unit_id"
                            class="form-control @error('unit_id') has-error @enderror">
                            <option value="">-- Choose Unit --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('unit_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- <div class="form-group row @error('status') has-error @enderror">
                    <label for="status" class="control-label text-right col-md-3">Status</label>
                    <div class="col-md-3">
                        <select name="status" id="status"
                            class="form-control @error('status') has-error @enderror">
                            <option value="">-- Choose Status --</option>
                            <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="indent" {{ old('status') == 'indent' ? 'selected' : '' }}>Indent</option>
                        </select>

                        @error('status')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div> --}}

                {{-- <div class="form-group row @error('period_id') has-error @enderror">
                    <label for="period_id" class="control-label text-right col-md-3">Period</label>
                    <div class="col-md-3">
                        <select name="period_id" id="period_id"
                            class="form-control @error('period_id') has-error @enderror">
                            <option value="">-- Choose Period --</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('period_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div> --}}

                <div class="form-group row @error('stock') has-error @enderror">
                    <label class="control-label text-right col-md-3">Stock</label>
                    <div class="col-md-5">
                        <input type="text" name="stock"
                            class="form-control @error('stock') has-error @enderror" autocomplete="stock"
                            value="{{ old('stock') }}">

                        @error('stock')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('price') has-error @enderror">
                    <label class="control-label text-right col-md-3">Price</label>
                    <div class="col-md-5">
                        <input type="text" name="price"
                            class="form-control @error('price') has-error @enderror" autocomplete="price"
                            value="{{ old('price') }}">

                        @error('price')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="offset-sm-3 col-md-5">
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Create
                                </button>
                                <a href="{{ route('products.list') }}" class="btn btn-info btn-rounded"
                                    style="color: #fff;"> <i class="la la-chevron-left" style="color: #fff; font-size: 1.5em;"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
    <script>
        $(function () {
            $('#productName').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $("#brand_id").select2({
                tags: false
            });

            $("#category_id").select2({
                tags: false
            });

            $('#productDescription').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });
        });
    </script>
@endpush

@extends('layouts.admin.base-dashboard')

@section('title', 'Show Image Product')

@section('content')
@include('layouts.admin.include.message')

<div class="card">
    <div class="card-header">
        <a href="{{ route('products.list') }}" class="btn btn-success btn-sm" style="color: #fff;">
            <i class="la la-chevron-left" style="color: #fff;"></i>
            Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="pop">
                    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid">            
                </a>
            </div>
            <div class="col-md-6">
                <div class="list-group">
                    <table>
                        <tr>
                            <td style="width: 60px;">Name</td>
                            <td style="width: 10px;">:</td>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 60px;">Description</td>
                            <td style="width: 10px;">:</td>
                            <td>{{ $product->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg show" id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle2">{{ $product->title }}</h5>
            </div>
            <div class="modal-body">
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');   
            });		
        });
    </script>
@endpush
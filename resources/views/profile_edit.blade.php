@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="inner-pg-main">

    <section class="sec2">
        <div class="container">
            <div class="rounded-4 overflow-hidden">
                {{-- Body --}}
                <div class="card-body px-4 px-lg-5 py-5">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                     {{-- Header with gradient background --}}
                <div class="bg-gradient text-white text-center py-5" style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                    <div class="position-relative d-inline-block">
                        <img
                            src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                            class="rounded-circle border border-4 border-light mb-3"
                            style="width:130px;height:130px;object-fit:cover;">

                    </div>
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="mb-0 small opacity-75">{{ $user->email }}</p>
                </div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="row g-4">
                        @csrf

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg shadow-sm"
                                   value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg shadow-sm"
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control form-control-lg shadow-sm"
                                   value="{{ old('date_of_birth', $user->date_of_birth) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Upload New Profile Image</label>
                            <input type="file" name="profile_image" class="form-control form-control-lg shadow-sm">
                            <small class="text-muted">JPG/PNG max 2MB</small>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


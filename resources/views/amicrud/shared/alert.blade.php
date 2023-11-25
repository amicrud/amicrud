<div class="row w-100">
  <div class="col-md-12">
  
  @if($errors->any())
  @forelse ($errors->all() as $error)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $error }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
  </div>
  @empty
  @endforelse
  @endif
  
  
  @if(session('success'))
  
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <p><span>Success!</span> {!! session('success') !!}</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
  </div>
  
  @elseif(session('error'))
  
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <p><span>Error!</span> {!! session('error')  !!}</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
  </div>
  
  @elseif(session('warning'))
  
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <p><span>Error!</span> {!! session('warning')  !!}</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
  </div>
  @endif
  </div>
  </div>
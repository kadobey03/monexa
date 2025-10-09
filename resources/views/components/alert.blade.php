<div>
 @if(Auth::user()->signal_status=='on')
  <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-group alert-danger alert-icon  fade show" role="alert">
                    <div class="alert-group-prepend">
                        <span class="alert-group-icon text-">
                            <i class="far fa-thumbs-down"></i>
                        </span>
                    </div>
                    <div class="alert-content">
                        <p>{{ Auth::user()->user_signal }} satın almanız gerekiyor. </p>
                        <p> <a href="{{route('deposits')}}"  class='btn btn-warning'>Şimdi Satın Al</a></p>
                    </div> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                    
            </div>
        </div>
    @endif
</div>

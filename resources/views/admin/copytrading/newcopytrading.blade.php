<?php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = 'light';
} else {
    $text = "light";
	$bg = 'dark';
}
?>
@extends('layouts.app')
    @section('content')
        @include('admin.topmenu')
        @include('admin.sidebar')
		<div class="main-panel">
			<div class="content bg-{{$bg}}">
				<div class="page-inner">
					<div class="mt-2 mb-4">
						<h1 class="title1 text-{{$text}}">{{ __('admin.copy.add_copy_trading_plan') }}</h1>
					</div>
					<x-danger-alert/>
                    <x-success-alert/>
					<div class="mb-5 row">
						<div class="col-lg-10  ">
                            <div class="p-3 card bg-{{$bg}}">
                                <form role="form" method="post" action="{{ route('addcopytrading') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.expert_trader_tag') }}</h5>
                                            <input  class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.enter_expert_trader_tag') }}" type="text" name="tag" required>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.trader_name') }}</h5>
                                            <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.enter_expert_trader_name') }}" type="text" name="name" required>
                                            
                                       </div>	
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.expert_trader_followers') }}</h5>
                                             <input placeholder="{{ __('admin.copy.enter_expert_followers') }}" class="form-control text-{{$text}} bg-{{$bg}}" type="text" name="followers" required>
                                             <small class="text-{{$text}}">{{ __('admin.copy.followers_description') }}</small>
                                       </div>
                                       <div class="form-group col-md-5">
                                             <h5 class="text-{{$text}}">{{ __('admin.copy.enter_expert_total_profit') }} ({{$settings->currency}})</h5>
                                             <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.enter_expert_total_profit') }}" type="text" name="total_profit" required>
                                            <small class="text-{{$text}}">{{ __('admin.copy.total_profit_description') }}</small>
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.copy_trade_type') }}</h5>
                                            <select class="form-control text-{{$text}} bg-{{$bg}}" name="button_name">
                                                <option>{{ __('admin.copy.copy') }}</option>
                                                <option>{{ __('admin.copy.buy') }}</option>
                
                                            </select>  
                                        
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.expert_trader_active_days') }}</h5>
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.enter_active_days') }}" type="text" name="active_days" required>
                                           <small class="text-{{$text}}">{{ __('admin.copy.active_days_description') }}</small>
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-{{$text}}">{{ __('admin.copy.equity_winning_rate') }} %</h5>
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.enter_expert_equity') }}" type="text" name="equity" value="0" required>
                                           <small class="text-{{$text}}">{{ __('admin.copy.equity_description') }}</small>
                                       </div>
                                       
                                      

                                       <div class="form-group col-md-5">
                                           <h5 class="text-{{$text}}">{{ __('admin.copy.startup_amount') }} ({{$settings->currency}})</h5>
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.startup_amount') }}" type="text" name="price" required>
                                           <small class="text-{{$text}}">{{ __('admin.copy.startup_amount_description') }}</small>
                                       </div>
                                      
                                       <div class="form-group col-md-5">
                                        <h5 class="text-{{$text}}">{{ __('admin.copy.expert_trader_rating') }}</h5>
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.expert_trader_rating') }}" type="number" name="rating" required>
                                           <small class="text-{{$text}}">{{ __('admin.copy.rating_max_description') }}</small>
                                           <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                             <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            
                                       </div>



                                       <div class="form-group col-md-5">
                                        <h5 class="text-{{$text}}">{{ __('admin.copy.expert_trader_photo') }}</h5>
                                           <input class="form-control text-{{$text}} bg-{{$bg}}" placeholder="{{ __('admin.copy.expert_trader_photo') }}" type="file"  name="photo" required>
                                           <small class="text-{{$text}}">{{ __('admin.copy.photo_description') }}</small>
                                        
                                       </div>
                                       <div class="form-group col-md-12">
                                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                           <input type="submit" class="btn btn-secondary" value="{{ __('admin.copy.add_new_copy_trading_plan') }}">
                                       </div>
                                    </div>
                               </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
            
            <div id="durationModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-{{$bg}}">
                            <h5 class="text-{{$text}}">{{ __('admin.copy.duration_modal_text') }}</h5>
                            <h2 class="text-{{$text}}">{{ __('admin.copy.duration_examples') }}</h2>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="topupModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-{{$bg}}">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function getduration(id, event){
                    event.preventDefault();
                    document.getElementById('duridden').value = id;
                }
            </script>
            <style>
                .checked {
  color: orange;
}
                </style>

	@endsection
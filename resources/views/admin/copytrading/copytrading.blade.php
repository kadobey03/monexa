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
			<div class="content bg-{{Auth('admin')->User()->dashboard_style}}">
				<div class="page-inner">
					<div class="mt-2 mb-4">
						<h1 class="title1 text-{{$text}}">{{ __('admin.copy.system_copy_trading_plans') }}</h1>
					</div>
					<x-danger-alert/>
					<x-success-alert/>
					<div class="mb-5 row">
						<div class="mt-2 mb-3 col-lg-12">
							<a class="btn btn-primary" href="{{route('newcopytrading')}}"><i class="fa fa-plus"></i> {{ __('admin.copy.new_copy_trading_plans') }}</a>
						</div>
						@forelse ( $copytradings as  $copytrading)
						<div class="col-lg-3">
							
							<div class="pricing-table purple border p-4 card bg-{{$bg}} shadow">
								<div>
									
								<span class='badge badge-warning'>{{ $copytrading->tag }}</span>
								</div>
								<div class="text-center">
									<img src="{{ asset('storage/'.$copytrading->photo) }}"  width="85" height="75" class="rounded-circle rounded" alt="{{ $copytrading->name }}">
									<h3 class="text-{{$text}} text-center text-primary"><span class="px-4 mx-auto bg-white shadow-sm  rounded-bottom">{{ $copytrading->name}}</span></h3>
									{{-- <h2 class="text-{{$text}} text-center text-primary">{{ $copytrading->name}}</h2> --}}
								</div>
								
								
								<!-- Price -->
								
								<!-- Features -->
								<div class="pricing-features">
									<div class="feature text-{{$text}}">
										{{ __('admin.copy.copy_trading_price') }}:<span class="text-{{$text}}">{{$settings->currency}}{{number_format( $copytrading->price)}}</span>
									</div>

									<div class="feature text-{{$text}}">
										{{ __('admin.copy.expert_total_followers') }}:<span class="text-{{$text}}">{{number_format( $copytrading->followers)}}</span>
									</div>
									<div class="feature text-{{$text}}">
										{{ __('admin.copy.expert_total_profit') }}:<span class="text-{{$text}}">{{$settings->currency}}{{number_format( $copytrading->total_profit)}}</span>
									</div>
									<div class="feature text-{{$text}}">
										{{ __('admin.copy.equity') }}:<span class="text-{{$text}}">{{number_format( $copytrading->equity)}}%</span>
									</div>
									<div class="feature text-{{$text}}">
										{{ __('admin.copy.active_days') }}:<span class="text-{{$text}}">{{number_format( $copytrading->active_days)}} {{ __('admin.copy.days') }}</span>
									</div>
									<div class="feature text-{{$text}}">
										{{ __('admin.copy.expert_ratings') }}:
										@if($copytrading->rating==5)
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										@elseif($copytrading->rating==4)
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										@elseif($copytrading->rating==3)
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										@elseif($copytrading->rating==2)
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										@elseif($copytrading->rating==1)
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										 <span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										@endif

										<style>
											.checked {
							  color: orange !important;
							}
											</style>
									</div>
									
									
									
								</div> <br>
								
								<!-- Button -->
								<div class="text-center">
									<a href="{{route('editcopytrading',  $copytrading->id)}}" class="btn btn-primary"><i class="text-white flaticon-pencil"></i>
									</a> &nbsp; 
									<a href="{{ url('admin/dashboard/trashcopytrading') }}/{{ $copytrading->id}}" class="btn btn-danger"><i class="text-white fa fa-times"></i>
									</a>
								</div>
							</div>
						</div>	
						@empty
						<div class="col-lg-8">
							<div class="pricing-table card purple border bg-{{$bg}} shadow p-4">
								<h4 class="text-{{$text}}">{{ __('admin.copy.no_copytrading_plan_message') }}</h4>
							</div>
						</div>
						@endforelse
						
					</div>
				</div>
			</div>
			
	@endsection
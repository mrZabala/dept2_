@extends('layout.layout')
@section('header') 
@endsection
@section('content')
<section style="text-align: center;" id="appMain">
	<div style="display: inline-block; margin-top: 50px;">
		<template v-if="states.requestAccessActive == 0">
			<h2>This machine does not have access to CCC portal.</h2>
			<button class="btn btn-primary" v-on:click="states.requestAccessActive = 1">Request Access</button>
		</template>
		<template v-else-if="states.requestAccessActive == 1">
			<h2 class="m-b-30">Fill the following fields to request access to this machine</h2>
			<div style="text-align: left;">
				<div class="form-group">
					<label>Full Name</label>
					<input type="text" class="form-control" v-model="requestData.name">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" v-model="requestData.email">
				</div>
				<div class="form-group">
					<label>Department</label>
					<input type="text" class="form-control" v-model="requestData.department">
				</div>
				<button class="btn btn-success" v-on:click="requestAccess()">Request Access</button>
				<button class="btn btn-danger" v-on:click="states.requestAccessActive = 0">Cancel</button>
			</div>
		</template>
		<template v-else>
			<h2>Our administrators are processing your access request.</h2>
			<button class="btn btn-primary" v-on:click="states.requestAccessActive = 1">Request Access Again</button>
		</template>
		
	</div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
	var app = new Vue({
		el: '#appMain',
		data:{
			states:{
				requestAccessActive: 0
			},
			requestData:{
				name: '',
				email: '',
				department: ''
			}
		},
		methods: {
			requestAccess: function(){
				this.$http.get(homepath + '/RequestAccess', {params: {data: this.requestData}}).then(function(response){
					this.states.requestAccessActive = 2;
				})
			}
		}
	})

	@if(!is_null($requestedAccess)) app.states.requestAccessActive = 2; @endif
</script>
@endsection

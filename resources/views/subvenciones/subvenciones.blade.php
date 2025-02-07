@extends('layout.layout')

@include('layout.sidebar')
@section('content')
<section class="content" id='app'>
	<div class="page-heading">
        <h1>SYSTEM ADMINISTRATOR CONTROL PANEL</h1>
       
    </div>
    <div class="page-body">
    	<div class="panel panel-default">
            <div class="panel-heading">USER PERMISIONS CONTROL TAB</div>
            <div class="panel-body">
            	<table class="table table-striped table-hover dataTable users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Active</th>
                            <th>Admin</th>
                            <th>Manager</th>
                            <th>Supervisor</th>
                            <th>Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" v-cloak>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.email }}</td>
                            <td>@{{ user.username }}</td>
                            <td>
                                <div class="switch">
                                    <label><input type="checkbox" :checked="user.active == '1'" v-on:change="updateUserInformation(user.id, 'active', $event)"/><span class="lever"></span></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <label><input type="checkbox" :checked="user.isAdmin == '1'" v-on:change="updateUserInformation(user.id, 'isAdmin', $event)"/><span class="lever"></span></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <label><input type="checkbox" :checked="user.manager == '1'" v-on:change="updateUserInformation(user.id, 'manager', $event)"/><span class="lever"></span></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <label><input type="checkbox" :checked="user.supervisor == '1'" v-on:change="updateUserInformation(user.id, 'supervisor', $event)"/><span class="lever"></span></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <label><input type="checkbox" :checked="user.officer == '1'" v-on:change="updateUserInformation(user.id, 'officer', $event)"/><span class="lever"></span></label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       
    </div>
</section>

@endsection
@section('scripts')
	<script type="text/javascript">
		var homepath = '{{url("/")}}';
        var users = {!! json_encode($users) !!};

        var app = new Vue({
        el: '#app',
        data:{
            users:users
        },
        methods:{
            updateUserInformation: function(user_id ,field, event){
                console.log(user_id ,field, event)
            }
        },
        mounted: function(){
            
        }
    })
	</script>
  
@endsection
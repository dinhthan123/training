<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Users list</div>
            <div class="panel-body">
                <div class="form-group">
                    <router-link :to="{name: 'CreateUser'}" class="btn btn-success btn-create"><i class="fa fa-plus"></i> Create New User</router-link>
                    <div class="pull-right">
                        <form v-on:submit.prevent="ListUser()">
                            <input width="220px" type="text" v-model="keywords" class="form-control text-left" placeholder="Search">
                        </form>
                    </div>
                </div>

                <table class="table table-bordered table-striped table-list-data">
                    <thead>
                    <tr>
                        <th class="text-center" width="6%">ID</th>
                        <th class="text-left" width="16%">Name</th>
                        <th class="text-left" width="16%">Email</th>
                        <th class="text-center" width="10%">Birthday</th>
                        <th class="text-left" width="10%">Department</th>
                        <th class="text-left" width="20%">Address</th>
                        <th class="text-center" width="10%">Created</th>
                        <th class="text-center" width="12%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user, index in users">
                            <td class="text-center">{{ index+1 }}</td>
                            <td class="text-left">{{ user.name }}</td>
                            <td class="text-left">{{ user.email }}</td>
                            <td class="text-center">{{ user.birthday }}</td>
                            <td class="text-left">{{ user.department }}</td>
                            <td class="text-left">{{ user.address }}</td>
                            <td class="text-center">{{ user.created_at }}</td>
                            <td class="text-center">
                                <router-link :to="{name: 'EditUser', params: {id: user.id}}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </router-link>
                                <a href="#"
                                   class="btn btn-sm btn-danger"
                                   v-on:click="deleteEntry(user.id, index)">
                                    <i class="fa fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <tr v-if="!users.length">
                            <td colspan="8"><p>{{'No Record(s) to display.'}}</p></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="col-offset-md-6 col-md-6" v-if="users.length">
                    <paginate
                        :page-count="pageCount"
                        :click-handler="listUser"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination'">
                    </paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                keywords: null,
                users: [],
                pageCount:1,
                endpoint: '/api/v1/users?page='
            }
        },
        mounted() {
            this.listUser();
            // console.log(document.getElementById('app').innerHTML)
        },
        watch: {
            keywords(after, before) {
                this.listUser();
            }
        },
        methods: {
            listUser(page = 1) {
                let token = localStorage.getItem('token');
                let name = localStorage.getItem('user');

                axios.defaults.headers.common['Content-Type'] = 'application/json';
                axios.defaults.headers.common['Authorization'] = name + token;

                var app = this;
                axios.get(app.endpoint + page, {params:{keywords: this.keywords}})
                    .then(function (resp) {
                        app.users = resp.data.data;
                        app.pageCount = resp.data.meta.last_page;
                    })
                    .catch(function (resp) {
                        alert("Could not load users");
                    });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/users/' + id)
                        .then(function (resp) {
                            app.users.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete user");
                        });
                }
            }
        },
        // beforeRouteEnter (to, from, next) {
        //     if (!localStorage.getItem('token')) {
        //         return next('login');
        //     }
            
        //     next();
        // }
    }
</script>


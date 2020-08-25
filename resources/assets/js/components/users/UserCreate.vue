<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Create user</div>
            <div class="panel-body">
                <form v-on:submit.prevent="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 form-group" :class="{'has-error': errors.name}">
                            <label class="control-label">User name</label>
                            <input type="text" v-model="user.name" class="form-control">
                            <span v-if="errors.name" class="help-block">
                                <strong>{{ errors.name[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 form-group" :class="{'has-error': errors.email}">
                            <label class="control-label">Email</label>
                            <input type="text" v-model="user.email" class="form-control">
                            <span v-if="errors.email" class="help-block">
                                <strong>{{ errors.email[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-3 form-group" :class="{'has-error': errors.birthday}">
                            <label class="control-label">Birthday</label>
                            <datepicker v-model="user.birthday" name="uniquename" input-class="form-control" format="yyyy-MM-dd"></datepicker>
                            <span v-if="errors.birthday" class="help-block">
                                <strong>{{ errors.birthday[0] }}</strong>
                            </span>
                        </div>
                        <div class="col-xs-6 col-md-3 form-group" :class="{'has-error': errors.gender}">
                            <label class="control-label">Gender</label>
                            <select v-model="user.gender" class="form-control">
                                <option v-for="item in genders" :value="item.value">{{item.name}}</option>
                            </select>
                            <span v-if="errors.gender" class="help-block">
                                <strong>{{ errors.gender[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-3 form-group" :class="{'has-error': errors.department}">
                            <label class="control-label">Department</label>
                            <select v-model="user.department" class="form-control">
                                <option v-for="item in departments" :value="item.value">{{item.name}}</option>
                            </select>
                            <span v-if="errors.department" class="help-block">
                                <strong>{{ errors.department[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-3 form-group">
                            <label class="control-label">Avatar</label>
                            <input type="file" id="img" name="img" accept="image/*" v-on:change="onImageChange">
                            <span v-if="errors.avatar" class="help-block">
                                <strong>{{ errors.avatar[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 form-group" :class="{'has-error': errors.address}">
                            <label class="control-label">Address</label>
                            <textarea type="text" v-model="user.address" class="form-control" rows="6"></textarea>
                            <span v-if="errors.address" class="help-block">
                                <strong>{{ errors.address[0] }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 form-group">
                            <button class="btn btn-success">Save</button>
                            <button @click.prevent="reset()" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    let loader = null;

    export default {
        data: function () {
            return {
                errors: [],
                genders: [],
                departments: [],
                user: {
                    id: null,
                    name: '',
                    birthday: '',
                    gender: '',
                    email: '',
                    department: '',
                    address: ''
                }
            }
        },
        mounted() {
            this.findGender();
            this.findDepartment();
        },
        methods: {
            findGender() {
                let app = this;
                axios.get('/api/v1/users/gender')
                .then(function (resp) {
                    app.genders = resp.data;
                })
                .catch(function () {
                    alert("Could not load your gender")
                });
            },
            findDepartment() {
                let id = localStorage.getItem('userLoggedId');
                let app = this;
                axios.get('/api/v1/users/department')
                .then(function (resp) {
                    app.departments = resp.data;
                })
                .catch(function () {
                    alert("Could not load your department")
                });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(id){
                axios.patch('/api/v1/upload/avatar', {image: this.image, id: id}).then(response => {
                    if (response != undefined) {
                        console.log(response.data);
                    }
                });
            },
            saveForm() {
                this.errors = [];
                // show loading
                this.loaderShow();

                var newUser = this.user;
                axios.post('/api/v1/users', newUser)
                    .then(({data}) => this.setSuccessMessage(data))
                    .catch(({response}) => this.setErrors(response));
            },
            setErrors(response) {
            	if (response != undefined) {
                    this.errors = response.data.errors;
                }
                // hide loading
                this.loaderHide();
            },
            setSuccessMessage(data) {
                // upload
                this.uploadImage(data.id);

                // hide loading
                this.loaderHide();

                this.$router.push({path: '/'}); //  this.$router.replace('/');
            },

            reset() {
                this.errors = [];
                this.user = {name: null, email: null};
            },
            loaderShow() {
                loader = this.$loading.show();
            },
            loaderHide() {
                loader.hide();
            }
        }
    }
</script>

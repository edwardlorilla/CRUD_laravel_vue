<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" @submit.prevent="login"  ><div :class="{ 'has-error': errors.has('email'), 'form-group': true } ">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input v-validate data-vv-rules="required|email" v-model="form.email"  type="email" class="form-control" name="email"  required autofocus>
                            <span v-if="errors.has('email')" class="help-block">
                                <strong>{{ errors.first('email') }}</strong>
                                </span>
                            </div>
                        </div>
                        <div :class="{ 'has-error': errors.has('password'), 'form-group': true } ">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input v-validate  data-vv-name="password" data-vv-rules="required" v-model="form.password"  type="password" class="form-control" name="password"  required autofocus>
                                <span v-if="errors.has('password')" class="help-block">
                                    <strong>{{ errors.first('password') }}</strong>
                                    </span>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input v-model="form.remember" type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button-spinner
                                    type="submit"
                                    class="btn btn-primary"
                                    :isLoading="isSubmitted && !isSent"
                                    :disabled="isSent"
                                    :status="status">
                                    <span>Submit</span>
                                </button-spinner>
                                <a class="btn btn-link" href="">
                                    Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
<style>

</style>
<script>
    import ButtonSpinner from 'vue-button-spinner';
    export default{
        data(){
            return{
                form:{
                     email: '',
                     password: '',
                     remember: false
                 },
                isSubmitted: false,
                isSent: false,
                isValid: null,
                status: ''
            }
        },
        methods: {
            login(){
                var data = {
                client_id:2,
                client_secret: 'wkKuGKRDOPPQdPRFp7PEixHAdLiK6XV97KbzO6Lh',
                grant_type: 'password',
                username: this.form.email,
                password:this.form.password
                }
                // Submit the form via a POST request
                this.$http.post('/oauth/token', data)
                .then(response => {
                    this.$auth.setToken(response.body.access_token, response.body.expires_in + Date.now())
                    this.$router.go('/posts')
                    this.isSent = true;
                    this.status = 'success';
                }, (response) => {
                    console.log(response)
                    this.isSent = false;
                    this.status = 'error';
                });
                this.isSubmitted = true;
            }
        },
        components:{
            'button-spinner': ButtonSpinner
        }
    }
</script>

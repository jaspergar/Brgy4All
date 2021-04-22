<template lang="">
    <div class="container">
        <div class="wrapper">

            <div class="login_header">
               <h1>Login page</h1>
            </div>
            <form class="login_form">
                 <div class="space">
                     <Input type="text" v-model="data.email" placeholder="email"/>
                 </div>
                  <div class="space">
                     <Input type="password" v-model="data.password" placeholder="password"/>
                 </div>
                 <div class="login_footer">
                        <Button type="info" @click="login" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Logging in ...' : 'Login'}}</Button>
                 </div>

            </form>

        </div>
    </div>
</template>
<script>
export default {
    name: "Login",
    data(){
        return {
              data : {
                    email : '',
                    password: ''
                },
              isLogging: false,
        }
    },

    methods: {
         async login(){
             if(this.data.email.trim() =='') return this.error('Email is Required')
             if(this.data.password.trim() == '') return this.error('Password is Required')
             if(this.data.password.length < 6 ) return this.error('Incorrect password')
             
             this.isLogging = true

             const res = await this.callApi('post' , '/app/admin_login', this.data)
             if(res.status === 200){
                 window.location = '/'
                 this.success(res.data.msg)
             }else{
                 if(res.status===401){
                     this.error(res.data.msg)
                 }else{
                     this.swr()
                 }
             }
             this.isLogging = false

         }
    },
    
}
</script>
<style scoped>
  .wrapper{
   background: white;
  }  
</style>
<template>
    <div>
         <p class="text-center" v-if="loading">
             Loading...
         </p>
         <p class="text-center" v-else>
             <button class="btn btn-success" v-if="status == 0" @click="add_friend">Add friend</button>
             <button class="btn btn-success" v-if="status == 'pending'" @click="accept_friend">Accept friend</button>
             <button class="txet-success" v-if="status == 'waiting'">Waiting</button>
             <button class="text-success" v-if="status == 'friends'">Friend</button>
         </p>
    </div>
</template>

<script>
    export default {
        mounted() {
           axios.get('/check-relationship-status/' + this.profile_user_id).then(function(response) {
              console.log(response)
              this.status = response.data.status
              this.loading = false
           })
        },

        props: ['profile_user_id'],

        data() {
           return {
             status: '',
             loading: true
           }
        },

        methods: {
           add_friend() {
              this.loading = true
              axios.get('/add-friend/' + this.profile_user_id).then(function(response) {
                 if(response.data == 1)
                   this.status = 'waiting'
                   noty({
                      type: 'success',
                      layout: 'bottomLeft',
                      text: 'Friend request have been sent'
                   })
                   this.loading = false
                
              })
           },

           accept_friend() {
             this.loading = true
             axios.get('/accept-friend/' + this.profile_user_id).then(function(response) {
                if(response.data == 1)
                this.status = 'friends'
                noty({
                      type: 'success',
                      layout: 'bottomLeft',
                      text: 'You are now friend'
                })
                this.loading = false
             })
           }
        }
    }
</script>

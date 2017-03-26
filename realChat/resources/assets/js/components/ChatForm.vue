<template>
   <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">

        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage" :disabled="not_working">
               Send
            </button>
        </span>
    </div>
</template>

<script>
   export default {
      props: ['user'],

      data() {
         return {
            newMessage: '',
            not_working: true
         }
      },

      methods: {
         sendMessage() {
            this.$emit('messagesent', {
               user: this.user,
               message: this.newMessage
            })

            this.newMessage = ''
         }
      },

      watch: {
         newMessage() {
            if(this.newMessage.length > 0)
               this.not_working = false
            else
               this.not_working = true   
         }
      }
   }
</script>
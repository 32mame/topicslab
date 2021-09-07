<template>
  <div>
    <Card>
      <template #title>
        mypage
      </template>
      <template #content>
        {{user.name}}
        <div v-if="!isEdit">
          <div>
            {{user.description}}
          </div>
          <Button label="edit" v-on:click="isEdit=true" />
        </div>
        <div v-else>
          <Textarea v-model="description" :autoResize="true" rows="5" />
          <p>{{message}}</p>
          <Button label="Update" v-on:click="update" />
          <!-- {{user.description}} -->
        </div>
      </template>
      <template #footer>
        <Button label="Create Topic" v-on:click="toNewTopic" />
        <Button label="Logout" class="p-button-warning" v-on:click="logout" />
        <Button label="Withdraw" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'

function alert1 (errmessage) {
  alert(errmessage)
}

export default {
  name: 'Userself',
  data () {
    return {
      user: {},
      description: '',
      message: '',
      isEdit: false
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
      return
    }

    this.getUser()
  },
  methods: {
    toNewTopic () {
      this.$router.push('topic')
    },
    logout () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/logout')
            // user: user.id,
            // body: description
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/login')
            })
            .catch(err => {
              console.log(err)
              alert1(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    withdraw () {
      //
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/user')
            .then((res) => {
              if (res.status === 200) {
                this.user = res.data
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    update () {
      const description = this.description.trim()
      if (!description) {
        this.message = '未記入(空白のみ)は送信できません。'
        return
      }
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/update', {
            description: description
          })
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.isEdit = false
                this.user = res.data
              } else {
                this.message = '送信に失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
              this.message = '送信に失敗しました。'
            })
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
</style>

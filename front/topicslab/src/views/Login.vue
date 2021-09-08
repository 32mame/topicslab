<template>
  <div>
    <Card>
      <template #title>
        ログイン
      </template>
      <template #content>
        <div class="fields">
          <div class="p-field">
            <label for="email">メールアドレス</label>
            <InputText id="email" type="email" v-model="email" />
          </div>
          <div class="p-field">
            <label for="password">パスワード</label>
            <InputText id="password" type="password" v-model="password" />
          </div>
        </div>
        <span class="style-red">{{message}}</span><!--きっとここ６番赤にする問題-->
        <div class="p-field">
          <Button icon="pi pi-check" label="ログイン" v-on:click="login" />
        </div>
        <template v-if="loggedIn === false"><!--loggedInの値がfalseなら表示(逆にtrueは"loggedIn"ログイン単体)-->
          <div>
            <router-link to="/register">ユーザー登録</router-link>
          </div>
        </template>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'

function alert1 (errmessage) {
  window.alert(errmessage)
}

export default {
  name: 'Login',
  data () {
    return {
      email: '',
      password: '',
      error: false,
      message: '',
      loggedIn: false
    }
  },
  mounted () {
    this.loggedIn = localStorage.getItem('authenticated') === 'true'
  },
  methods: {
    login () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/login', {
            email: this.email,
            password: this.password
          })
            .then((res) => {
              if (res.status === 200) {
                console.log('ログイン成功')
                localStorage.setItem('authenticated', 'true')
              } else {
                this.message = 'ログインに失敗しました。'
              }
            })
            .catch((err) => {
              console.log(err)
              this.message = 'ログインに失敗しました。'
              alert1(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-content {
  .fields {
    text-align: center;
  }

  span.style-red {
    color: red;
  }

  .p-field {
    display: block;

    label {
      display: inline-block;
      width: 10em;
      margin-bottom: 10px;
    }

    .p-button {
      margin-top: 20px;
      display: block;
      width: 100%;
    }
  }
}
</style>

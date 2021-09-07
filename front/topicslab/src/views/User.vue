<template>
  <div>
    <Card>
      <template #content>
        {{user.name}}
        <div>
          <!-- <Textarea v-model="user.description" :autoResize="true" rows="5" /> -->
          {{user.description}}
        </div>
      </template>
    </Card>
      <TabView>
        <TabPanel header="トピック">
          <Card>
            aaa
          </Card>
        </TabPanel>
        <TabPanel header="コメント">
          aaa
        </TabPanel>
      </TabView>
  </div>
</template>

<script>
import axios from '@/supports/axios'

function alert1 (errmessage) {
  alert(errmessage)
}

export default {
  name: 'user',
  data () {
    return {
      id: null,
      user: {}
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }

    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getUser()
  },
  methods: {
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.user = res.data
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
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
